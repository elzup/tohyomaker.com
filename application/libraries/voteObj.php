<?php

class VoteObj
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

	public function __construct(array $data = NULL)
	{
		if (isset($data))
		{
			foreach ($data as $key => $value)
			{
				$this->{$key} = $value;
			}
		}
	}

	/*
	 * return array object combarted from class fields
	 */
	public function toArray() {
		$arr = array(
			'id_vote' => $this->id_vote,
			'id_survey' => $this->id_survey,
			'id_owner' => $this->id_owner,
			'value' => $this->value,
//			'timestamp' => $this->timestamp,
		);
		return $arr;
	}

	public function __toString()
	{
		return <<<EOF
Vote Object
id_vote   : {$this->id_vote}
id_owner  : {$this->id_owner}
id_survey : {$this->id_survey}
value     : {$this->value}
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
