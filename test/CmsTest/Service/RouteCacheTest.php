<?php

namespace CmsTest\Service;

use Cms\Service\RouteCache;
use PHPUnit_Framework_TestCase;

/**
 * Class RouteCache
 *
 * @package CmsTest\Service
 */
class RouteCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Cms\Service\RouteCache
     */
    protected $service;

    public function setUp()
    {
        $this->service = new RouteCache;
    }

    public function tearDown()
    {
        unset($this->model);
    }

    /**
     * Since it writes to the filesystem, this is a functional test
     */
    public function testRebuild()
    {
        $testFile = '/tmp/routeCacheTest';
        $this->service->setCacheFile($testFile);

        $pageModelMock = $this->getMock(
            'Cms\Model\Page',
            array('getPublishedRoutes')
        );
        $pageModelMock->expects($this->once())
            ->method('getPublishedRoutes')
            ->will($this->returnValue(array('testroute1', 'testroute2')));

        $this->service->setPageModel($pageModelMock);

        $this->service->rebuild();

        // Now check the file
        $this->assertFileExists($testFile);
        $contents = file_get_contents($testFile);

        $this->assertEquals('testroute1|testroute2', $contents);
    }

    public function testRebuildWithNoFile()
    {
        $this->setExpectedException(
            'Exception',
            'Cannot rebuild route cache because no file is provided in config.'
        );

        $this->service->rebuild();
    }
}
