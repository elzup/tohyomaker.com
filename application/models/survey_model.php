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
		$items = $this->select_item($id_survey);
		$tags = $this->select_tag($id_survey);
		$owner = $this->select_user_simple($data->id_user);
		return new SurveyObj($data, $items, $tags, $owner);
	}

	public function select_user_simple ($id_user)
	{
		$this->db->where('id_user', $id_user);
		$result = $this->db->get('user_tbl')->result();
		return new UserObj($id_user, $result[0]->sn_last, $result[0]->id_twitter);
	}

	public function select_item($id_survey)
	{
		return $this->_select_survey_subject($id_survey, 'item_tbl');
	}

	public function select_tag($id_survey)
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
		if (($result = $this->check_voted($survey, $user)) !== FALSE)
		{
			return FALSE;
		}
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
				'num_item' => count($items),
				'id_user' => $user->id,
				'public' => $data['is_anonymous'],
		);
		$this->db->insert('survey_tbl', $record);
		$id = $this->db->insert_id();

		$this->_insert_items($id, $items);
		if (($tags = $this->_format_tags($data)))
		{
			$this->_insert_tags($id, $tags);
		}
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
			'value'      => $item,
			'index'     => $i,
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
			'value'      => $tag,
			);
			$this->db->insert('tag_tbl', $record);
		}
	}
}
