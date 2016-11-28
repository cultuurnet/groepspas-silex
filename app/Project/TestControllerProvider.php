<?php

namespace CultuurNet\GroepsPas\Project;

use CultuurNet\GroepsPas\Project\Controller\TestController;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * @file
 */
class TestControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['test_controller'] = function (Application $app) {
            return new TestController();
        };

        /* @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('/', 'test_controller:index');

        return $controllers;
    }
}
