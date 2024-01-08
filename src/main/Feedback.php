<?php

//namespace src\main;

class Feedback
{
    public $user;
    public $message;

    public function __construct($user, $message) {
        $this->user = $user;
        $this->message = $message;
    }

    public function view() {
        echo "<b>Пользователь: </b>" . $this->getUser() . "<br>" .
            "<b>Пожелания: </b>" . $this->message;
    }
    public function getUser()
    {
        return $this->user->name;
    }
}