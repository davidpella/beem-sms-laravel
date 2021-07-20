<?php

namespace DavidPella\BeemSms\Tests;

use DavidPella\BeemSms\BeemSmsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            BeemSmsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../database/migrations/create_users_table.php';

        (new \CreateUsersTable())->up();
    }
}
