<?php

namespace XV\Bundle\EngineBundle\Component\Nav;



class NavComponentItem implements \JsonSerializable
{
    /**
     * ID of item
     * @var string
     */
    protected $id;

    /**
     * Link url
     * @var string
     */
    protected $href;

    /**
     * Label of item
     * @var string
     */
    protected $label;


    public function __construct($id, $href, $label){
        $this->id = $id;
        $this->href = $href;
        $this->label = $label;
    }


    function jsonSerialize()
    {
        return array(
            "id" => $this->id,
            "label" => $this->label,
            "href" => $this->href
        );
    }
}
