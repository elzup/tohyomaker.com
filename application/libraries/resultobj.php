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
	private $_progress_time_str;

//	public $is_book;

	function __construct($data = NULL, $items = NULL, $progress_str = NULL)
	{
		if (isset($data))
		{
			$this->set($data, $items, $progress_str);
		}
	}

	public function set(stdClass $data, $items = NULL, $progress_str = NULL)
	{
		$this->type = $data->type;
		$this->timestamp = $data->timestamp;
		if (isset($items))
		{
			$this->set_items($items);
		}
		$this->set_progress_time_str($progress_str);
	}

	public function set_items($items)
	{
		$this->items = $items;
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

	public function set_elapsed_time($time_start)
	{
		$time_loged = strtotime($this->timestamp);
		$this->_elapsed_time_str = to_time_resolution_str($time_loged - $time_start);
	}

	public function get_elapsed_time_str()
	{
		return $this->_elapsed_time_str;
	}

	public function set_progress_time_str($str)
	{
		$this->_progress_time_str = $str;
	}

	public function get_type_text()
	{
		return $this->_progress_time_str;
	}

}
