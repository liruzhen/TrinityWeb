<?php

namespace core\modules\i18n\bundles;

use yii\web\AssetBundle;

/**
 * Contains css files necessary for modify translations on the live site (frontend translation).
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.2
 */
class FrontendTranslationAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@core/modules/i18n/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/helpers.css',
        'stylesheets/frontend-translation.css',
    ];
}