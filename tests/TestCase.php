<?php

namespace Zerp\Slack\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Zerp\Slack\Providers\SlackServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [SlackServiceProvider::class];
    }
}
