<?php

class PhysicalProduct extends Product
{
    protected $quantity;

    public function __construct($name, $price, $quantity)
    {
        parent::__construct($name, $price);
        $this->quantity = $quantity;
    }

    public function view()
    {
        echo "<b>Товар: </b>" . $this->name . "<br>" .
            "<b>Цена: </b>" . $this->price . " рублей <br>" .
            "<b>Количество: </b>" . $this->quantity . " шт <br>" .
            "<b>Итого: </b>" . $this->finalCost() . " рублей";
    }

    public function finalCost()
    {
        return $this->price * $this->quantity;
    }
}