<?php

//投票ページ
class Survey extends CI_Controller
{
	/* @var $_survey Survey */
	private $_survey;
	public function __construct()
    {
        parent::__construct();
    }

    public function Index($id_survey = 0)
    {
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->_survey = $this->survey->getSurvey($id_survey);
		echo "<pre>";
		print_r($this->_survey);
//		$this->_survey = new Survey($id_survey);
    }
}