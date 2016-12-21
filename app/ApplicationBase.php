<?php

namespace CultuurNet\GroepsPas;

use CultuurNet\GroepsPas\Core\CoreProvider;
use CultuurNet\GroepsPas\Core\CultureFeedServiceProvider;
use DerAlex\Silex\YamlConfigServiceProvider;
use Silex\Application as SilexApplication;

/**
 * Base Application class for the groepspas application.
 */
class ApplicationBase extends SilexApplication
{

    public function __construct()
    {
        parent::__construct();

        // Load the config.
        $this->register(new YamlConfigServiceProvider(__DIR__ . '/../config.yml'));

        // Enable debug if requested.
        $this['debug'] = $this['config']['debug'] === true;

        $this->registerProviders();
    }

    /**
     * Register all service providers.
     */
    protected function registerProviders()
    {
        // Uitid
        $this->register(
            new CultureFeedServiceProvider(),
            [
                'culturefeed.endpoint' => $this['config']['uitid']['base_url'],
                'culturefeed.consumer.key' => $this['config']['uitid']['consumer']['key'],
                'culturefeed.consumer.secret' => $this['config']['uitid']['consumer']['secret'],

            ]
        );
    }
}
