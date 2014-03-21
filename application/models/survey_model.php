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
		$this->load->library('voteObj');
		$this->load->library('surveyObj');
		$this->load->library('itemObj');
		$this->load->library('resultObj');
	}

	/**
	 * 
	 * @param int $id_survey
	 * @param int|SurveyObj $id_user optional set selected survey
	 * @return SurveyObj|boolean
	 */
	public function get_survey($id_survey, $id_user = NULL)
	{
		if (!is_numonly($id_survey))
		{
			// incorrect id
			return FALSE;
		}
		if ($id_user instanceof UserObj)
		{
			$id_user = $id_user->id;
		}
		$where = array(
				'id_survey' => $id_survey,
		);
		$result = $this->db->get_where('survey_tbl', $where)->result('object');
		if (empty($result))
		{
			return FALSE;
		}

		$data = $result[0];
		$items = $this->select_items($id_survey);
		$tags = $this->select_tags($id_survey);
		$owner = $this->select_user_simple($data->id_user);
		$survey = new SurveyObj($data, $items, $tags, $owner);
		$this->_install_result($survey);
		$this->_check_state($survey);
		$this->install_select($survey, $id_user);
		return $survey;
	}

	public function select_user_simple($id_user)
	{
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('user_tbl')->result();
		return new UserObj($id_user, $result[0]->sn_last, $result[0]->id_twitter);
	}

	public function select_items($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'item_tbl');
	}

	public function select_results($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'result_tbl');
	}

	public function select_tags($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'tag_tbl');
	}

	private function _select_survey_subject($id_survey, $tblname)
	{
		$where = array(
				'id_survey' => $id_survey,
		);
		$result = $this->db->get_where($tblname, $where)->result('object');
		return $result;
	}

	public function select_votes_user($id_user)
	{
		$where = array(
				'id_user' => $id_user,
		);
		$this->db->order_by("timestamp", "desc");
		$this->db->where($where);
		$result = $this->db->get('vote_tbl')->result();
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
	 * @param SurveyObj $survey
	 * @param UserObj $user
	 * @param type $value
	 * @return boolean
	 */
	public function regist_vote(SurveyObj $survey, UserObj $user, $value)
	{
		if (($this->check_voted($survey->id, $user->id)) !== NO_VOTED || $survey->num_item <= $value)
		{
			return FALSE;
		}

		$this->insert_vote($survey->id, $user->id, $value);
		$this->inclement_item($survey->id, $value);
		$this->inclement_survey($survey->id);
		return TRUE;
	}

	public function insert_vote($id_survey, $id_user, $value)
	{
		$data = array(
				'id_survey' => $id_survey,
				'id_user' => $id_user,
				'value' => $value,
		);
		$this->db->insert('vote_tbl', $data);
	}

	public function inclement_survey ($id_survey)
	{
		$where = array('id_survey' => $id_survey);
		$result = $this->db->get_where('survey_tbl', $where)->result();
		$num = $result->total_num;

		$this->db->where($where);
		$this->db->set('total_num', $num + 1);
		$this->db->update('survey_tbl');
	}

	public function inclement_item ($id_survey, $index)
	{
		$where = array(
				'id_survey' => $id_survey, 
				'index' => $index,
		);
		$result = $this->db->get_where('item_tbl', $where)->result();
		$num = $result->num;

		$this->db->where($where);
		$this->db->set('num', $num + 1);
		$this->db->update('item_tbl');
	}

	public function install_select(SurveyObj &$survey, $id_user)
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

	private function _get_votes($id_survey)
	{
		$where = array(
				'id_survey' => $id_survey,
		);
		$result = $this->db->get_where(TBL_VOTE, $where)->result('VoteObj');
		return $result;
	}

	public function regist(array $data, UserObj $user)
	{
		$items = $this->_format_items($data);
		$record = array(
				'title' => $data['title'],
				'description' => $data['description'],
				'target' => $data['target'],
				'num_item' => count($items),
				'id_user' => $user->id,
				'is_anonymous' => $data['is_anonymous'],
		);
		$this->db->insert('survey_tbl', $record);
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

	private function _check_state(SurveyObj &$survey)
	{
		$su = $survey->get_state_update();
		if ($su === SURVEY_STATE_RESULT || ($su === SURVEY_STATE_END && $survey->state == SURVEY_STATE_PROGRESS))
		{
			$this->_update_state_result($survey);
		}
		if ($su === SURVEY_STATE_END)
		{
			$this->_update_state_end($survey);
		}
	}

	private function _update_state_result(SurveyObj &$survey)
	{
		$this->_update_state($survey, SURVEY_STATE_RESULT);
	}

	private function _update_state_end(SurveyObj &$survey)
	{
		$this->_update_state($survey, SURVEY_STATE_END);
		$this->_delete_votes($survey);
	}

	private function _update_state(SurveyObj &$survey, $state)
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

	private function _delete_votes(SurveyObj $survey)
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

	private function _install_result(SurveyObj $survey)
	{
		$data = $this->select_results($survey->id);
		if (!empty($data))
		{
			$this->check_result_update($survey, $data);
			$survey->set_results($data);
		}
	}

	private function check_result_update(SurveyObj $survey, array &$data)
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
				return ($a->timestamp < $b->timestamp) ? -1 : 1;
			}

		}
		usort($data, 'cmptimestamp');
	}

	private function _update_result(SurveyObj $survey, $type)
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

	private function _insert_result(SurveyObj $survey, $type)
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
	 * @param UserObj $user
	 * @return null|SurveyObj[]
	 */
	public function get_surveys_user_voted(UserObj $user)
	{
		$data = $this->select_votes_user($user->id);
		return $this->datas_to_survey($data, $user->id);
	}

	public function get_surveys_new($num = 10, $id_user = NULL)
	{
		$data = $this->select_surveys_new($num);
		return $this->datas_to_survey($data, $id_user);
	}

	public function get_surveys_hot($num, $id_user = NULL)
	{
		$data = $this->select_votes_new(200);
		$data2 = $this->calc_surveyids_hot($data);
		return $this->datas_to_survey_hot($data2, $num, $id_user);
	}

	public function get_surveys_search_tag($word, $num = 10, $id_user = NULL)
	{
		$data = $this->select_search_tags($word, 200);
		$ids = $this->calc_surveyids_tag($data);
		return $this->datas_to_survey_tag($ids, $num, $id_user);
	}

	public function calc_surveyids_tag($data)
	{
		$count = array();
		foreach ($data as $datum)
		{
			if (!isset($count[$datum->id_survey]))
			{
				$count[$datum->id_survey] = 0;
			}
			$count[$datum->id_survey] += 1;
		}
		$ids = array();
		foreach ($count as $id => $c)
		{
			$ids[$c][] = $id;
		}
		arsort($ids);
		foreach ($ids as &$idsum)
		{
			arsort($idsum);
		}
		return $ids;
	}

	public function calc_surveyids_hot($data)
	{
		$count = array();
		foreach ($data as $datum)
		{
			if (!isset($count[$datum->id_survey]))
			{
				$count[$datum->id_survey] = 0;
			}
			$count[$datum->id_survey] += 1;
		}
		arsort($count);
		return $count;
	}

	public function datas_to_survey_tag($ids, $num, $id_user)
	{
		if (empty($ids))
		{
			return NULL;
		}
		$surveys = array();
		$i = 0;
		foreach ($ids as $count => $idsum)
		{
			foreach ($idsum as $id_survey)
			{
				/** @var $survey SurveyObj */
				$survey = $this->get_survey($id_survey, $id_user);
				if (!$survey)
				{
					// TODO: can't create survey error act
					return FALSE;
				}
				$survey->point_relevant = $count;
				$surveys[] = $survey;
				if (++$i >= $num)
				{
					break;
				}
			}
		}
		return $surveys;
	}

	public function datas_to_survey_hot($data, $num, $id_user)
	{
		if (empty($data))
		{
			return NULL;
		}
		// NOTICE: solved if block `if (isset($data))`
		$surveys = array();
		$i = 0;
		foreach ($data as $id_survey => $value)
		{
			if (!($survey = $this->get_survey($id_survey, $id_user)))
			{
				// TODO: can't create survey error act
				return FALSE;
			}
			if ($survey->state !== SURVEY_STATE_PROGRESS)
			{
				continue;
			}
			$survey->point_hot = $value;
			$surveys[] = $survey;
			if (++$i >= $num)
			{
				break;
			}
		}
		return $surveys;
	}

	public function datas_to_survey($data, $id_user = NULL)
	{
		if (empty($data))
		{
			return NULL;
		}
		$surveys = array();
		if (isset($data))
		{
			foreach ($data as $datum)
			{
				if (!($survey = $this->get_survey($datum->id_survey, $id_user)))
				{
					// TODO: can't create survey error act
					// TODO: delete
					die('can\'t surcvey ' . $datum->id_survey);
					return FALSE;
				}
				if ($survey->state !== SURVEY_STATE_PROGRESS)
				{
					continue;
				}
				$surveys[] = $this->get_survey($datum->id_survey, $id_user);
			}
		}
		return $surveys;
	}

}
