<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar\models;

use Craft;
use craft\elements\Entry;
use craft\elements\db\EntryQuery;
use craft\elements\db\ElementQueryInterface;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class SimilarEntry extends Entry
{
    // Static methods
    // =========================================================================

    /**
     * @inheritdoc
     *
     * @return EntryQuery The newly created [[EntryQuery]] instance.
     */
    public static function find(): ElementQueryInterface
    {
        return new EntryQuery(SimilarEntry::class);
    }

    // Public Properties
    // =========================================================================

    /**
     * @var int
     */
    public $count;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['count', 'integer'],
            ['count', 'default', 'value' => 0],
        ]);
    }
}
