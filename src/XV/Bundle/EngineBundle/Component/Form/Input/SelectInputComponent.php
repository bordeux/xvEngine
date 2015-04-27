<?php

namespace XV\Bundle\EngineBundle\Component\Form\Input;

use XV\Bundle\EngineBundle\Component\Form\AbstractInput;

class SelectInputComponent extends AbstractInput {

    
    public function init() {
        $this->setComponentName('form.input.selectInputComponent');
        parent::init();
    }

    
    /**
     * 
     * @param array $list
     * @return SelectInputComponent
     */
    public function setList(array $list){
        $this->setParam("list", $list);
        return $this;
    }
    
    
    public static function arrayToList(array $list){
        $result = [];
        foreach($list as $key => $label){
            $result[] = [
                "value" => $key,
                "label" => $label
            ];
        }
        return $result;
    }

}
