<?php

//投票ページ
class V extends CI_Controller
{
	/* @var $_survey Survey */
	private $_survey;
	public function __construct()
    {
        parent::__construct();
    }

    public function Index()
    {
        echo "this is vote page";
    }
}