<?php

class SurveyObj
{

	public $id;
	public $id_owner;
	public $title;
	public $description;
	public $timestamp;
	public $state;
	public $num_item;

	public $items;
	public $tags;
	public $result;

	function __construct($data = null, array $items = null, $tags = null)
	{
		if (!isset($data)) return;
		$this->set($data, $items, $tags);
	}

	function set($data, array $items = null, $tags = null)
	{
		$this->id = $data->id_survey;
		$this->id_owner = $data->id_user;
		$this->title = $data->title;
		$this->description = (empty($data->description) ? '' : $data->description);
		$this->num_item = $data->num_item;
		$this->timestamp = $data->timestamp;
		$this->state = $data->state;
		$this->result = array();
		$this->items = array();
		$this->tags = array();
		for ($i = 0; $i < $this->num_item; $i++)
		{
			$this->result[$i] = 0;
		}
		if (isset($items))
		{
			$this->set_item($items);
		}
		if (isset($tags))
		{
			$this->set_tag($tags);
		}
	}

	public function set_item($items)
	{
		foreach ($items as $item)
		{
			$this->items[$item->index] = $item->value;
			$this->result[$item->index]    = $item->num;
		}
	}

	public function set_tag($tags)
	{
		foreach ($tags as $tag)
		{
			$this->tags[] = $tag->value;
		}
	}
}
