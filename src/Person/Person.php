<?php
namespace Itrvb\galimova\Person;

use DateTimeImmutable;

class Person
{
    public function __construct(
        public $id,
        private Name $name,
        private DateTimeImmutable $regiseredOn
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->id . "<b> Автор: </b>" . $this->name . ' (на сайте с ' . $this->regiseredOn->format('Y-m-d') . ')';
    }
}