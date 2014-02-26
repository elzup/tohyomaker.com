<?php

class User extends CI_Model
{

	public $isLogin;

	function __construct()
	{
		parent::__construct();
	}

	function checkLogin()
	{
		$this->config->load('my_twitter');
		$twitter_config = $this->config->item('TWITTER_CONSUMER');

		$access_token = $_SESSION['access_token'];

		if (!empty($access_token))
		{
			$connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$this->isLogin = true;
		} else
		{
			$this->isLogin = false;
			return false;
		}
	}

}
