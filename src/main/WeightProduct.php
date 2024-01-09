<?php

class WeightProduct extends Product
{
    protected $weight;

    public function __construct($name, $price, $weight)
    {
        parent::__construct($name, $price);
        $this->weight = $weight;
    }

    public function view()
    {
        echo "<b>Товар: </b>" . $this->name . "<br>" .
            "<b>Цена: </b>" . $this->price . " рублей <br>" .
            "<b>Вес: </b>" . $this->weight . " кг <br>" .
            "<b>Итого: </b>" . $this->finalCost() . " рублей";
    }

    public function finalCost()
    {
        return $this->price * $this->weight;
    }
}