<?php
class Shop extends CI_Controller
{
    private $_user;
    public function __construct()
    {
        parent::__construct();
        $this->_user = 'ゲストさん';
    }

    public function index() {
        echo "Shop top page";
        $this->greet();
    }

    public function greet($surname=NULL, $firstname=NULL)
    {
        if (is_null($surname) ) {
            echo 'Hell, ' . $this->_user .'.';
        }
        else {
            echo 'Hello, '.$surname;
            if (! is_null($firstname)) {
                echo ' ' . $firstname;
            }
        }
    }
}
?>
