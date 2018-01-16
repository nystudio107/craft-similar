<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar\services;

use craft\base\Element;
use craft\base\ElementInterface;

use Craft;
use craft\base\Component;
use craft\elements\db\ElementQueryInterface;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use craft\helpers\ArrayHelper;
use yii\base\Exception;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class Similar extends Component
{
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
            throw new Exception("Required parameter `element` was not supplied to `craft.similar.find`.");
        }

        if (!isset($data['context'])) {
            throw new Exception("Required parameter `context` was not supplied to `craft.similar.find`.");
        }

        /** @var ElementInterface $element */
        $element = $data['element'];
        $context = $data['context'];
        $criteria = isset($data['criteria']) ? $data['criteria'] : [];
        if (is_object($criteria)) {
            /** @var ElementQueryInterface $criteria */
            $criteria = $criteria->toArray();
        }
        $reflector = new \ReflectionClass($element);
        $elementName = $reflector->getShortName();

        $modelName = 'nystudio107\similar\models\Similar'.$elementName;
        /** @var EntryQuery $query */
        $query = $this->getElementQuery($modelName, $criteria);

        if (!$query) { // no results
            return new Entry();
        }

        $preOrder = $query->orderBy;

        if (is_array($context)) {
            $tagIds = $context;
        } else {
            /** @var ElementQueryInterface $context */
            $tagIds = $context->ids();
        }

        /**
         * @TODO: this works, but it's gross. Ideally we could do all of the sorting
         *      and grouping in the ElementQuery as per the original code:
         *      https://github.com/aelvan/Similar-Craft/blob/master/similar/services/SimilarService.php#L56
         *      If we use asArray(true) we can prevent it from trying to create the elements
         *      with fields that don't exist ('count'):
         *      https://stackoverflow.com/questions/24389765/how-to-count-and-group-by-in-yii2
         *      but the grouping is still wrong. Also apparently orderBy() isn't passed through to the
         *      query object, as per Brandon ¯\_(ツ)_/¯
         */
        //$query->addSelect(['COUNT(*) as count']);
        //$query->orderBy('count DESC, ' . str_replace('`', '', $preOrder));
        //$query->asArray(true);
        $query->andWhere('elements.id != :id', ['id' => $element->id]);
        $query->andWhere(['in', '{{%relations}}.targetId', $tagIds]);
        $query->leftJoin('{{%relations}}', 'elements.id={{%relations}}.sourceId');
        $query->groupBy('{{%relations}}.sourceId');
        $results = $query->all();

        // Group the resulting Elements by id
        $results = ArrayHelper::index(
            $results,
            null,
            [function ($model) {
                return $model->id;
            }]
        );
        // Convert the array of arrays to an array of models with a `count` of the number of models
        $models = [];
        foreach ($results as $result) {
            /** @var Element $model */
            $model = $result[0];
            $config = $model->toArray();
            $config['count'] = count($result);
            $models[] = new $modelName($config);
        }
        // Sort the array of models by the number of elements
        ArrayHelper::multisort($models,
            function($model) {
                return $model->count;
            },
            SORT_DESC
        );

        return $models;
    }

    // Protected Methods
    // =========================================================================

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
