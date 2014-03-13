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

	function __construct(array $data)
	{
		$this->index = $data->index;
		$this->num   = $data->num;
	}

	public function set_rank($n)
	{
		$this->rank = $n;
	}
}
