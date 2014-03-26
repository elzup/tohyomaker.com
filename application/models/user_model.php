<?php

class User_model extends CI_Model
{

	private $twitter_connection;

	/**
	 * @var $user UesrObj
	 */
	private $user;

	function __construct()
	{
		parent::__construct();
		$this->check_login();
	}

	/**
	 * 
	 * @return Userobj
	 */
	public function get_main_user()
	{
		return $this->user;
	}

	public function is_login()
	{
		return !empty($this->twitter_connection);
	}

	/**
	 * @return bool login successed or failed
	 */
	function check_login()
	{
		$this->config->load('my_twitter');
		$twitter_config = $this->config->item('TWITTER_CONSUMER');

		$serial = @$this->session->userdata('userserial');
		if (!empty($serial))
		{
			$this->user = unserialize($serial);
			return TRUE;
		}

		$access_token = @$this->session->userdata('access_token');
		if (empty($access_token['oauth_token']))
		{
			return FALSE;
		}
		$this->twitter_connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$id_twitter = $access_token['user_id'];
		$data = $this->check_register($id_twitter);
		$id_user = @$data->id_user ? : $this->register($id_twitter);
		$this->user = $this->get_user($id_user);
		$this->session->set_userdata(array ('userserial' => serialize($this->user)));

		if (!isset($this->user->count_vote))
		{
			jump(base_url(PATH_LOGOUT));
		}
		return TRUE;
	}

	public function get_user($id_user)
	{
		if (!($data = $this->check_register($id_user, 'id_user')))
		{
			return FALSE;
		}
		return new Userobj($data);
	}


	/**
	 * 
	 * @param type $id
	 * @return boolean|string id_user
	 */
	function check_register($id, $type = 'id_twitter')
	{
		$this->db->where($type, $id);
		$query = $this->db->get('user_tbl');
		$result = $query->result();
		// if not exists return FALSE
		return @$result[0] ?: FALSE;
	}

	function register($id_twitter)
	{
		$this->db->set('id_twitter', $id_twitter);
		$this->db->insert('user_tbl');

		return $this->db->insert_id();
	}

	function update_last_sn_main()
	{
		if (!$this->is_login())
		{
			return FALSE;
		}
		$this->update_last_sn($this->user->id, $this->user->screen_name);
		return TRUE;
	}

	function update_last_sn($id_user, $sn)
	{
		$this->db->where('id_user', $id_user);
		$this->db->set('sn_last', $sn);
		$this->db->update('user_tbl');
	}

	public function inclement_user_votecount($id_user, $num = NULL)
	{
		$where = array('id_user' => $id_user);
		if (!isset($num))
		{
			$result = $this->db->get_where('user_tbl', $where)->result();
			$num = $result->num + 1;
		}

		$this->db->where($where);
		$this->db->set('count_vote', $num);
		$this->db->update('user_tbl');
		$this->user->count_vote++;
	}

}
