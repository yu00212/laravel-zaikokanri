<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Paginator::useBootstrap(); //ペジネーションリンクにbootstrapを使用

        //$url->forceScheme('http'); //ローカル環境の場合はhttpに。
        // ペジネーションリンクをhttps対応（.env APP_ENV=localでない場合https化）
        if (!$this->app->environment('local')) {
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
