<?php

class Bar {
    public $bar;
    public function __construct() {
        $this->bar = 'bar';
    }
}

class Foo extends Bar {
    public function __construct() {
        parent::__construct();
        var_dump($this->bar);
    }
}

$foo = new Foo;
?>
