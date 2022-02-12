<?php

namespace modules\resources;

use craft\web\AssetBundle;

class SliderAssets extends AssetBundle
{
    public function init()
    {
        $this->js = [
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.11/dist/js/splide.min.js'
        ];

        $this->css = [
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.11/dist/css/splide.min.css'
        ];
    }
}
