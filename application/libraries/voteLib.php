<?php
class Vote
{
	/*
	 * id_vote
	 */
	public $id_vote;
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
	/*
	 * 投票時間
	 */
	public $timestamp;

	public function __toString()
	{
		return <<<EOF
Vote Object
id_vote   : {$this->id_vote}
id_owner  : {$this->id_owner}
id_survey : {$this->id_survey}
id_survey : {$this->id_survey}
timestamp : {$this->timestamp}
EOF;
	}

//	function __construct(array $data)
//	{
//		parent::__construct();
//		$this->id_owner  = $data['id_owner'];
//		$this->id_survey = $data['id_survey'];
//		$this->value     = $data['value'];
//	}
}
