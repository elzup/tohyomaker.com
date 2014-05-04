<?php

class Pagerobj {

	// TODO: page_num, index, naming
	public $page_current;
	public $page_end;
	public $width;

	public $page_num;

	public function __construct($current_page, $all_num, $width = 20)
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
