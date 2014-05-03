<?php

class Pagerobj {

	// TODO: page_num, index, naming
	public $index_current;
	public $index_end;
	public $width;

	public $current_num;

	public $page_num;

	public function __construct($start_num, $all_num, $width = 20)
	{
		$this->width = $width;
		$this->index_end = floor ($all_num / $width) + 1;
		$this->index_current = round ($start_num / $width) + 1;
		$this->current_num;
	}

	public function is_last() 
	{
		
	}

	public function is_first()
	{

	}
}
