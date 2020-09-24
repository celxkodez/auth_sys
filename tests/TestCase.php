<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    // public function setUp()
    // {
    //     parent::setUp();
    //     Artisan::call('db:seed');
    // }

    protected function setUp(): void
    {
        parent::setUp();
        // $this->markTestSkipped(
        //     'This test will be skipped when you run `php-unit`.'
        // );
    }
}
