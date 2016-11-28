<?php

namespace CultuurNet\GroepsPas;

use CultuurNet\GroepsPas\Project\ProjectControllerProvider;
use CultuurNet\GroepsPas\Project\TestControllerProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

/**
 * Application class for the groepspas app: web version.
 */
class WebApplication extends ApplicationBase
{
    public function __construct()
    {
        parent::__construct();
        $this->mountControllers();
        $this->after($this['cors']);
    }

    /**
     * Register all service providers.
     */
    protected function registerProviders()
    {
        parent::registerProviders();

        $this->register(new ServiceControllerServiceProvider());
        $this->register(
            new CorsServiceProvider(),
            [
                'cors.allowOrigin' => implode(' ', $this['config']['cors']['origins']),
                'cors.allowCredentials' => true,
            ]
        );

        $this->register(new RoutingServiceProvider());
    }

    /**
     * Register all controllers.
     */
    protected function mountControllers()
    {
        $this->mount('test', new TestControllerProvider());
    }
}
