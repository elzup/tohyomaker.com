<?php

define('RESULT_TYPE_H1' , '0');
define('RESULT_TYPE_H6' , '1');
define('RESULT_TYPE_HC' , '2');
define('RESULT_TYPE_D1' , '3');
define('RESULT_TYPE_D2' , '4');
define('RESULT_TYPE_D3' , '5');

define('RESULT_TYPE_V100'   , '10');
define('RESULT_TYPE_V500'   , '11');
define('RESULT_TYPE_V1000'  , '12');
define('RESULT_TYPE_V5000'  , '13');
define('RESULT_TYPE_V10000' , '14');

/**
 * result in surveyObj
 * small structure object 
 * 
 */
class ResultObj 
{
	public $items;
	public $type;
	public $timestamp;
//	public $is_book;

	function __construct($data = NULL, $items = NULL)
	{
		if (isset($data))
		{
			$this->set($data, $items);
		}
	}

	public function set(stdClass $data, $items = NULL)
	{
		$this->type = $data->type;
		// type (in db ) more than 100, it's booked result. sfhit down 100
//		if (($this->is_book = ($this->type >= 100)))
//		{
//			$this->type -= 100;
//		}
		$this->timestamp = $data->timestamp;
		if (isset($items))
		{
			$this->set_items($items);
		}
	}

	public function set_items($items)
	{
		$this->items = $items;
	}
}
