<?php

namespace modules\resources;

use craft\web\AssetBundle;

class AmplitudeAssets extends AssetBundle
{
    public function init()
    {
        $this->js = ['https://cdn.jsdelivr.net/npm/amplitudejs@5.3.2/dist/amplitude.min.js'];
    }
}
