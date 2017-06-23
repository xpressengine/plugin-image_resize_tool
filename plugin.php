<?php
namespace Xpressengine\Plugins\ImageResizer;

use XeFrontend;
use XePresenter;
use Route;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행됩니다.
     *
     * @return void
     */
    public function boot()
    {
        // implement code

        $this->route();
    }

    protected function route()
    {
        // implement code

        Route::fixed(
            $this->getId(),
            function () {
                Route::get(
                    '/popup/create',
                    [
                        'as' => 'image_resize_tool::popup',
                        'uses' => function (Request $request) {

                            $title = '이미지 리사이즈, 편집 에디터툴';

                            // set browser title
                            XeFrontend::title($title);

                            //header, footer 제거
                            \XeTheme::selectBlankTheme();

                            XeFrontend::css([
                                asset('assets/vendor/bootstrap/css/bootstrap.min.css'),
                                $this->asset('assets/vendor/jquery-ui.css'),
                                $this->asset('assets/vendor/jquery.Jcrop.css'),
                            ])->appendTo('head')->load();

                            XeFrontend::js([
                                $this->asset('assets/vendor/load-image.all.min.js'),
                                $this->asset('assets/vendor/jquery-ui.js'),
                                $this->asset('assets/vendor/jquery.Jcrop.js'),
                            ])->appendTo('body')->load();

                            // output
                            return XePresenter::make('image_resize_tool::views.popup');

                        }
                    ]
                );

                Route::get(
                    '/popup/edit',
                    [
                        'as' => 'image_resize_tool::popup.edit',
                        'uses' => function (Request $request) {

                            $title = '이미지 리사이즈, 편집 에디터툴';

                            // set browser title
                            XeFrontend::title($title);

                            //header, footer 제거
                            \XeTheme::selectBlankTheme();

                            XeFrontend::css([
                                asset('assets/vendor/bootstrap/css/bootstrap.min.css'),
                                $this->asset('assets/vendor/jquery-ui.css'),
                                $this->asset('assets/vendor/jquery.Jcrop.css'),
                            ])->appendTo('head')->load();

                            XeFrontend::js([
                                $this->asset('assets/vendor/load-image.all.min.js'),
                                $this->asset('assets/vendor/jquery-ui.js'),
                                $this->asset('assets/vendor/jquery.Jcrop.js'),
                            ])->appendTo('body')->load();

                            // output
                            return XePresenter::make('image_resize_tool::views.popup-edit');

                        }
                    ]
                );
            }
        );

    }

    /**
     * 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
        // implement code
    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
        // implement code
    }

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 설치된 상태(true)를 반환한다.
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstalled()
    {
        // implement code

        return parent::checkInstalled();
    }

    /**
     * 플러그인을 업데이트한다.
     *
     * @return void
     */
    public function update()
    {
        // implement code
    }

    /**
     * 해당 플러그인이 최신 상태로 업데이트가 된 상태라면 true, 업데이트가 필요한 상태라면 false를 반환함.
     * 이 메소드를 구현하지 않았다면 기본적으로 최신업데이트 상태임(true)을 반환함.
     *
     * @return boolean 플러그인의 설치 유무,
     */
    public function checkUpdated()
    {
        // implement code

        return parent::checkUpdated();
    }
}
