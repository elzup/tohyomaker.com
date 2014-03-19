<?php

class UserObj {

	public $id;
	public $screen_name;
	public $id_twitter;
	public $img_url;
	public $state;

	public function __construct($id = null, $screen_name = null, $id_twitter = null, $img_url = null, $state = null)
	{
		$this->id = $id;
		$this->screen_name = h($screen_name);
		$this->id_twitter = $id_twitter;
		$this->img_url = $img_url;
		$this->state = $state;
	}

	/**
	 * return associative array formated from objects fields
	 * @param bool $is_table is only mysql table parameter or full
	 * @return array 
	 */
	public function getDataArray($is_table = true) {
		$array = array(
				'id_user' => $this->id,
				'id_twitter' => $this->id_twitter,
				'state' => $this->state,
		);
		if (!$is_table) {
			$array['img_url'] = $this->img_url;
			$array['screen_name'] = $this->screen_name;
		}
		return $array;
	}
}
