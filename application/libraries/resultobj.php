<?php

/**
 * result in surveyObj
 * small structure object 
 * 
 */
class Resultobj 
{
	/** @var Itemobj[] */
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
		$this->_elapsed_time_str = to_time_resolution_str($time_loged - $time_start);
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
			$str .= floor(($sec % 86400) / 3600) . '時間';
		}
		$str .= floor(($sec % 3600) / 60) . '分';
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
