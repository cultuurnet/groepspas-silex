<?php

namespace CultuurNet\GroepsPas\GroupPass\Controller;

use CultureFeed_Uitpas_Default;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * GroupPass controller
 */
class GroupPassController
{

    /**
     * @var \ICultureFeed
     */
    protected $cultureFeedUitpas;


    /**
     * GroupPassController constructor.
     */
    public function __construct(CultureFeed_Uitpas_Default $cultureFeedUitpas)
    {
        $this->cultureFeedUitpas = $cultureFeedUitpas;
    }

    /**
     * Function to get the group pass information
     * @param Request $request
     * @return JsonResponse
     */
    public function getGroupPassInfo(Request $request, $id)
    {
        $pass = $this->cultureFeedUitpas->getGroupPass($id);

        return new JsonResponse($pass);
    }
}
