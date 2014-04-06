<?php

class User_model extends CI_Model
{

	private $twitter_connection;

	/**
	 * @var $user UesrObj
	 */
	private $user;
	private $is_guest;

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
		return !empty($this->user);
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
		if (!empty($access_token['oauth_token']))
		{
			$this->twitter_connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$id_twitter = $access_token['user_id'];
			$data = $this->check_register($id_twitter, 'id_twitter');
			$id_user = @$data->id_user ? : $this->register($id_twitter);
			$this->user = $this->get_user($id_user);
			$this->user->screen_name = $access_token['screen_name'];
			$this->update_last_sn($id_user, $access_token['screen_name']);
			$this->session->set_userdata(array('userserial' => serialize($this->user)));
			return TRUE;
		}
		$ip = $this->input->ip_address();
		$data = $this->check_register_guest($ip, 'ip_user');
		$id_user = @$data->id_user ? : $this->register_guest($ip);
		$this->user = $this->get_user_guest($id_user);
		$this->user = $this->get_user($id_user, TRUE);
		return FALSE;
	}

	/**
	 * 
	 * @param type $id_user
	 * @param type $is_guest
	 * @return Userobj|boolean
	 */
	public function get_user($id_user, $is_guest = FALSE)
	{
		if ((!$is_guest && !($data = $this->check_register($id_user))) || ($is_guest && !($data = $this->check_register_guest($id_user))))
		{
			return FALSE;
		}
		return new Userobj($data);
	}

	public function get_user_guest($id_user)
	{
		return $this->get_user($id_user, TRUE);
	}

	/**
	 * 
	 * @param type $id
	 * @return boolean|string id_user
	 */
	function check_register($id, $type = 'id_user', $is_guest = FALSE)
	{
		$this->db->where($type, $id);
		$query = $this->db->get($is_guest ? DB_TBL_USER_GUEST : DB_TBL_USER);
		$result = $query->result();
		// if not exists return FALSE
		return @$result[0] ? : FALSE;
	}

	function check_register_guest($id, $type = 'id_user')
	{
		return $this->check_register($id, $type, TRUE);
	}

	function register($id_twitter, $is_guest = FALSE)
	{
		$this->db->set($is_guest ? 'ip_user' : 'id_twitter', $id_twitter);
		$this->db->insert($is_guest ? DB_TBL_USER_GUEST : DB_TBL_USER);

		return $this->db->insert_id();
	}

	function register_guest($ip)
	{
		return $this->register($ip, TRUE);
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
		$this->db->update(DB_TBL_USER);
	}

	public function inclement_user_votecount($id_user, $num = NULL)
	{
		$where = array('id_user' => $id_user);
		if (!isset($num))
		{
			$result = $this->db->get_where(DB_TBL_USER, $where)->result();
			$num = $result->num + 1;
		}

		$this->db->where($where);
		$this->db->set('count_vote', $num);
		$this->db->update(DB_TBL_USER);
		$this->user->count_vote++;
	}

	public function guest_login()
	{
		
	}

}
