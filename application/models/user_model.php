<?php

class User_model extends CI_Model
{

	private $twitter_connection;
	/*
	 * var $info UserObj
	 */
	private $info;

	function __construct()
	{
		parent::__construct();
		define('TBL_USER', 'user_tbl');

		$this->checkLogin();
	}

	public function getUser()
	{
		return $this->user;
	}

	public function isLogin()
	{
		return !empty($this->twitter_connection);
	}

	/**
	 * @return bool login successed or failed
	 */
	function checkLogin()
	{
		$this->config->load('my_twitter');
		$twitter_config = $this->config->item('TWITTER_CONSUMER');

		$access_token = $_SESSION['access_token'];

		if (!empty($access_token))
		{
			$this->twitter_connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
			print_r($this->twitter_connection);
			$this->checkRegister();
		} else
		{
			$this->isLogin = false;
			return false;
		}
	}

	function checkRegister()
	{

//		$result = $this->db->get(TBL_SURVEY, $where)->result('object');
	}

	function register() {

	}

}
