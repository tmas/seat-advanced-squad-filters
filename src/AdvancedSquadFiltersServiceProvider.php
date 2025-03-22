<?php

namespace Tmas\AdvancedSquadFilters;

use Seat\Services\AbstractSeatPlugin;

class AdvancedSquadFiltersServiceProvider extends AbstractSeatPlugin
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'myplugin');
        
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        // Include menu
        $this->mergeConfigFrom(__DIR__ . '/Config/Menu/package.sidebar.php', 'package.sidebar');

        // Merge the config
        $this->mergeConfigFrom(__DIR__ . '/Config/advanced-squad-filters.config.php', 'advanced-squad-filters.config');
        
        // Add permissions
        $this->registerPermissions(__DIR__ . '/Config/Permissions/advanced-squad-filters.php');

        // Add view composers
        $this->add_view_composers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
    
    /**
     * Get the package's name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Advanced Squad Filters';
    }
    
    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     */
    public function getPackageNamespace(): string
    {
        return 'advanced-squad-filters';
    }
    
    /**
     * Return the plugin repository address.
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/tmas/seat-advanced-squad-filters';
    }
    
    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     */
    public function getPackagistPackageName(): string
    {
        return 'tmas/seat-advanced-squad-filters';
    }
    
    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     */
    public function getPackagistVendorName(): string
    {
        return 'tmas';
    }

    private function add_view_composers()
    {
        // Squad filter rules
        $this->app['view']->composer([
            'advanced-squad-filters::squads.edit',
        ], AdvancedCharacterFilter::class);
    }
} 