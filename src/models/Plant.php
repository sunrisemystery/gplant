<?php


class Plant
{
    private $id;
    private $name;
    private $last_watered;
    private $image;
    private $type;

    public function __construct($name,  $image)
    {
        $this->name = $name;
        $this->image = $image;
    }



    public function countDays() {
        $currentString = date("Y-m-d");
        $current = date_create($currentString);
        $last = date_create($this->last_watered);
        $seconds = $current - $last;
        $days = date_diff($last,$current);
        $days = $days->format('%a day(s)');
        return $days;

    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function setName( string $name)
    {
        $this->name = $name;
    }

    public function getImage(): string
    {
        return $this->image;
    }


    public function setImage( string $image)
    {
        $this->image = $image;
    }


    public function getLastWatered()
    {
        return $this->last_watered;
    }

    public function setLastWatered($last_watered): void
    {
        $this->last_watered = $last_watered;
    }


    public function getType(): int
    {
        return $this->type;
    }


    public function setType($type): void
    {
        $this->type = $type;
    }








}