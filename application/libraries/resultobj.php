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

	public $book_value;

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
		$this->timestamp = strtotime($data->timestamp);
		if (isset($items))
		{
			$this->set_items($items);
		}
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

	public function set_start_time($time_start)
	{
		$this->set_elapsed_time($time_start);
	}

	public function set_elapsed_time($time_start)
	{
		$time_loged = $this->timestamp;
		$this->_elapsed_time_str = to_time_resolution_str($time_loged - $time_start);
	}

	public function get_elapsed_time_str()
	{
		return $this->_elapsed_time_str;
	}

	/*
	public function set_progress_time_str($time_start)
	{
		$time_loged = $this->timestamp;
		$this->_progress_time_str = to_time_resolution($time_loged - $time_start);
	}

	public function get_time_progress_str($str)
	{
		return $this->_progress_time_str;
	}
	 * 
	 */


	public function get_type_text()
	{
		return $this->_progress_time_str;
	}

}
