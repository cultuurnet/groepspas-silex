<?php

/**
 * @file
 */

namespace CultuurNet\GroepsPas\GroupPass\Controller;

use CultureFeed_Uitpas_Default;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupPassControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \CultuurNet\GroepsPas\GroupPass\Controller\GroupPassController
     */
    protected $groupPassController;

    /**
     * @var CultureFeed_Uitpas_Default|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cultureFeedUitpas;


    /**
     * Setup the service with mock objects.
     */
    public function setUp()
    {
          $this->cultureFeedUitpas = $this->getMockBuilder(CultureFeed_Uitpas_Default::class)
              ->disableOriginalConstructor()
              ->getMock();

          $this->groupPassController = new GroupPassController($this->cultureFeedUitpas);
    }

    public function testGetGroupPassInfo()
    {
          $data = file_get_contents('./test/data/GroupPass/Controller/group-pass-controller-test.json');

          $this->cultureFeedUitpas
            ->method('getGroupPass')
            ->willReturn($data);

          $expectedResult = new JsonResponse($data);
          $id = 1000000265008;

          $testResult = $this->groupPassController->getGroupPassInfo($id);
          $this->assertEquals($expectedResult, $testResult);

    }
}