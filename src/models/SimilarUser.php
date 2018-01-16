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

use craft\elements\User;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class SimilarUser extends User
{
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
