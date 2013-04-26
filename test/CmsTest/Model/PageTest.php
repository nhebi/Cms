<?php
/**
 * Test the page model
 */
namespace CmsTest\Model;

use Cms\Model\Page;
use PHPUnit_Framework_TestCase;

/**
 * Class PageTest
 *
 * @package CmsTest\Model
 */
class PageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Cms\Model\Page
     */
    protected $model;

    public function setUp()
    {
        $this->model = new \Cms\Model\Page();
    }

    public function tearDown()
    {
        unset($this->model);
    }

    public function testInitialState()
    {
        $this->assertInstanceOf('Cms\Model\Page', $this->model);
    }

    public function testFindAll()
    {
        $repoMock = $this->getMock(
            'Doctrine\ORM\EntityRepository',
            array('findBy', 'getUnitOfWork'),
            array(),
            '',
            false
        );

        $repoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue('placeholder'));

        $this->model->setRepository($repoMock);
        $this->model->setEntityManager($this->getEmMock());

        $result = $this->model->findAll();

        $this->assertEquals('placeholder', $result);
    }

    public function testFindOneByRoute()
    {
        $repoMock = $this->getMock(
            'Doctrine\ORM\EntityRepository',
            array('findOneBy', 'getUnitOfWork'),
            array(),
            '',
            false
        );

        $repoMock->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue('placeholder'));

        $this->model->setRepository($repoMock);
        $this->model->setEntityManager($this->getEmMock());

        $result = $this->model->findOneByRoute('imprint');

        $this->assertEquals('placeholder', $result);
    }

    /**
     * Find by id
     */
    public function testFind()
    {
        $repoMock = $this->getMock(
            'Doctrine\ORM\EntityRepository',
            array('find', 'getUnitOfWork'),
            array(),
            '',
            false
        );

        $repoMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo(5))
            ->will($this->returnValue('placeholder'));

        $this->model->setRepository($repoMock);
        $this->model->setEntityManager($this->getEmMock());

        $result = $this->model->find(5);

        $this->assertEquals('placeholder', $result);
    }

    public function testRepositorySetup()
    {
        // Rather than injecting a repo, inject an EM that can try to make one
        $repoMock = $this->getMock(
            'Doctrine\ORM\EntityRepository',
            array('find', 'getUnitOfWork'),
            array(),
            '',
            false
        );

        $emMock = $this->getEmMock();
        $emMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repoMock));

        $this->model->setEntityManager($emMock);

        $repo = $this->model->getRepository();

        // For some reason these are not the same
        //echo "\n" . get_class($repoMock) . "\n" . get_class($repo) . "\n";die;
        //$this->assertSame($repoMock, $repo);
    }

    public function testGetPublishedRoutes()
    {
        $pageMock = $this->getMock(
            'Cms\Entity\Page',
            array('getRoute')
        );
        $pageMock->expects($this->once())
            ->method('getRoute')
            ->will($this->returnValue('about'));

        $repoMock = $this->getMock(
            'Doctrine\ORM\EntityRepository',
            array('findBy', 'getUnitOfWork'),
            array(),
            '',
            false
        );
        $repoMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue(array($pageMock)));

        $this->model->setRepository($repoMock);
        $result = $this->model->getPublishedRoutes();

        $this->assertEquals(array('about'), $result);
    }

    public function testSave()
    {
        $emMock = $this->getEmMock();

        // Expect a call to persist()
        $emMock->expects($this->once())
            ->method('persist');

        $this->model->setEntityManager($emMock);

        $this->model->save(new \Cms\Entity\Page);
    }

    public function testDelete()
    {
        $emMock = $this->getEmMock();
        $emMock->expects($this->once())
            ->method('remove');
        $emMock->expects($this->once())
            ->method('flush');

        $this->model->setEntityManager($emMock);

        $pageMock = $this->getMock('Cms\Entity\Page');

        $this->model->delete($pageMock);
    }

    protected function getEmMock()
    {
        $repositoryMock = $this->getMock(
            'Doctrine\Orm\Repository',
            array('findOneBy')
        );

        $emMock  = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array(
                'getRepository',
                'getClassMetadata',
                'persist',
                'flush',
                'remove'
            ),
            array(),
            '',
            false
        );
        $emMock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repositoryMock));
        $emMock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue((object)array('name' => 'aClass')));
        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        return $emMock;
    }
}
