<?php

class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
    }

    function Index() {
    	$this->load->view('head');
    }
}
?>