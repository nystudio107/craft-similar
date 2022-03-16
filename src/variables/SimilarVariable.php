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

use craft\base\ElementInterface;
use nystudio107\similar\Similar;
use yii\base\Exception;

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
     * @param array $data
     *
     * @return array|ElementInterface
     * @throws Exception
     */
    public function find(array $data): array|ElementInterface
    {
        return Similar::$plugin->similar->find($data);
    }
}
