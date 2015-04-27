<?php

namespace XV\Bundle\EngineBundle\Component\Button;


use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;

class ButtonComponent extends AbstractComponent
{

    public function init()
    {
        $this->setComponentName('button.buttonComponent');
    }


    /**
     *
     * @param string $text
     * @return ButtonComponent
     */
    public function setText($text)
    {
        $this->setParam('text', $text);
        return $this;
    }


    /**
     *
     * @param boolean $value
     * @return ButtonComponent
     */
    public function disable($value = true)
    {
        $this->setParam("disable", $value);
        return $this;
    }


    /**
     *
     * @param string $url
     * @return ButtonComponent
     */
    public function setUrl($url)
    {
        $this->setParam("url", $url);
        return $this;
    }

    /**
     *
     * @param string $val
     * @return ButtonComponent
     */
    public function stopPropagation($val = true)
    {
        $this->setParam("stopPropagation", !!$val);
        return $this;
    }

}
