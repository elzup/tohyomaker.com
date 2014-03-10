<?php

class SurveyObj
{

	public $id;
	public $title;
	public $description;
	public $timestamp;
	public $state;
	public $num_item;
	public $is_anonymous;
	public $target;

	/**
	 *
	 * @var UserObj
	 */
	public $owner;
	public $items;
	public $tags;
	public $result;

	function __construct($data = NULL, array $items = NULL, $tags = NULL, $owner = NULL)
	{
		if (!isset($data))
			return;
		$this->set($data, $items, $tags, $owner);
	}

	function set($data, array $items = NULL, $tags = NULL, $owner = NULL)
	{
		$this->id           = $data->id_survey;
		$this->title        = $data->title;
		$this->target       = (empty($data->target) ? '' : $data->target);
		$this->description  = (empty($data->description) ? '' : $data->description);
		$this->num_item     = $data->num_item;
		$this->timestamp    = $data->timestamp;
		$this->state        = $data->state;
		$this->is_anonymous = empty($data->is_anonymous);

		$this->result = array();
		$this->items  = array();
		$this->tags   = array();

		for ($i = 0; $i < $this->num_item; $i++)
		{
			$this->owner = $owner;
		}

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
			$this->result[$item->index] = $item->num;
		}
	}

	public function set_tag($tags)
	{
		foreach ($tags as $tag)
		{
			$this->tags[] = $tag->value;
		}
	}

	public function get_total()
	{
		return array_sum($this->result);
	}

	public function get_text_items($glue = ' / ')
	{
		return implode($glue, $this->items);
	}

	public function get_time()
	{
		return $this->timestamp;
	}
}
