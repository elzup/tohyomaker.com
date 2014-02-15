<?php

//投票ページ
class Poll extends CI_Controller
{
	/* @var $_survey Survey */
	private $_survey;
	public function __construct()
    {
        parent::__construct();
    }

    public function Index($id_survey = 0)
    {
		$this->load->model('survey');
//		$this->_survey = new Survey($id_survey);
//		print_r($this->_survey);
    }
}