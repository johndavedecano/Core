<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 3:02 PM
 */

namespace Jdecano\Core\Providers;

use Jdecano\Core\Commands\MakeRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoriesProvider
 * @package Jdecano\Core\Providers
 */
class RepositoriesProvider extends ServiceProvider {
    public function boot() {
        $this->app['make:repository'] = $this->app->share(function($app)
        {
            return new MakeRepository();
        });

        $this->commands('make:repository');
    }
    public function register() {}
}


