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
	/** @var ItemObj[] */
	public $items;
	public $type;
	public $timestamp;
	private $_elapsed_time_str;

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

	public function set_elapsed_time($time_start)
	{
		if ($this->is_booked())
		{
			$libtimestr = explode(',', '1 時間,6 時間,12 時間,1 日,2 日,3 日');
			$this->_elapsed_time_str = $libtimestr[$this->type];
			return;
		}
		$time_loged = strtotime($this->timestamp);
		$this->_elapsed_time_str = $this->_get_time_str($time_loged - $time_start);
	}

	private function _get_time_str($sec)
	{
		$str = '';
		if ($sec > 86400)
		{
			$str .= floor($sec / 86400).'日';
		}
		if ($sec > 3600)
		{
			$str .= floor($sec / 3600) . '時間';
		}
		$str .= floor($sec / 60) . '分';
		return $str;
	}

	public function get_total()
	{
		$sum = 0;
		foreach ($this->items as $item)
		{
			$sum += $item->num;
		}
		return $sum;
	}

	public function get_elapsed_time_str()
	{
		return $this->_elapsed_time_str;
	}

	public function is_booked()
	{
		return $this->type <= 5;
	}

}
