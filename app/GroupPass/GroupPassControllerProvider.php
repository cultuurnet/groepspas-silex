<?php

namespace CultuurNet\GroepsPas\GroupPass;

use CultuurNet\GroepsPas\GroupPass\Controller\GroupPassController;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * @file
 */
class GroupPassControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['group_pass_controller'] = function (Application $app) {
            return new GroupPassController($app['culturefeed_uitpas']);
        };

        /* @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('/{id}', 'group_pass_controller:getGroupPassInfo');

        return $controllers;
    }
}
