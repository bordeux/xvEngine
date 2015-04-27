<?php

namespace XV\Bundle\EngineBundle\Component\Form\Input;


use XV\Bundle\EngineBundle\Classes\Component\Form\AbstractInput;

class TextInputComponent extends AbstractInput {

  
    
    public function init() {
        $this->initValidationMessages();
        $this->setComponentName('form.input.textInputComponent');
        $this->setType("text");
        parent::init();
    }

    
    public function initValidationMessages(){
        $this->setValidatorMessage("mustBeEqual", "Fields must be equal");
        $this->setValidatorMessage("maxLength", "Value is too big");
        $this->setValidatorMessage("minLength", "Value is too short");
        $this->setValidatorMessage("required", "This field is required");
        $this->setValidatorMessage("email", "Invalid email address");
        $this->setValidatorMessage("mustValidRegex", "Invalid value");
    }
    
    /**
     * 
     * @param int $size
     * @return TextInputComponent
     */
    public function setMinLength($size = null) {
        $this->setParam('minLength', $size);
        return $this;
    }

   
    /**
     * 
     * @param int $size
     * @return TextInputComponent
     */
    public function setMaxLength($size = null) {
        $this->setParam('maxLength', $size);
        return $this;
    }

   
    /**
     * 
     * @param string $word
     * @return TextInputComponent
     */
    public function mustContain($word = null) {
        $this->setParam('mustContain', $word);
        return $this;
    }

    
    /**
     * 
     * @param string $value
     * @return TextInputComponent
     */
    public function mustBeEqual($value = null) {
        $this->setParam("mustBeEqual", $value);
        return $this;
    }

    /**
     *
     * @param string $value
     * @return TextInputComponent
     */
    public function mustBeNotEqual($value = null) {
        $this->setParam("mustBeNotEqual", $value);
        return $this;
    }

   
    /**
     * 
     * @param array $list
     * @return TextInputComponent
     */
    public function mustBeIn($list = null) {
        $this->setParam("mustBeIn", $list);
        return $this;
    }
    
    /**
     * 
     * @param string $value
     * @return TextInputComponent
     */
    public function setPlaceholder($value) {
        $this->setParam("placeholder", $value);
        return $this;
    }

    /**
     * 
     * @param string $value
     * @return TextInputComponent
     */
    public function mustValidRegex($value, $flags= null) {
        $this->setParam("mustValidRegex", $value);
        $this->setParam("mustValidRegexFlags", $flags);
        return $this;
    }

  
    /**
     * 
     * @param string $type
     * @return TextInputComponent
     */
    public function setType($type) {
        $this->setParam("type", $type);
        return $this;
    }

}
