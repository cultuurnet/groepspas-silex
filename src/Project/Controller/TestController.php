<?php

namespace CultuurNet\GroepsPas\Project\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dummy controller
 */
class TestController
{
    /**
     * TestController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Dummy callback
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return new JsonResponse('dummy controller');
    }
}
