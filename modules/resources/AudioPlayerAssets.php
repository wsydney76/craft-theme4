<?php

namespace modules\resources;

use craft\web\AssetBundle;
use yii\web\JqueryAsset;

/*
 * http://tympanus.net/codrops/2012/12/04/responsive-touch-friendly-audio-player/
 */
class AudioPlayerAssets extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/AudioPlayer';

        $this->depends = [
            JqueryAsset::class,
        ];

        $this->js = [
            'js/audioplayer.js',
        ];

        $this->css = [
          'css/custom.css'
        ];

        parent::init();
    }
}
