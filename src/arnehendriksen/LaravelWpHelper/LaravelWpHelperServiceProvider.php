<?php namespace arnehendriksen\LaravelWpHelper;

use Illuminate\Support\ServiceProvider;

class LaravelWpHelperServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('wp-helper.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WpHelper::class, function ($app) {

            $table_prefix = $this->app['config']->get('wp-helper.table_prefix');

            return new WpHelper($table_prefix);

        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wp-helper'];
    }
}
