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
class resultObj 
{
	public $items;
	public $type;
	public $timestamp;

	function __construct($data = NULL)
	{
		if (isset($data))
		{
			$this->set($data);
		}
	}

	public function set(stdClass $data)
	{
		$this->type = $data->type;
		$this->timestamp = $data->timestamp;
	}

	public function set_items($items)
	{
		$this->items = $items;
	}
}
