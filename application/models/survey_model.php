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
	public function get_survey($id_survey, $id_user = NULL)
	{
		if (!is_numonly($id_survey))
		{
// incorrect id
			return FALSE;
		}
		if ($id_user instanceof Userobj)
		{
			$id_user = $id_user->id;
		}
		$this->db->where('id_survey', $id_survey);
		$result = $this->db->get('survey_tbl')->result('object');
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
		$this->_check_state($survey);
		if ($survey->state != SURVEY_STATE_END)
		{
			$this->install_select($survey, $id_user);
		}
		return $survey;
	}

	public function select_user_simple($id_user)
	{
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('user_tbl')->result();
		return new Userobj($id_user, $result[0]->sn_last, $result[0]->id_twitter);
	}

	public function select_items($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'item_tbl');
	}

	public function select_results($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'result_tbl', 'desc');
	}

	public function select_tags($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'tag_tbl');
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

	public function select_votes_user($id_user)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('vote_tbl')->result();
		return $result;
	}

	public function select_surveys_owner($id_user)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('survey_tbl')->result();
		return $result;
	}

	public function select_surveys_new($num = 10)
	{
		$this->db->order_by("timestamp", "desc");
		$this->db->limit($num);
// limit progress for a totality db surveys are small
		$this->db->where('state', SURVEY_STATE_PROGRESS);
		$result = $this->db->get('survey_tbl')->result();
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
		$result = $this->db->get('tag_tbl')->result();
		return $result;
	}

	public function select_votes_new($num)
	{
		$this->db->order_by("timestamp", "asc");
		$this->db->limit($num);
		$result = $this->db->get('vote_tbl')->result();
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
		if (($this->check_voted($survey->id, $user->id)) !== NO_VOTED || $survey->num_item
				<= $value)
		{
			return FALSE;
		}

		$survey->update_regist_vote($value);
		$this->insert_vote($survey->id, $user->id, $value);
		$this->inclement_item($survey->id, $value, $survey->items[$value]->num);
		$this->inclement_survey($survey->id, $survey->total_num);
		if (($type = $survey->check_just()) !== FALSE)
		{
			$this->_insert_result($survey, $type);
		}
// TODO: set alert
//		set_alert(ALERT_TYPE_VOTED);
		return TRUE;
	}

	public function insert_vote($id_survey, $id_user, $value)
	{
		$this->db->set('id_survey', $id_survey);
		$this->db->set('id_user', $id_user);
		$this->db->set('value', $value);
		$this->db->insert('vote_tbl');
	}

	public function inclement_survey($id_survey, $total_num = NULL)
	{
		$where = array('id_survey' => $id_survey);
		if (!isset($total_num))
		{
			$result = $this->db->get_where('survey_tbl', $where)->result();
			$total_num = $result->total_num + 1;
		}

		$this->db->where($where);
		$this->db->set('total_num', $total_num);
		$this->db->update('survey_tbl');
	}

	public function inclement_item($id_survey, $index, $num = NULL)
	{
		$where = array(
				'id_survey' => $id_survey,
				'index' => $index,
		);
		if (!isset($num))
		{
			$result = $this->db->get_where('item_tbl', $where)->result();
			$num = $result->num + 1;
		}

		$this->db->where($where);
		$this->db->set('num', $num);
		$this->db->update('item_tbl');
	}

	public function install_select(Surveyobj &$survey, $id_user)
	{
		if (empty($id_user))
		{
			return;
		}
		$select = $this->check_voted($survey->id, $id_user);
		$survey->selected = $select;
		if (!isset($select))
		{
			$survey->selected = NO_VOTED;
		}
	}

	/**
	 * check user already voted or never
	 * @return boolean|int false or vote_value
	 */
	public function check_voted($id_survey, $id_user)
	{
		$this->db->where('id_survey', $id_survey);
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('vote_tbl')->result();
		if (!isset($result[0]))
		{
			return NO_VOTED;
		}
		return $result[0]->value;
	}

	public function regist(array $data, Userobj $user)
	{
		$this->db->set('title', $data['title']);
		$this->db->set('description', $data['description']);
		$this->db->set('target', $data['target']);
		$items = $this->_format_items($data);
		$this->db->set('num_item', count($items));
		$this->db->set('id_user', count($user->id));
		$this->db->set('is_anonymous', $data['is_anonymous']);

		$this->db->insert('survey_tbl');
		$id = $this->db->insert_id();

		$this->_insert_items($id, $items);
		if (($tags = $this->_format_tags($data)))
		{
			$this->_insert_tags($id, $tags);
		}
		$this->_create_book_result($id);
		return $id;
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

	private function _check_state(Surveyobj &$survey)
	{
		$su = $survey->get_state_update();
		if ($su === SURVEY_STATE_RESULT || ($su === SURVEY_STATE_END && $survey->state
				== SURVEY_STATE_PROGRESS))
		{
			$this->_update_state_result($survey);
		}
		if ($su === SURVEY_STATE_END)
		{
			$this->_update_state_end($survey);
		}
	}

	private function _update_state_result(Surveyobj &$survey)
	{
		$this->_update_state($survey, SURVEY_STATE_RESULT);
	}

	private function _update_state_end(Surveyobj &$survey)
	{
		$this->_update_state($survey, SURVEY_STATE_END);
		$this->_delete_votes($survey);
	}

	private function _update_state(Surveyobj &$survey, $state)
	{
		$this->db->where('id_survey', $survey->id);
		$this->db->set('state', $state);
		$this->db->update('survey_tbl');
		$survey->state = $state;
	}

	/*
	  public function update_state(SurveyObj &$survey, $state)
	  {
	  $this->_update_state($survey, $state);
	  }
	 * 
	 */

	private function _delete_votes(Surveyobj $survey)
	{
		$this->db->where('id_survey', $survey->id);
		$this->db->delete('vote_tbl');
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
			$this->db->insert('item_tbl', $record);
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
			$this->db->insert('tag_tbl', $record);
		}
	}

	private function _install_result(Surveyobj $survey)
	{
		$data = $this->select_results($survey->id);
		if (!empty($data))
		{
			$this->check_result_update($survey, $data);
			$survey->set_results($data);
		}
	}

	private function check_result_update(Surveyobj $survey, array &$data)
	{
		foreach ($data as &$datum)
		{
			if ($datum->type < 100)
			{
				continue;
			}
			if ($datum->result < time())
			{
				$data[] = $this->_update_result($survey, $datum->type - 100);
			}
			$datum = FALSE;
		}
// data prepare
		$data = array_filter($data);

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

	private function _update_result(Surveyobj $survey, $type)
	{
		$where = array(
				'id_survey' => $survey->id,
				'type' => $type + 100,
		);
		$this->db->where($where);
		$this->db->delete('result_tbl');
		$this->_insert_result($survey, $type);
		$where['type'] -= 100;
		$this->db->where($where);
		$data = $this->db->get('result_tbl')->result();
		return $data[0];
	}

	private function _create_book_result($id_survey)
	{
		for ($i = 0; $i < 6; $i++)
		{
			$this->_insert_result_book($id_survey, $i);
		}
	}

	private function _insert_result(Surveyobj $survey, $type)
	{
		$data = array(
				'id_survey' => $survey->id,
				'type' => $type,
				'result' => $survey->get_result_text(),
		);
		$this->db->insert('result_tbl', $data);
	}

	private function _insert_result_book($id_survey, $type)
	{
		$timestrlib = explode(',', '+1hour,+6hour,+12hour,+1day,+2day,+3day');
		$data = array(
				'id_survey' => $id_survey,
				'type' => $type + 100,
				'result' => strtotime($timestrlib[$type]),
		);
		$this->db->insert('result_tbl', $data);
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
		return $this->get_surveys($ids, $num, $start, $user->id);
	}

	public function get_surveys_user_maked(Userobj $user, $num = 20, $start = 0)
	{
		$data = $this->select_surveys_owner($user->id);
		$ids = $this->datas_to_surveyids($data);
		return $this->get_surveys($ids, $num, $start, $user->id);
	}

	public function get_surveys_new($num = 10, $start = 0, $id_user = NULL)
	{
		$data = $this->select_surveys_new($num);
		$ids = $this->datas_to_surveyids($data);
		return $this->get_surveys($ids, $num, $start, $id_user);
	}

	public function get_surveys_hot($num, $start, $id_user = NULL)
	{
		$data = $this->select_votes_new(200);
		$ids = $this->calc_surveyids_hot($data);
		return $this->get_surveys($ids, $num, $start, $id_user);
	}

	public function get_surveys_search_tag($word, $num = 10, $start = 0, $id_user = NULL)
	{
		$data = $this->select_search_tags($word, 200);
		$ids = $this->calc_surveyids_tag($data);
		return $this->get_surveys($ids, $num, $start, $id_user);
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
	 * @param int $num
	 * @param int $start
	 * @param int $id_user
	 * @param int $state_limit
	 * @return Surveyobj[]
	 */
	public function get_surveys(array $id_objs, $num = 100, $start = 0, $id_user = NULL, $state_limit = SURVEY_STATE_ALL)
	{
		$surveys = array();
		for ($i = $start; ($ido = @$id_objs[$i]) && count($surveys) < $num; $i++)
		{
			$survey = $this->get_survey($ido->id, $id_user);
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

}
