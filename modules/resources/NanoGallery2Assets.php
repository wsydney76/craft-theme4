<?php

namespace modules\resources;

use craft\web\AssetBundle;
use yii\web\JqueryAsset;

class NanoGallery2Assets extends AssetBundle
{
    public function init()
    {
        $this->depends = [JqueryAsset::class];

        $this->css = ['https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/css/nanogallery2.min.css'];

        $this->js = ['https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/jquery.nanogallery2.min.js'];
    }
}
