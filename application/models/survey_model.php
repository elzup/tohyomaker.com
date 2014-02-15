<?php

class Survey_model extends CI_Model
{
	/*
	 * 単票オブジェクトの配列
	 * votes Array of Vote
	 */
	public $votes;

	function __construct()
	{
		parent::__construct();
	}

	function getSurvey($id_survey) 
	{
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get('vote_tbl', $where)->result('object');
		print_r($result);
	}
}
