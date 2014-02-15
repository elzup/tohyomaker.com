<?php

class Survey extends CI_Model
{
	/*
	 * 単票オブジェクトの配列
	 * votes Array of Vote
	 */
	public $votes;

	function __construct($id_survey)
	{
		parent::__construct();
		$this->load->database();
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get('vote_tbl', $where)->result('object');
		print_r($result);
	}
}
