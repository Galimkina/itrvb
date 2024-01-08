<?php

//namespace src\main;

class Basket
{
    public $products = [];

    public function addBasket($product)
    {
        $this->products[] = $product;
    }

    public function count()
    {
        $count = 0;
        foreach ($this->products as $product) {
            $count ++;
        }
        return $count;
    }

    public function view()
    {
        foreach ($this->products as $product) {
            echo $product->name . "<p>";
        }
    }
    public function getPrice()
    {
        $summ = 0;
        foreach ($this->products as $product) {
            $summ += $product->price;
        }
        return $summ;
    }

    public function deleteProduct($product)
    {
        $key = array_search($product, $this->products);
        if ($key !== false) {
            unset($this->products[$key]);
        }
    }
}
