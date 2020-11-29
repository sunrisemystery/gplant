<?php


class Plant
{
    private $name;
    private $type;
    private $image;


    public function __construct($name, $type, $image)
    {
        $this->name = $name;
        $this->type = $type;
        $this->image = $image;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName( string $name)
    {
        $this->name = $name;
    }


    public function getType(): string
    {
        return $this->type;
    }


    public function setType(string $type)
    {
        $this->type = $type;
    }


    public function getImage(): string
    {
        return $this->image;
    }


    public function setImage( string $image)
    {
        $this->image = $image;
    }






}