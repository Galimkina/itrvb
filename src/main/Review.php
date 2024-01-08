<?php

//namespace src\main;

class Review
{
    public $text;
    public $user;
    public $product;

    public function __construct($product, $user, $text)
    {
        $this->product = $product;
        $this->user = $user;
        $this->text = $text;
    }

    public function view()
    {
        echo "<b>Продукт: </b>" . $this->getProduct() . "<br>" .
            "<b>Пользователь: </b>" . $this->getUser() . "<br>" .
            "<b>Текст: </b>" . $this->text;
    }

    public function getProduct()
    {
        return $this->product->name;
    }

    public function getUser()
    {
        return $this->user->name;
    }
}
