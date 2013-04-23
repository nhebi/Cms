<?php

namespace CmsTest\Form;

use Cms\Form\Page;
use PHPUnit_Framework_TestCase;

/**
 * Class PageTest
 *
 * @package CmsTest\Form
 */
class CmsTest extends PHPUnit_Framework_TestCase
{
    protected $form;

    public function setUp()
    {
        $this->form = new Page;
    }

    public function testFormConstruction()
    {
        $this->assertInstanceOf('Cms\Form\Page', $this->form);

        // Make sure the elements are present
        $this->assertNotEmpty($this->form->get('title'));
        $this->assertNotEmpty($this->form->get('content'));
        $this->assertNotEmpty($this->form->get('id'));
        $this->assertNotEmpty($this->form->get('status'));
    }
}
