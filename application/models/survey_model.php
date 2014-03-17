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
	 * @param type $id_survey
	 * @return SurveyObj|boolean
	 */
	public function get_survey($id_survey)
	{
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

	/**
	 * 
	 * @param SurveyObj $survey
	 * @param UserObj $user
	 * @param type $value
	 * @return boolean
	 */
	public function insert_vote(SurveyObj $survey, UserObj $user, $value)
	{
		if (($result = $this->check_voted($survey, $user)) !== FALSE || $survey->num_item <= $value)
		{
			return FALSE;
		}
		$where = array(
				'id_survey' => $survey->id,
				'index' => $value,
		);
		$result = $this->db->get_where('item_tbl', $where)->result();
		$num = $result->num;

		$this->db->where($where);
		$this->db->set('num', $num + 1);
		$this->db->update('item_tbl');

		$data = array(
				'id_survey' => $survey->id,
				'id_user' => $user->id,
				'value' => $value,
		);
		$this->db->insert('vote_tbl', $data);
		return TRUE;
	}

	/**
	 * check user already voted or never
	 * @param SurveyObj $survey
	 * @param UserObj $user
	 * @return boolean|int false or vote_value
	 */
	public function check_voted(SurveyObj $survey, UserObj $user)
	{
		$this->db->where('id_survey', $survey->id);
		$this->db->where('id_user', $user->id);
		$result = $this->db->get('vote_tbl')->result();
		if (!isset($result[0]))
		{
			return FALSE;
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
				echo $datum->result .':' . time();
				exit;
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
		$this->db->insert('insert', $where);
		$this->db->where($where);
		$data = $this->db->get('result_tbl')->result();
		return $data[0];
	}

	private function _create_book_result($id_survey)
	{
		for ($i = 0; $i < 5; $i++)
		{
			$this->_insert_result_book($id_survey, $i, TRUE);
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
		$timestrlib = explode(',', '+1hour,+6hour,+12hour,+1day,+2day');
		$data = array(
				'id_survey' => $id_survey,
				'type' => $type + 100,
				'result' => strtotime($timestrlib[$type]),
		);
		$this->db->insert('result_tbl', $data);
	}

}
