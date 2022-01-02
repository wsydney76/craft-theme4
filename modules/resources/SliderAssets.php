<?php

namespace modules\resources;

use craft\web\AssetBundle;

class SliderAssets extends AssetBundle
{
// https://splidejs.com/
    public function init()
    {

        $this->js = [
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-video@latest/dist/js/splide-extension-video.min.js'
        ];

        $this->css = [
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-video@latest/dist/css/splide-extension-video.min.css'
        ];
    }
}
