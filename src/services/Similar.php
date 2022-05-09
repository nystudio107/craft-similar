<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce
 * Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar\services;

use Craft;
use craft\base\Component;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\db\Table;
use craft\elements\db\ElementQuery;
use craft\elements\db\ElementQueryInterface;
use craft\elements\db\EntryQuery;
use craft\events\CancelableEvent;
use yii\base\Exception;
use function is_array;
use function is_object;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class Similar extends Component
{
    // Public Properties
    // =========================================================================

    /**
     * @var string|array The previous order in the query
     */
    public string|array $preOrder = [];

    /**
     * @var ?int
     */
    public ?int $limit = null;

    /**
     * @var Element[]
     */
    public array $targetElements = [];

    // Public Methods
    // =========================================================================

    /**
     * @param array $data
     *
     * @return array|ElementInterface
     * @throws Exception
     */
    public function find(array $data): array|ElementInterface
    {
        if (!isset($data['element'])) {
            throw new Exception('Required parameter `element` was not supplied to `craft.similar.find`.');
        }

        if (!isset($data['context'])) {
            throw new Exception('Required parameter `context` was not supplied to `craft.similar.find`.');
        }

        /** @var Element $element */
        $element = $data['element'];
        $context = $data['context'];
        $criteria = $data['criteria'] ?? [];

        if (is_object($criteria)) {
            /** @var ElementQueryInterface $criteria */
            $criteria = $criteria->toArray();
        }

        // Get an ElementQuery for this Element
        $elementClass = is_object($element) ? $element::class : $element;
        /** @var EntryQuery $query */
        $query = $this->getElementQuery($elementClass, $criteria);

        // Stash any orderBy directives from the $query for our anonymous function
        $this->preOrder = $query->orderBy;
        $this->limit = $query->limit;
        // Extract the $tagIds from the $context
        if (is_array($context)) {
            $tagIds = $context;
        } else {
            /** @var ElementQueryInterface $context */
            $tagIds = $context->ids();
        }

        $this->targetElements = $tagIds;

        // We need to modify the actual craft\db\Query after the ElementQuery has been prepared
        $query->on(ElementQuery::EVENT_AFTER_PREPARE, fn(CancelableEvent $event) => $this->eventAfterPrepareHandler($event));
        // Return the data as an array, and only fetch the `id` and `siteId`
        $query->asArray(true);
        $query->select(['elements.id', 'elements_sites.siteId']);
        $query->andWhere(['not', ['elements.id' => $element->getId()]]);

        // Unless site criteria is provided, force the element's site.
        if (empty($criteria['siteId']) && empty($criteria['site'])) {
            $query->andWhere(['elements_sites.siteId' => $element->siteId]);
        }

        $query->andWhere(['in', 'relations.targetId', $tagIds]);
        $query->leftJoin(['relations' => Table::RELATIONS], '[[elements.id]] = [[relations.sourceId]]');

        $results = $query->all();

        // Fetch the elements based on the returned `id` and `siteId`
        $queryConditions = [];
        $similarCounts = [];

        // Build the query conditions for a new element query.
        // The reason we have to do it in two steps is because the `count` property is added by a behavior after element creation
        // So if we just try to tack that on in the original query, it will throw an error on element creation
        foreach ($results as $config) {
            $siteId = $config['siteId'];
            $elementId = $config['id'];

            if ($elementId && $siteId) {
                if (empty($queryConditions[$siteId])) {
                    $queryConditions[$siteId] = [];
                }

                // Write down elements per site and similar counts
                $queryConditions[$siteId][] = $elementId;
                $key = $siteId . '-' . $elementId;
                $similarCounts[$key] = $config['count'];
            }
        }

        if (empty($results)) {
            return [];
        }

        // Fetch all the elements in one fell swoop, including any preset eager-loaded conditions
        $query = $this->getElementQuery($elementClass, $criteria);

        // Make sure we fetch the elements that are similar only
        $query->on(ElementQuery::EVENT_AFTER_PREPARE, function (CancelableEvent $event) use ($queryConditions): void {
            /** @var ElementQuery $query */
            $query = $event->sender;
            $first = true;

            foreach ($queryConditions as $siteId => $elementIds) {
                $method = $first ? 'where' : 'orWhere';
                $query->subQuery->$method(['and', [
                    'elements_sites.siteId' => $siteId,
                    'elements.id' => $elementIds]
                ]);
            }
        });

        $elements = $query->all();

        foreach ($elements as $element) {
            // The `count` property is added dynamically by our CountBehavior behavior
            $key = $element->siteId . '-' . $element->id;
            if (!empty($similarCounts[$key])) {
                /** @noinspection PhpUndefinedFieldInspection */
                $element->count = $similarCounts[$key];
            }
        }

        if (empty($criteria['orderBy'])) {
            usort($elements, static fn($a, $b) => $a->count < $b->count ? 1 : ($a->count == $b->count ? 0 : -1));
        }

        return $elements;
    }

    protected function eventAfterPrepareHandler(CancelableEvent $event): void
    {
        /** @var ElementQuery $query */
        $query = $event->sender;
        // Add in the `count` param so we know how many were fetched
        $query->query->addSelect(['COUNT(*) as count']);
        if (is_array($this->preOrder)) {
            $query->query->orderBy(array_merge([
                'count' => 'DESC',
            ], $this->preOrder));
        } elseif (is_string($this->preOrder)) {
            $query->query->orderBy('count DESC, ' . str_replace('`', '', $this->preOrder));
        }

        $query->query->groupBy(['relations.sourceId', 'elements.id', 'elements_sites.siteId']);

        $query->query->andWhere(['in', 'relations.targetId', $this->targetElements]);

        $query->subQuery->limit(null); // inner limit to null -> fetch all possible entries, sort them afterwards
        $query->query->limit($this->limit); // or whatever limit is set

        $query->subQuery->groupBy(['elements.id', 'content.id', 'elements_sites.id']);

        if ($query instanceof EntryQuery) {
            $query->subQuery->addGroupBy(['entries.postDate']);
        }

        if ($query->withStructure || ($query->withStructure !== false && $query->structureId)) {
            $query->subQuery->addGroupBy(['structureelements.structureId', 'structureelements.lft']);
        }

        $event->isValid = true;
    }

    /**
     * Returns the element query based on $elementType and $criteria
     *
     * @param string|ElementInterface $elementType
     * @param array $criteria
     * @return ElementQueryInterface
     */
    protected function getElementQuery(string|ElementInterface $elementType, array $criteria): ElementQueryInterface
    {
        /** @var string|ElementInterface $elementType */
        $query = $elementType::find();
        Craft::configure($query, $criteria);

        return $query;
    }
}
