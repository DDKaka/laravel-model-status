<?php

namespace Spatie\ModelStatus\Tests;

use CreateStatusesTable;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\ModelStatus\ModelStatusServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelStatusServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('validation_test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        include_once __DIR__.'/../database/migrations/create_statuses_table.php.stub';

        (new CreateStatusesTable())->up();
    }
}
