<?php

namespace CultuurNet\GroepsPas;

use CultuurNet\GroepsPas\Core\Exception\ValidationException;
use CultuurNet\GroepsPas\ErrorHandler\JsonErrorHandler;
use CultuurNet\GroepsPas\GroupPass\GroupPassControllerProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        // Add custom error handler for json requests.
        if (!$this['debug']) {
            $errorHandler = new JsonErrorHandler();
            // Access denied exceptions (403)
            $this->error(
                function (AccessDeniedHttpException $e, Request $request) use ($errorHandler) {
                    return $errorHandler->handleAccessDeniedExceptions($e, $request);
                }
            );
            // Validation exceptions (400)
            $this->error(
                function (ValidationException $e, Request $request) use ($errorHandler) {
                    return $errorHandler->handleValidationExceptions($e, $request);
                }
            );
            // Code exceptions (400)
            $this->error(
                function (\CultureFeed_InvalidCodeException $e, Request $request) use ($errorHandler) {
                    return $errorHandler->handleInvalidCodeExceptions($e, $request);
                }
            );
            // Not found exceptions (404)
            $this->error(
                function (NotFoundHttpException $e, Request $request) use ($errorHandler) {
                    return $errorHandler->handleNotFoundExceptions($e, $request);
                }
            );
            // General exceptions (500)
            $this->error(
                function (\Exception $e, Request $request) use ($errorHandler) {
                   return $errorHandler->handleException($e, $request);
                }
            );
        }
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
        $this->mount('group-pass', new GroupPassControllerProvider());
    }
}
