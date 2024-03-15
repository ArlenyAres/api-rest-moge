<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel; 
use Illuminate\Foundation\Testing\RefreshDatabase; 
use Illuminate\Foundation\Testing\RefreshDatabaseState;

trait ResetsDatabase {
    use RefreshDatabase;
    
    protected function refreshTestDatabase()
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->shouldDropViews() ? [
                '--drop-views' => true,
            ] : []);

            $this->artisan('db:seed', []);
            $this->artisan('db:seed', [
                '--class' => 'TestDatabaseSeeder',
            ]);

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}