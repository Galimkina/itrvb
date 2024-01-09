<?php

abstract class Product
{
    protected $name;
    protected $price;

    public function __construct($name, $price) {

        $this->name = $name;
        $this->price = $price;
    }

    abstract public function finalCost();
}