<?php

class Survey_model extends CI_Model
{
	/*
	 * 単票オブジェクトの配列
	 * votes Array of Vote
	 */

	public $votes;

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 
	 * @param int $id_survey
	 * @param int|Surveyobj $id_user optional set selected survey
	 * @return Surveyobj|boolean
	 */
	public function get_survey($id_survey, $id_user = NULL, $is_guest = FALSE)
	{
		if (!is_numonly($id_survey))
		{
// incorrect id
			return FALSE;
		}
		if ($id_user instanceof Userobj)
		{
			$is_guest = $id_user->is_guest;
			$id_user = $id_user->id;
		}
		$this->db->where('id_survey', $id_survey);
		$result = $this->db->get(DB_TBL_SURVEY)->result();
		if (empty($result))
		{
			return FALSE;
		}

		$data = $result[0];
		// TODO: make modularize checking incorrect data
		if (empty($data->title))
		{
			return FALSE;
		}
		$items = $this->select_items($id_survey);
		$tags = $this->select_tags($id_survey);
		$owner = $this->select_user_simple($data->id_user);
		$survey = new Surveyobj($data, $items, $tags, $owner);
		$this->_install_result($survey);
		$this->install_select($survey, $id_user, $is_guest);
		$this->check_delete_votes($survey);
		return $survey;
	}

	public function select_user_simple($id_user)
	{
		$this->db->where('id_user', $id_user);
		$result = $this->db->get(DB_TBL_USER)->result();
		return new Userobj($result[0]);
	}

	public function select_items($id_survey)
	{
		return $this->_select_survey_subject($id_survey, DB_TBL_ITEM);
	}

	public function select_results($id_survey)
	{
		return $this->_select_survey_subject($id_survey, DB_TBL_RESULT, 'desc');
	}

	public function select_tags($id_survey)
	{
		return $this->_select_survey_subject($id_survey, DB_TBL_TAG);
	}

	private function _select_survey_subject($id_survey, $tblname, $sort = NULL)
	{
		if (isset($sort))
		{
			$this->db->order_by("timestamp", $sort);
		}
		$this->db->where('id_survey', $id_survey);
		$result = $this->db->get($tblname)->result();
		return $result;
	}

	public function select_result_books($id_survey)
	{
		$this->db->order_by("num", 'asc');
		$this->db->where('id_survey', $id_survey);
		$result = $this->db->get(DB_TBL_RESULT_BOOK)->result();
		return $result;
	}

	public function select_votes_user($id_user)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->where('id_user', $id_user);
		$result = $this->db->get(DB_TBL_VOTE)->result();
		return $result;
	}

	public function select_surveys_owner($id_user)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->where('id_user', $id_user);
		$result = $this->db->get(DB_TBL_SURVEY)->result();
		return $result;
	}

	public function select_surveys_new($num = 10)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->limit($num);
// limit progress for a totality db surveys are small
//		$this->db->where('state', SURVEY_STATE_PROGRESS);
		$result = $this->db->get(DB_TBL_SURVEY)->result();
		return $result;
	}

	public function select_search_tags($tags, $num = 100)
	{
		if (!is_array($tags))
		{
			$tags = array($tags);
		}
		$this->db->order_by("id_survey", "desc");
		$this->db->limit($num);
		$this->db->where('value', $tags[0]);
		for ($i = 1; $i < count($tags); $i++)
		{
			$this->db->or_where('value', $tags[$i]);
		}
		$result = $this->db->get(DB_TBL_TAG)->result();
		return $result;
	}

	public function select_votes_new($num)
	{
		$this->db->order_by("timestamp", "asc");
		$this->db->limit($num);
		$result = $this->db->get(DB_TBL_VOTE)->result();
		return $result;
	}

	/**
	 * 
	 * @param Surveyobj $survey
	 * @param Userobj $user
	 * @param type $value
	 * @return boolean
	 */
	public function regist_vote(Surveyobj $survey, Userobj $user, $value)
	{
		$vote = $this->check_voted($survey->id, $user->id, $user->is_guest);
		// not exists itemnubmer 
		if ($survey->num_item <= $value || ($vote !== NO_VOTED && is_today($vote->timestamp)))
		{
			return FALSE;
		}
		if ($vote === NO_VOTED)
		{
			$this->insert_vote($survey->id, $user->id, $value, $user->is_guest);
		} else
		{
			$this->update_vote($survey->id, $user->id, $value, $user->is_guest);
		}

		$survey->update_regist_vote($value);
		$this->inclement_item($survey->id, $value, $survey->items[$value]->num);
		$this->inclement_survey($survey->id, $survey->total_num);
		if (($num = $this->_check_result_just($survey)) !== FALSE)
		{
			$this->_update_result($survey, RESULT_TYPE_NUM, $value);
			// NOTICE: this time surveyobj not update (results field other)
			// should reutrn surveyobj updated
		}
		return TRUE;
	}

	private function _check_result_just(Surveyobj $survey)
	{
		$data = $this->select_result_books($survey->id);
		if (empty($data))
		{
			return FALSE;
		}
		foreach ($data as $datum)
		{
			if ($datum->type == RESULT_TYPE_NUM_BOOK && $survey->total_num == $datum->result)
			{
				return $datum->result;
			}
		}
		return FALSE;
	}

	public function insert_vote($id_survey, $id_user, $value, $is_guest = FALSE)
	{
		$this->db->set('id_survey', $id_survey);
		$this->db->set('id_user', $id_user);
		$this->db->set('is_guest', $is_guest);
		$this->db->set('value', $value);
		$this->db->insert(DB_TBL_VOTE);
	}

	public function update_vote($id_survey, $id_user, $value, $is_guest = FALSE)
	{
		$this->db->where('id_survey', $id_survey);
		$this->db->where('id_user', $id_user);
		$this->db->where('is_guest', $is_guest);
		$this->db->set('value', $value);
		$this->db->update(DB_TBL_VOTE);
	}

	public function inclement_survey($id_survey, $total_num = NULL)
	{
		$where = array('id_survey' => $id_survey);
		if (!isset($total_num))
		{
			$result = $this->db->get_where(DB_TBL_SURVEY, $where)->result();
			$total_num = $result->total_num + 1;
		}

		$this->db->where($where);
		$this->db->set('total_num', $total_num);
		$this->db->update(DB_TBL_SURVEY);
	}

	public function inclement_item($id_survey, $index, $num = NULL)
	{
		$where = array(
				'id_survey' => $id_survey,
				'index' => $index,
		);
		if (!isset($num))
		{
			$result = $this->db->get_where(DB_TBL_ITEM, $where)->result();
			$num = $result->num + 1;
		}

		$this->db->where($where);
		$this->db->set('num', $num);
		$this->db->update(DB_TBL_ITEM);
	}

	public function install_select(Surveyobj $survey, $id_user, $is_guest = FALSE)
	{
		$select = $this->check_voted($survey->id, $id_user, $is_guest);
		if ($select !== NO_VOTED)
		{
			$survey->selected = $select->value;
			$survey->is_selected_today = is_today($select->timestamp);
		} else
		{
			$survey->selected = NO_VOTED;
			$survey->is_selected_today = FALSE;
		}
	}

	/**
	 * check user already voted or never
	 * @return boolean|int false or vote_value
	 */
	public function check_voted($id_survey, $id_user, $is_guest = FALSE)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->where('id_survey', $id_survey);
		$this->db->where('id_user', $id_user);
		$this->db->where('is_guest', $is_guest);
		$result = $this->db->get(DB_TBL_VOTE)->result();
		return @$result[0] ? : NO_VOTED;
	}

	public function regist(array $data, Userobj $user)
	{
		$this->db->set('title', $data['title']);
		$this->db->set('description', $data['description']);
		$items = $this->_format_items($data);
		$this->db->set('num_item', count($items));
		$this->db->set('id_user', count($user->id));
		$this->db->set('is_anonymous', $data['is_anonymous']);

		$this->db->insert(DB_TBL_SURVEY);
		$id = $this->db->insert_id();

		$this->_insert_items($id, $items);
		if (($tags = $this->_format_tags($data)))
		{
			$this->_insert_tags($id, $tags);
		}


		// TODO: result_type_time booking
		$this->_result_book_timing($id, $data['timing']);

		return $id;
	}

	private function _result_book_timing($id_survey, $timing_text)
	{
		$times = explode(',', $timing_text);
		$d = $times[0];
		$h = $times[1];
		if ($d == 0 && $h == 0)
		{
			return;
		}
		$time = strtotime("+{$d}days {$h}hours");
		$this->_insert_result_book($id_survey, RESULT_TYPE_TIME_BOOK, $time, 0);
	}

	private function _format_items($data)
	{
		$items = array();
		for ($i = 1; $i <= 10; $i++)
		{
			if (!empty($data["item{$i}"]))
			{
				$items[] = $data["item{$i}"];
			}
		}
		return $items;
	}

	private function _format_tags($data)
	{
		if (empty($data['tag']))
		{
			return FALSE;
		}
		return array_filter_values(explode(',', $data['tag']));
	}

	private function _update_state_end(Surveyobj $survey)
	{
		$this->_update_state($survey, SURVEY_STATE_END);
	}

	private function _update_state(Surveyobj $survey, $state)
	{
		$this->db->where('id_survey', $survey->id);
		$this->db->set('state', $state);
		$this->db->update(DB_TBL_SURVEY);
		$survey->state = $state;
	}

	/*
	  public function update_state(SurveyObj &$survey, $state)
	  {
	  $this->_update_state($survey, $state);
	  }
	 * 
	 */

	private function check_delete_votes(Surveyobj $survey)
	{
		if ($survey->state == SURVEY_STATE_END
				&& $survey->end_value + strtotime('+7 day', 0) < time())
		{
			$this->delete_votes_overdue($survey);
		}
	}

	private function delete_votes_overdue(Surveyobj $survey)
	{
		$this->db->where('id_survey', $survey->id);
		$this->db->where('`timestamp` < date(now() - interval 7 day)');
		$this->db->delete(DB_TBL_VOTE);
	}

	public function delete_votes_day()
	{
		$this->db->where('is_guest', 1);
		$this->db->where('`timestamp` < date(now())');
		$this->db->delete(DB_TBL_VOTE);
	}

	/**
	 * same survey items insert batch 
	 * @param type $id_survey survey's id
	 * @param array $items item values
	 */
	private function _insert_items($id_survey, $items)
	{
		foreach ($items as $i => $item)
		{
			$record = array(
					'id_survey' => $id_survey,
					'value' => $item,
					'index' => $i,
			);
			$this->db->insert(DB_TBL_ITEM, $record);
		}
	}

	private function _insert_tags($id_survey, $tags)
	{
		foreach ($tags as $tag)
		{
			$record = array(
					'id_survey' => $id_survey,
					'value' => $tag,
			);
			$this->db->insert(DB_TBL_TAG, $record);
		}
	}

	private function _install_result(Surveyobj $survey)
	{
		$data = $this->select_results($survey->id);
		$data_book = $this->select_result_books($survey->id);
		if (!empty($data_book))
		{
			$this->check_result_update($survey, $data, $data_book);
			// check reast result_book
			$data_book2 = $this->select_result_books($survey->id);
			if (empty($data_book2))
			{
				$this->_update_state_end($survey);
			}
		}
		$survey->set_results($data);
		$survey->set_result_books($data_book);
	}

	private function check_result_update(Surveyobj $survey, &$data, $data_book)
	{
		foreach ($data_book as &$datum)
		{
			if ($datum->type == RESULT_TYPE_TIME_BOOK && $datum->value < time())
			{
				$data[] = $this->_update_result($survey, RESULT_TYPE_TIME, $datum->value);
			}
		}

		// TODO: to module
		if (!function_exists('cmptimestamp'))
		{

			function cmptimestamp(stdClass $a, stdClass $b)
			{
				if ($a->timestamp == $b->timestamp)
				{
					return 0;
				}
				return ($a->timestamp < $b->timestamp) ? 1 : -1;
			}

		}
		usort($data, 'cmptimestamp');
	}

	private function _update_result(Surveyobj $survey, $type, $value = NULL)
	{
		$where = array(
				'id_survey' => $survey->id,
				'type' => $type + RESULT_TYPE_BOOK_SHIFT,
				'value' => $value,
		);
		$this->db->where($where);
		$this->db->delete(DB_TBL_RESULT_BOOK);
		$this->_insert_result($survey, $type, $value);
		$this->db->where('id_result', $this->db->insert_id());
		$data = $this->db->get(DB_TBL_RESULT)->result();
		return $data[0];
	}

	private function _insert_result(Surveyobj $survey, $type, $time = NULL)
	{
		$data = array(
				'id_survey' => $survey->id,
				'type' => $type,
				'result' => $survey->get_result_text(),
		);
		if ($type == RESULT_TYPE_TIME)
		{
			// vote_num -> real time result update, needles timecalc
			// time     -> It's hard to say when, need timecalc
			$time_value = $survey->timestamp + $time;
			$data['timestamp'] = date_mysql_timestamp($time_value);
			// TODO:
		}
		$this->db->insert(DB_TBL_RESULT, $data);
	}

	private function _insert_result_book($id_survey, $type, $value, $num)
	{
		if ($type < RESULT_TYPE_BOOK_SHIFT)
		{
			$type += RESULT_TYPE_BOOK_SHIFT;
		}
		$data = array(
				'id_survey' => $id_survey,
				'type' => $type,
				'value' => $value,
				'num' => $num,
		);
		$this->db->insert(DB_TBL_RESULT_BOOK, $data);
	}

	/**
	 * 
	 * @param Userobj $user
	 * @return Surveyobj[]
	 */
	public function get_surveys_user_voted(Userobj $user, $num = 20, $start = 0)
	{
		$data = $this->select_votes_user($user->id);
		$ids = $this->datas_to_surveyids($data, SURVEY_STATE_ALL);
		return $this->get_surveys($ids, $user, $num, $start);
	}

	public function get_surveys_user_maked(Userobj $user, $num = 20, $start = 0)
	{
		$data = $this->select_surveys_owner($user->id);
		$ids = $this->datas_to_surveyids($data);
		return $this->get_surveys($ids, $user, $num, $start);
	}

	public function get_surveys_new(Userobj $user, $num = 10, $start = 0)
	{
		$data = $this->select_surveys_new($num);
		$ids = $this->datas_to_surveyids($data);
		$surveys = $this->get_surveys($ids, $user, $num, $start);
		return $surveys;
	}

	public function get_surveys_hot(Userobj $user, $num, $start)
	{
		$data = $this->select_votes_new(200);
		$ids = $this->calc_surveyids_hot($data);
		return $this->get_surveys($ids, $user, $num, $start);
	}

	public function get_surveys_search_tag(Userobj $user, $word, $num = 10, $start = 0)
	{
		$data = $this->select_search_tags($word, 200);
		$ids = $this->calc_surveyids_tag($data);
		return $this->get_surveys($ids, $user, $num, $start);
	}

	public function calc_surveyids_tag($data)
	{
		$count = count_value($data, 'id_survey');
		$lev = array();
		foreach ($count as $id => $c)
		{
			$lev[$c][] = $id;
		}
		arsort($lev);
		$ids = array();
		foreach ($lev as $point => $levum)
		{
			arsort($levum);
			foreach ($levum as $id)
			{
				$ids[] = create_std_obj(array('id' => $id, 'point_relevant' => $point));
			}
		}
		return $ids;
	}

	public function calc_surveyids_hot($data)
	{
		$count = count_value($data, 'id_survey');
		arsort($count);
		$ids = array();
		foreach ($count as $id => $num)
		{
			$ids[] = create_std_obj(array('id' => $id, 'point_hot' => $num));
		}
		return $ids;
	}

	/**
	 * 
	 * @param array $data
	 * @param int $state_limit
	 * @return stdClass[]
	 */
	public function datas_to_surveyids(array $data, $state_limit = SURVEY_STATE_ALL)
	{
		if (empty($data))
		{
			return NULL;
		}
		$ids = array();
		foreach ($data as $datum)
		{
			if ($state_limit !== SURVEY_STATE_ALL && $datum->state != $state_limit)
			{
				continue;
			}
			$ids[] = create_std_obj(array('id' => $datum->id_survey));
		}
		return $ids;
	}

	/**
	 * 
	 * @param stdClass[] $id_objs
	 * @param Userobj $user
	 * @param int $num
	 * @param int $start
	 * @param int $state_limit
	 * @return Surveyobj[]
	 */
	public function get_surveys($id_objs, Userobj $user, $num = 100, $start = 0, $state_limit = SURVEY_STATE_ALL)
	{
		if (!is_array($id_objs) || count($id_objs) == 0)
		{
			return NULL;
		}
		$surveys = array();
		for ($i = $start; ($ido = @$id_objs[$i]) && count($surveys) < $num; $i++)
		{
			$survey = $this->get_survey($ido->id, $user->id, $user->is_guest);
			if (empty($survey) || ($state_limit !== SURVEY_STATE_ALL && $survey->state != $state_limit))
			{
				continue;
			}
			$survey->point_hot = @$ido->point_hot;
			$survey->point_relevant = @$ido->point_relevant;
			$surveys[] = $survey;
		}
		return $surveys;
	}

	/**
	 * 
	 * @param Userobj[] $users
	 * @param Surveyobj $survey
	 */
	public function install_users_select($users, Surveyobj $survey)
	{
		$users_voted = array();
		foreach ($users as $user)
		{
			echo $user->id;
			$select = $select = $this->check_voted($survey->id, $user->id);
			if ($select !== NO_VOTED) {
				$user->select = $select->value;
				$users_voted[] = $user;
			}
		}
		return $users_voted;
	}
}
