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
	public function get_user()
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

		$access_token = @$_SESSION['access_token'];

		if (!empty($access_token['oauth_token']))
		{
			$this->twitter_connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$id_twitter = $access_token['user_id'];
			$id_user = $this->check_register($id_twitter);
			if ($id_user === FALSE)
			{
				$id_user = $this->register($id_twitter);
				echo $id_user;
				exit;
			}
			$this->user = new Userobj($id_user, $access_token['screen_name'], $id_twitter);
			$this->update_last_sn_main();
			return true;
		}
		return false;
	}

	/**
	 * 
	 * @param type $id_twitter
	 * @return boolean|string id_user
	 */
	function check_register($id_twitter)
	{
		$this->db->where('id_twitter', $id_twitter);
		$query = $this->db->get('user_tbl');
		$result = $query->result('array');
		// if not exists return false
		if (!isset($result[0]['id_user']))
		{
			return FALSE;
		}
		return $result[0]['id_user'];
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
}
