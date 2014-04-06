<?php

class Userobj
{

	public $id;
	public $screen_name;
	public $id_twitter;
	public $img_url;
	public $state;

	public $count_vote;

	public $is_guest;

	public $select;

	public function __construct(stdClass $data = NULL)
	{
		$this->is_guest = TRUE;
		if (!empty($data))
		{
			$this->set($data);
		}
	}

	public function set(stdClass $data)
	{
		$this->id = $data->id_user;
		if (!isset($data->sn_last))
		{
			// guest user
			$this->screen_name = 'ゲストさん';
			return;
		}
		// logined user
		$this->screen_name = h($data->sn_last);
		$this->id_twitter = $data->id_twitter;
		$this->img_url     = $data->img_last;
		$this->state = $data->state;
		$this->count_vote = $data->count_vote;
		$this->is_guest = FALSE;
	}

	/**
	 * return associative array formated from objects fields
	 * @param bool $is_table is only mysql table parameter or full
	 * @return array 
	 */
	public function getDataArray($is_table = true)
	{
		$array = array(
				'id_user' => $this->id,
				'id_twitter' => $this->id_twitter,
				'state' => $this->state,
		);
		if (!$is_table)
		{
			$array['img_url'] = $this->img_url;
			$array['screen_name'] = $this->screen_name;
		}
		return $array;
	}

}
