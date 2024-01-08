<?php

//namespace src\main;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($id, $name, $email, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function view()
    {
        echo "<b>Имя пользователя: </b>" . $this->name . "<br>" .
            "<b>Почта: </b>" . $this->email . "<br>" .
            "<b>Пароль: </b>" . $this->password;
    }
}