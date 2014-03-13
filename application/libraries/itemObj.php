<?php

/**
 * item in surveyObj
 * small structure object 
 * 
 */
class ItemObj 
{
	public $rank;
	public $index;
	public $num;
	public $value;

	function __construct($data = NULL)
	{
		if (isset($data))
		{
			$this->set($data);
		}
	}

	public function set(stdClass $data)
	{
		$this->index = $data->index;
		$this->num   = $data->num;
		$this->value   = $data->value;
	}

	public function set_rank($n)
	{
		$this->rank = $n;
	}
}
