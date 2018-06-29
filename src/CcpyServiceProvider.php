<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/6/29
 * Time: 下午4:23
 */
namespace Hycooc\Ccpy;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CcpyServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     */
    public function setupConfig()
    {
        $source = realpath($raw = __DIR__ . '/../config/ccpy.php') ?: $raw;

        if ($this->app instanceof Application && $this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('ccpy.php')
            ]);
        }

        $this->mergeConfigFrom($source, 'ccpy');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     */
    protected function registerFactory()
    {
        $this->app->singleton('ccpy.factory', function () {
            return new CcpyFactory();
        });
        $this->app->alias('ccpy.factory', CcpyFactory::class);
    }

    /**
     * Register the manager class.
     */
    protected function registerManager()
    {
        $this->app->singleton('hashids', function (Container $app) {
            $config  = $app['config'];
            $factory = $app['ccpy.factory'];

            return new CcpyManager($config, $factory);
        });
        $this->app->alias('ccpy', CcpyManager::class);
    }

    /**
     * Register the bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind('ccpy.connection', function (Container $app) {
            $manager = $app['ccpy'];

            return $manager->connection();
        });
        $this->app->alias('ccpy.connection', CcpyInstance::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'ccpy',
            'ccpy.factory',
            'ccpy.connection',
        ];
    }
}