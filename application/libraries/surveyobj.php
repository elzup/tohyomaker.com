<?php

class Surveyobj
{

	public $id;
	public $title;
	public $description;
	public $timestamp;
	public $state;
	public $num_item;
	public $is_anonymous;
	public $total_num;
	public $end_type;
	public $end_value;

	public $is_img;
	public $eurl_img;

	/** @var Userobj */
	public $owner;

	/** @var Itemobj[] */
	public $items;
	private $items_sorted;
	public $tags;

	/** @var Resultobj[] */
	public $results;

	/** @var Resultobj */
	public $current_result;
	public $point_hot;

	/** @deprecated */
	public $point_relevant;

	/* super optional */
	public $selected;
	public $is_selected_today;

	function __construct($data = NULL, array $items = NULL, array $tags = NULL, Userobj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->selected = NO_VOTED;
		if (!empty($data))
		{
			$this->set($data, $items, $tags, $owner, $selected, $results);
		}
	}

	function set(stdClass $data, array $items = NULL, array $tags = NULL, Userobj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->id = h($data->id_survey);
		$this->title = h($data->title);
		$this->description = (empty($data->description) ? '' : h($data->description));
		$this->num_item = $data->num_item;
		$this->timestamp = strtotime($data->timestamp);
		$this->state = $data->state;
		$this->is_anonymous = !empty($data->is_anonymous);
		$this->total_num = $data->total_num;


		// TODO: set is_img from record
		$this->is_img = $data->is_img;
		$this->eurl_img = $data->eurl_img;

		$this->end_type = RESULT_TYPE_NONE;
// don't call when end_type eq NONE
		$this->end_value = NULL;

		if (isset($items))
		{
			$this->set_items($items);
		}
		if (isset($tags))
		{
			$this->set_tags($tags);
		}
		if (isset($owner))
		{
			$this->owner = $owner;
		}
// after set items
		if (isset($results))
		{
			$this->set_results($results);
		}
		if (isset($selected))
		{
			$this->selected = $selected;
		}
	}

	public function set_items(array $data)
	{
		$this->items = array();
		$this->items = $this->create_items($data);
	}

	public function create_items($data)
	{
		$items = array();
		foreach ($data as $datum)
		{
			$item = new Itemobj($datum);
			$items[$item->index] = $item;
		}
		ksort($items);
		return $items;
	}

	public function set_tags(array $data)
	{
		$this->tags = array();
		foreach ($data as $datum)
		{
			$this->tags[] = h($datum->value);
		}
	}

	public function set_results(array $data)
	{
		if (empty($data))
		{
			return FALSE;
		}
		$this->results = $this->create_results($data);
	}

	public function set_result_books(array $data_book)
	{
		if (!isset($data_book[0]))
		{
			return FALSE;
		}
		foreach ($data_book as $datum)
		{
			$this->results[] = $this->_create_result_book($datum);
		}
		$this->set_end_type($this->results[0]->type);
		$this->end_value = $this->results[0]->book_value;
	}

	public function create_results(array $data)
	{
		if (!isset($this->items))
		{
			return NULL;
		}
		$end_data = $data[0];
		$this->set_end_type($end_data->type);
		$this->end_value = ($end_data->type == RESULT_TYPE_TIME) ? strtotime($end_data->timestamp) : array_sum(explode(',', $end_data->result));
		$results = array();
		foreach ($data as $datum)
		{
			$results[] = $this->_create_result($datum);
		}
		return $results;
	}

	public function set_end_type($type)
	{
		$this->end_type = ($type >= 10) ? $type - 10: $type;
	}

	private function _create_result($data)
	{
		$nums = explode(',', $data->result);
		$items = $this->_create_map_item($nums);
		$items_sorted = $this->create_sorted_items($items);
		$result = new Resultobj($data, $items_sorted);
		$result->set_start_time($this->timestamp);
		return $result;
	}

	private function _create_result_book($data)
	{
		$result = new Resultobj();
		$result->type = $data->type;
		$result->book_value = $data->value;
		return $result;
	}

	public function get_current_result()
	{
		$r = $this->current_result ? : $this->install_current_result();
		return $r;
	}

	public function install_current_result()
	{
		$data = new stdClass();
		$data->type = RESULT_TYPE_CURRENT;
		$data->timestamp = date_mysql_timestamp();
		return $this->current_result = new Resultobj($data, $this->items);
	}

	private function _create_map_item($nums)
	{
		$items = array();
		foreach ($this->items as $item)
		{
			$items[] = clone $item;
		}
		foreach ($nums as $i => $num)
		{
			$items[$i]->num = $num;
		}
		return $items;
	}

	public function get_text_items($glue = ' / ')
	{
		$itemnames = array();
		foreach ($this->items as $item)
		{
			$itemnames[] = $item->value;
		}
		return implode($glue, $itemnames);
	}

	public function get_time_progress_par()
	{
		if ($this->state === SURVEY_STATE_END)
		{
			return 100;
		}
		$progress_time = $this->get_time_progress();
		$v = $progress_time * 100 / ($this->end_value - $this->timestamp);
		return round($v);
	}

	public function get_time_progress()
	{
		return time() - $this->timestamp;
	}

	public function get_time_progress_str()
	{
		return to_time_resolution_str($this->get_time_progress());
	}

	public function get_time_remain_str()
	{
		if ($this->end_type == RESULT_TYPE_TIME)
		{
			$remain = $this->get_time_remain();
			if ($remain <= 0)
			{
				return '終了';
			}
			$times = to_time_resolution($remain, TRUE);
// TODO: 
			return 'あと' . ($times->d ? $times->df : $times->h ? : $times->m ? : $remain . '秒');
		}
		// TODO: end_type eq num action
	}

	public function get_time_remain()
	{
		if ($this->state == SURVEY_STATE_END)
		{
			return 0;
		}
// TODO: create another type case 
		return $this->end_value - time();
	}

	public function get_time()
	{
		return date(DATE_FORMAT, $this->timestamp);
	}

	/**
	 * 
	 * @return Itemobj[]
	 */
	public function get_sorted()
	{
		if (!isset($this->items_sorted))
		{
			$this->items_sorted = $this->create_sorted_items($this->items);
		}
		return $this->items_sorted;
	}

	public function create_sorted_items($items)
	{

//sort to base ItemObj's field num
		if (!function_exists('cmp_item'))
		{

			function cmp_item(Itemobj $a, Itemobj $b)
			{
				if ($a->num == $b->num)
				{
					return 0;
				}
				return ($a->num < $b->num) ? 1 : -1;
			}

		}

		usort($items, 'cmp_item');
		$this->_rank_item($items);
		return $items;
	}

	private function _rank_item(&$items_sorted)
	{
		if (!isset($items_sorted))
		{
			return false;
		}
		$pre_n = -1;
		$rank = 0;
		for ($i = 0; $i < count($items_sorted); $i++)
		{
			$n = $items_sorted[$i]->num;
			if ($pre_n != $n)
			{
				$rank = $i + 1;
			}
			$items_sorted[$i]->set_rank($rank);
			$pre_n = $n;
		}
	}

	public function update_regist_vote($value)
	{
		$this->items[$value]->num++;
		$this->total_num++;
	}

	public function check_just()
	{
		$lib = array(
				100 => RESULT_TYPE_V100,
				500 => RESULT_TYPE_V500,
				1000 => RESULT_TYPE_V1000,
				5000 => RESULT_TYPE_V5000,
				10000 => RESULT_TYPE_V10000,
		);
		if (isset($lib[$this->total_num]))
		{
			return $lib[$this->total_num];
		}
		return FALSE;
//		return @$lib[$this->total_num] ?: FALSE;
	}

	public function get_result_num()
	{
		return count($this->results);
	}

	public function get_result_text()
	{
		$results = array();
		foreach ($this->items as $item)
		{
			$results[] = $item->num;
		}
		return implode(',', $results);
	}

	/*
	 * support voted item 
	 */

	/**
	 * 
	 * @return boolean
	 */
	public function is_voted()
	{
		return $this->is_selected_today;
//		return $this->selected !== NO_VOTED;
	}

	/**
	 * 
	 * @return Itemobj
	 */
	public function get_selected_item()
	{
		return @$this->items[$this->selected] ?: NULL;
	}

	public function get_full_imgurl() {
		if (!$this->is_img)
		{
			return FALSE;
		}
		return imgurl_unzip($this->eurl_img);
	}

}
