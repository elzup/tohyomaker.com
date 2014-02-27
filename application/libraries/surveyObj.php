<?php

class SurveyObj
{
	/*
	 * 単票オブジェクトの配列
	 * _votes Array of VoteObj
	 */

	private $_votes;

	function __construct(array $votes = null)
	{
		if ($votes)
		{
			$this->addVoteAll($votes);
		}
	}

	public function addVoteAll(array $votes)
	{
		foreach ($votes as $vote)
		{
			/* var $vote VoteObj */
			$this->_vote[] = $vote;
		}
	}

	public function addVote(VoteObj $vote)
	{
		$this->_vote[] = $vote;
	}

}
