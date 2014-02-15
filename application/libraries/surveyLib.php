<?php

class SurveyObj
{
	/*
	 * 単票オブジェクトの配列
	 * _votes Array of Vote
	 */
	private $_votes;

	function __construct(array $votes)
	{
		parent::__construct();
	}

	public function addVote(Vote $vote)
	{
		$this->_vote[] = $vote;
	}
}
