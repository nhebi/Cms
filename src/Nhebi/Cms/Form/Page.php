<?php

namespace Cms\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Fieldset;

class Page extends Form
{
    public function __construct()
    {
        // Call the parent constructor
        parent::__construct('page');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'Hidden'
            )
        );

        $this->add(
            array(
                'name' => 'title',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Title'
                )
            )
        );

        $this->add(
            array(
                'name' => 'route',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Route'
                )
            )
        );

        $this->add(
            array(
                'name' => 'content',
                'type' => 'Textarea',
                'options' => array(
                    'label' => 'Content'
                ),
                'attributes' => array(
                    'rows' => 8
                )
            )
        );


        $this->add(
            array(
                'name' => 'status',
                'type' => 'Zend\Form\Element\Select',
                'options' => array(
                    'label' => 'Status'
                ),
                'attributes' => array(
                    'options' => array(
                        'published' => 'Published',
                        'draft' => 'Draft'
                    )
                )
            )
        );

        $this->add($this->getButtonFieldset());
    }

    public function getButtonFieldset()
    {
        // Fieldset for buttons
        $buttons = new Fieldset('buttons');
        $buttons->setAttribute('class', 'well well-small');

        // Add the save button
        $save = new Element\Submit('submit');
        $save->setValue('Save');
        $save->setAttribute('class', 'btn btn-primary');
        $buttons->add($save);

        return $buttons;
    }
}
