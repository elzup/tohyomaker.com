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
		$this->load->library('voteObj');
		$this->load->library('surveyObj');
	}

	public function getSurvey($id_survey) 
	{
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get('vote_tbl', $where)->result('SurveyObj');
		print_r($result);
	}

	public function vote(VoteObj $vote)
	{
		$this->db->insert('vote_tbl', $vote->toArray())
	}

	private function getVotes($id_survey) {
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get('vote_tbl', $where)->result('VoteObj');
		return $result;
	}

}
