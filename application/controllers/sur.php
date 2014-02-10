<?php

class Sur extends CI_Controller
{
	/* @var $_survey Survey */
    private $_survey;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "Sur page.";
    }
}
?>