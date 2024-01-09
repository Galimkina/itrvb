<?php

class DigitalProduct extends Product
{
    public function __construct($name, $price)
    {
        parent::__construct($name, $price);
    }
    public function view()
    {
        echo "<b>Товар: </b>" . $this->name . "<br>" .
            "<b>Цена: </b>" . $this->price . " рублей <br>" .
            "<b>Итого: </b>" . $this->finalCost() . " рублей";
    }
    public function finalCost()
    {
        return $this->price / 2;
    }
}
