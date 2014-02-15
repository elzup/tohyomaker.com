<?php

class Vote extends CI_Model
{
	/*
	 * 投票者ID
	 */
	public $id_owner;
	/*
	 * 投票ID
	 */
	public $id_survey;
	/*
	 * 投票内容
	 */
	public $value;

	function __construct(array $data)
	{
		parent::__construct();
		$this->id_owner  = $data['id_owner'];
		$this->id_survey = $data['id_survey'];
		$this->value     = $data['value'];

		$this->load->database();
	}
}