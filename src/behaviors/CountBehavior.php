<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar\behaviors;

use yii\base\Behavior;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class CountBehavior extends Behavior
{
    // Public Properties
    // =========================================================================

    /**
     * @var int
     */
    public int $count = 0;

    // Public Methods
    // =========================================================================

}
