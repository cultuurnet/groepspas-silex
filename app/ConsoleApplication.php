<?php

namespace CultuurNet\GroepsPas;

use Silex\Application as SilexApplication;

/**
 * Application class for the groepspas app: console version.
 */
class ConsoleApplication extends ApplicationBase
{

    public function __construct()
    {
        parent::__construct();
        $this->registerCommands();
    }

    /**
     * Register all service providers.
     */
    protected function registerProviders()
    {
        parent::registerProviders();
    }

    /**
     * Register all commands.
     */
    protected function registerCommands()
    {
        //
    }
}
