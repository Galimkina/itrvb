<?php

class ProductItem extends Product
{
    public $image;
    public $characteristic;

    public function __construct($id, $name, $description, $price, $characteristic, $image) {
        parent::__construct($id, $name, $description, $price);
        $this->image = $image;
        $this->characteristic = $characteristic;
    }

    public function view()
    {
        echo
            '<b>Название: </b>' . $this->name . "<br>" .
            "<b>Описание: </b>" .$this->description . "<br>" .
            "<b>Цена: </b>" . $this->price . "<br>" .
            "<b>Характеристики: </b>" . $this->characteristic . "<br>" .
            "<img src='" . $this->image . "'width='300' height='200'>";
    }
}