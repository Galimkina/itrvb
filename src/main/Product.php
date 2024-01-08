<?php

//namespace src\main;

class Product
{
    public $name;
    public $id;
    public $description;
    public $price;

   public function __construct($id, $name, $description, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function view()
    {
        echo
            "<b>Название: </b>" . $this->name . "<br>" .
            "<b>Описание: </b>" .$this->description . "<br>" .
            "<b>Цена: </b>" . $this->price;
    }
}
