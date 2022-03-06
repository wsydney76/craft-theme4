<?php

namespace modules\guide\assetbundles;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class GuideAssets extends AssetBundle
{
    public function init(): void
    {
        parent::init();

        // define the path that your publishable resources live
        $this->sourcePath = __DIR__ .'/resources';

        $this->depends = [CpAsset::class];

        $this->css = ['guide.css'];
    }
}