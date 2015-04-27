<?php

namespace XV\Bundle\EngineBundle\Classes\Component\Form;

use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;


abstract class AbstractInput extends AbstractComponent
{

    private $validatorMessages = [];

    /**
     * Set label to input
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->setParam('label', $label);
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->setParam("value", $value);
        return $this;
    }


    /**
     * @return array
     */
    public function getValue()
    {
        return $this->getParam("value");
    }


    /**
     * Set field required
     * @param bool $value
     * @return $this
     */
    public function setRequired($value = true)
    {
        $this->setParam('required', $value);
        return $this;
    }


    /**
     * Hide this field
     * @param bool $value
     * @return $this
     */
    public function setHidden($value = true)
    {
        $this->setParam('hidden', $value);
        return $this;
    }


    /**
     * @param string $value
     * @param string $message
     * @return $this
     */
    public function setValidatorMessage($value, $message)
    {
        $this->validatorMessages[$value] = $message;
        return $this;
    }


    /**
     * Disable this field
     * @param bool $val
     * @return $this
     */
    public function disable($val = true)
    {
        $this->setParam('disable', !!$val);
        return $this;
    }

    /**
     *
     */
    public function init()
    {
        $this->setLabel("");
        $this->setRequired(false);
        $this->setHidden(false);
        $this->setParamByRef("validatorMessages", $this->validatorMessages);
        parent::init();
    }


}
