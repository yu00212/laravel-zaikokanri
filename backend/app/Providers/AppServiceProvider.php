<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\UrlGenerator;

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
    //public function boot(UrlGenerator $url)
    //{
    //$url->forceScheme('https');
    //$this->app['request']->server->set('HTTPS', 'on');
    //}

    public function boot(UrlGenerator $url)
    {
        // ペジネーションリンクをhttps対応（.env APP_ENV=localでない場合https化）
        if (!$this->app->environment('local')) {
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
