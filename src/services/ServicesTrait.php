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

use nystudio107\similar\services\Similar as SimilarService;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107.com
 * @package   Similar
 * @since     1.0.0
 *
 * @property  SimilarService $similar
 */
trait ServicesTrait
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function config(): array
    {
        return [
            'components' => [
                'similar' => SimilarService::class,
            ],
        ];
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the similar service
     *
     * @return SimilarService The similar service
     * @throws InvalidConfigException
     */
    public function getSimilar(): SimilarService
    {
        return $this->get('similar');
    }
}
