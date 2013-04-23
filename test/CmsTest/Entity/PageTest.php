<?php
/**
 * Test the page entity
 */
namespace CmsTest\Entity;

use Cms\Entity\Page;
use PHPUnit_Framework_TestCase;

/**
 * Class PageTest
 *
 * @package CmsTest\Entity
 */
class PageTest extends PHPUnit_Framework_TestCase
{
    public function testInitialState()
    {
        $page = new Page;

        $this->assertInstanceOf('Cms\Entity\Page', $page);

        $this->assertNull($page->getId());
        $this->assertNull($page->getTitle());
        $this->assertNull($page->getRoute());
        $this->assertNull($page->getContent());
        $this->assertNull($page->getStatus());
        $this->assertNull($page->getCreated());
        $this->assertNull($page->getUpdated());
        $this->assertNull($page->getUpdater());
    }

    public function testSetters()
    {
        $page = new Page;

        $page->setTitle('Imprint');
        $this->assertEquals('Imprint', $page->getTitle());

        $page->setRoute('imprint');
        $this->assertEquals('imprint', $page->getRoute());

        $page->setContent('lorem ipsum');
        $this->assertEquals('lorem ipsum', $page->getContent());

        $page->setStatus('published');
        $this->assertEquals('published', $page->getStatus());

        $now = new \DateTime('now');
        $page->setCreated($now);
        $this->assertEquals($now, $page->getCreated());

        $page->setUpdated($now);
        $this->assertEquals($now, $page->getUpdated());

    }
}
