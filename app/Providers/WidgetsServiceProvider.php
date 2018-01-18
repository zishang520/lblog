<?php

namespace App\Providers;

use Arrilot\Widgets\Console\WidgetMakeCommand;
use Arrilot\Widgets\Factories\AsyncWidgetFactory;
use Arrilot\Widgets\Factories\WidgetFactory;
use Arrilot\Widgets\Misc\LaravelApplicationWrapper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WidgetsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__ . '/config/config.php', 'laravel-widgets'
        // );

        $this->app->bind('arrilot.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper());
        });

        $this->app->bind('arrilot.async-widget', function () {
            return new AsyncWidgetFactory(new LaravelApplicationWrapper());
        });

        $this->app->singleton('arrilot.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper());
        });

        $this->app->singleton('command.widget.make', function ($app) {
            return new WidgetMakeCommand($app['files']);
        });

        $this->commands('command.widget.make');

        $this->app->alias('arrilot.widget', WidgetFactory::class);
        $this->app->alias('arrilot.async-widget', AsyncWidgetFactory::class);
        $this->app->alias('arrilot.widget-group-collection', WidgetGroupCollection::class);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__ . '/config/config.php' => config_path('laravel-widgets.php'),
        // ]);

        $routeConfig = [
            'namespace' => 'Arrilot\Widgets\Controllers',
            'prefix' => 'arrilot',
            'middleware' => $this->app['config']->get('laravel-widgets.route_middleware', []),
        ];

        if (!$this->app->routesAreCached()) {
            $this->app['router']->group($routeConfig, function ($router) {
                $router->get('load-widget', 'WidgetController@showWidget');
            });
        }

        $omitParenthesis = version_compare($this->app->version(), '5.3', '<');

        Blade::directive('widget', function ($expression) use ($omitParenthesis) {
            $expression = $omitParenthesis ? $expression : "($expression)";

            return "<?php echo app('arrilot.widget')->run{$expression}; ?>";
        });

        Blade::directive('asyncWidget', function ($expression) use ($omitParenthesis) {
            $expression = $omitParenthesis ? $expression : "($expression)";

            return "<?php echo app('arrilot.async-widget')->run{$expression}; ?>";
        });

        Blade::directive('widgetGroup', function ($expression) use ($omitParenthesis) {
            $expression = $omitParenthesis ? $expression : "($expression)";

            return "<?php echo app('arrilot.widget-group-collection')->group{$expression}->display(); ?>";
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['arrilot.widget', 'arrilot.async-widget'];
    }
}
