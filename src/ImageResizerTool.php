<?php

namespace Xpressengine\Plugins\ImageResizer;

use App\Facades\XeFrontend;
use Xpressengine\Editor\AbstractTool;

class ImageResizerTool extends AbstractTool
{
    public function initAssets()
    {
        XeFrontend::html('image_resize_tool.load_url')->content("
        <script>
            (function() {
                var _url = {
                    popup: '".route('image_resize_tool::popup')."'
                };
                
                window.imageResizeURL = {
                    get: function (type) {
                        return _url[type];                 
                    }
                };
            })();
        </script>
        ")->load();
        XeFrontend::js([
            asset($this->getAssetsPath() . '/ImageResizerTool.js'),
        ])->load();
    }

    public function getIcon()
    {
        return asset($this->getAssetsPath() . '/icon.png');
    }

    public function compile($content)
    {
        return $content;
    }

    private function getAssetsPath()
    {
        return str_replace(base_path(), '', realpath(__DIR__ . '/../assets'));
    }
}