<?php

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->config->load('my_twitter');
	}

	function Index()
	{
		$this->start();
	}

	function start()
	{
		$twitterConfig = $this->config->item('TWITTER_CONSUMER');
		$_SESSION['consumer_key'] = $twitterConfig['key'];
		$_SESSION['consumer_secret'] = $twitterConfig['secret'];
		$callbackUri = FCPATH.'auth/end';

		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret']);
		$requestToken = $connection->getRequestToken($callbackUri);
		$_SESSION['oauth_token'] = $token = $requestToken['oauth_token'];
		$_SESSION['oauth_token_secret'] = $requestToken['oauth_token_secret'];

		$authUrl = $connection->getAuthorizeURL($token);

		$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
		header('Location: ' . $authUrl);
	}

	function end()
	{
		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$access_token = $connection->getAccessToken($_GET['oauth_verifier']);
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		$_SESSION['access_token'] = $access_token;
		$ref = $_SESSION['referer'];
		unset($_SESSION['referer']);

		print_r($connection);
		exit;
	}

	function logout()
	{
		
	}

}
