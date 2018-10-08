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
use craft\elements\db\ElementQuery;
use craft\elements\db\ElementQueryInterface;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use craft\events\CancelableEvent;

use yii\base\Exception;

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
     * @var string The previous order in the query
     */
    public $preOrder;

    public $limit;

    public $targetElements;
    // Public Methods
    // =========================================================================

    /**
     * @param $data
     *
     * @return mixed
     * @throws Exception
     */
    public function find($data)
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
        if (\is_object($criteria)) {
            /** @var ElementQueryInterface $criteria */
            $criteria = $criteria->toArray();
        }

        // Get an ElementQuery for this Element
        $elementClass = \is_object($element) ? \get_class($element) : $element;
        /** @var EntryQuery $query */
        $query = $this->getElementQuery($elementClass, $criteria);

        // If the $query is null, just return an empty Entry
        if (!$query) { // no results
            return new Entry();
        }

        // Stash any orderBy directives from the $query for our anonymous function
        $this->preOrder = $query->orderBy;
        $this->limit = $query->limit;
        // Extract the $tagIds from the $context
        if (\is_array($context)) {
            $tagIds = $context;
        } else {
            /** @var ElementQueryInterface $context */
            $tagIds = $context->ids();
        }
        $this->targetElements = $tagIds;

        // We need to modify the actual craft\db\Query after the ElementQuery has been prepared
        $query->on(ElementQuery::EVENT_AFTER_PREPARE, [$this, 'eventAfterPrepareHandler']);
        // Return the data as an array, and only fetch the `id` and `siteId`
        $query->asArray(true);
        $query->select(['elements.id', 'elements_sites.siteId']);
        $query->andWhere('elements.id != :id', ['id' => $element->id]);
        $query->andWhere(['in', '{{%relations}}.targetId', $tagIds]);
        $query->leftJoin('{{%relations}}', 'elements.id={{%relations}}.sourceId');
        $results = $query->all();

        // Fetch the elements based on the returned `id` and `siteId`
        $elements = Craft::$app->getElements();
        $models = [];
        foreach ($results as $config) {
            if($config['id'] && $config['siteId']) {
                $model = $elements->getElementById($config['id'], $elementClass, $config['siteId']);
                if ($model) {
                    // The `count` property is added dynamically by our CountBehavior behavior
                    /** @noinspection PhpUndefinedFieldInspection */
                    $model->count = $config['count'];
                    $models[] = $model;
                }
            }
        }

        return $models;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @param CancelableEvent $event
     */
    protected function eventAfterPrepareHandler(CancelableEvent $event)
    {
        /** @var ElementQuery $query */
        $query = $event->sender;
        // Add in the `count` param so we know how many were fetched
        $query->query->addSelect(['COUNT(*) as count']);
        $query->query->orderBy('count DESC, '.str_replace('`', '', $this->preOrder));
        $query->query->groupBy(['{{%relations}}.sourceId', 'elements.id']);

        $query->query->andWhere(['in', '{{%relations}}.targetId', $this->targetElements]);
        $query->subQuery->limit(null); // inner limit to null -> fetch all possible entries, sort them afterwards
        $query->query->limit($this->limit); // or whatever limit is set

        $query->subQuery->groupBy(['structureelements.lft', 'elements.id']);
        $event->isValid = true;
    }

    /**
     * Returns the element query based on $elementType and $criteria
     *
     * @var string|ElementInterface $elementType
     * @var array                   $criteria
     *
     * @return ElementQueryInterface
     */
    protected function getElementQuery($elementType, array $criteria): ElementQueryInterface
    {
        /** @var string|ElementInterface $elementType */
        $query = $elementType::find();
        Craft::configure($query, $criteria);

        return $query;
    }
}
