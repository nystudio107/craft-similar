<?php
/**
 * Similar plugin for Craft CMS 3.x
 *
 * Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... other related elements.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107.com
 */

namespace nystudio107\similar\variables;

use nystudio107\similar\Similar;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 */
class SimilarVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param $data
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function find($data): array|\craft\elements\Entry
    {
        return Similar::$plugin->similar->find($data);
    }
}
