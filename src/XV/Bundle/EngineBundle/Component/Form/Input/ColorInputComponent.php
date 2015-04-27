<?php

namespace XV\Bundle\EngineBundle\Component\Form\Input;

use XV\Bundle\EngineBundle\Component\Form\AbstractInput;

class ColorInputComponent extends AbstractInput
{
    public function init()
    {
        $this->setComponentName('form.input.colorInputComponent');
        parent::init();
    }


    /**
     * @param bool $value
     * @return $this
     */
    public function setInline($value = false){
        return $this->setParam("inline", !!$value);
    }
}