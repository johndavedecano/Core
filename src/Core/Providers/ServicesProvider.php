<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 3:02 PM
 */

namespace Jdecano\Core\Providers;

use Jdecano\Core\Commands\MakeService;
use Illuminate\Support\ServiceProvider;

/**
 * Class ServicesProvider
 * @package Jdecano\Core\Providers
 */
class ServicesProvider extends ServiceProvider {
    public function boot() {
        $this->app['make:service'] = $this->app->share(function($app)
        {
            return new MakeService();
        });

        $this->commands('make:service');
    }
    public function register() {
        $this->app->bind('Jdecano\Core\Services\Contracts\ServiceLocatorInterface', 'Jdecano\Core\Services\ServiceLocator');
        $this->app->bind('Jdecano\Core\Services\Contracts\ServiceInterface', 'Jdecano\Core\Services\AbstractService');
    }
}


