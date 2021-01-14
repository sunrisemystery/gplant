<?php


class GeneralPlant
{
    private $type;
    private $image;
    private $mainDescription;
    private $waterDescription;

    public function __construct($type, $image, $mainDescription, $waterDescription)
    {
        $this->type = $type;
        $this->image = $image;
        $this->mainDescription = $mainDescription;
        $this->waterDescription = $waterDescription;
    }


    public function getType()
    {
        return $this->type;
    }


    public function getImage()
    {
        return $this->image;
    }


    public function getMainDescription()
    {
        return $this->mainDescription;
    }


    public function getWaterDescription()
    {
        return $this->waterDescription;
    }


}