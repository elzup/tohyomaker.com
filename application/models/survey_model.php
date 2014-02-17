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
		define('TBL_VOTE'  , 'vote_tbl'  );
		define('TBL_SURVEY', 'survey_tbl');
	}

	public function getSurvey($id_survey) 
	{
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get(TBL_SURVEY, $where)->result('object');
		print_r($result);
	}

	public function insertVote(UserObj $user, SurveyObj $survey, VoteObj $vote)
	{
		$this->db->insert(TBL_VOTE, $vote->toArray());
	}


	private function getVotes($id_survey) {
		$where = array (
			'id_survey' => $id_survey,
		);
		$result = $this->db->get(TBL_VOTE, $where)->result('VoteObj');
		return $result;
	}

}
