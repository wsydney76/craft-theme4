<?php
/**
 * Created by PhpStorm.
 * User: wsydn
 * Date: 25.03.2019
 * Time: 13:04
 */

namespace modules\resources\cp;

use craft\web\AssetBundle;
use yii\web\JqueryAsset;

class CpAssets extends AssetBundle
{
    /** @inheritdoc */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/dist';

        $this->depends = [
            JqueryAsset::class
        ];

        $this->css = [
         'cp_styles.css'
        ];

        $this->js = [
          'cp_scripts.js'
        ];

        parent::init();
    }
}
