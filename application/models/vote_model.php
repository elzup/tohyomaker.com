<?php

class Vote_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function vote(VoteObj $vote)
	{
		if ($this->db->insert('vote_tbl', $vote->toArray()))
		{
			echo "OK";
		}
	}

	public function getVotes
}
