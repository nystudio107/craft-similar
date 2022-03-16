<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar;

use Craft;
use craft\base\Element;
use craft\base\Plugin;
use craft\elements\db\ElementQuery;
use craft\events\PopulateElementEvent;
use craft\web\twig\variables\CraftVariable;
use nystudio107\similar\behaviors\CountBehavior;
use nystudio107\similar\services\Similar as SimilarService;
use nystudio107\similar\variables\SimilarVariable;
use yii\base\Event;

/**
 * Class Similar
 *
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 *
 * @property  SimilarService $similar
 */
class Similar extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ?Similar
     */
    public static ?Similar $plugin = null;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSection = false;
    /**
     * @var bool
     */
    public bool $hasCpSettings = false;

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'similar' => SimilarService::class,
        ];

        parent::__construct($id, $parent, $config);
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            static function (Event $event): void {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('similar', SimilarVariable::class);
            }
        );
        Event::on(
            ElementQuery::class,
            ElementQuery::EVENT_AFTER_POPULATE_ELEMENT,
            static function (PopulateElementEvent $event): void {
                /** @var Element $element */
                $element = $event->element;
                $element->attachBehavior('myCountBehavior', CountBehavior::class);
            });

        Craft::info(
            Craft::t(
                'similar',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}
