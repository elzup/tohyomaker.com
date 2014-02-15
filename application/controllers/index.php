<?php

class Index extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		echo "this is top page";
	}

	function index()
	{
		echo "TOP PAGE";
		$this->load->database();
		$sql = "INSERT INTO `test_tbl` (`id`, `number`, `text`) VALUES (1000, 'new inserted text' ,200)";
		if ($result = $this->db->query($sql))
		{
			echo "success";
		} else
		{
			echo "mysql errro";
		}
		echo "<pre>";
		print_r($result);
	}
}
