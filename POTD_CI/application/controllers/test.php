<?php

class Test extends CI_Controller
{
	// public $view_data;
	public function __construct()
	{
		parent::__construct();	

		$this->load->model('User_model');
		
		// $this->view_data['proverb'] = $this->User_model->get_verse();
	}

	public function index()
	{
		$this->session->set_userdata('proverb', $this->User_model->get_verse()); 
		$proverb['proverb'] = $this->session->userdata('proverb');
		$this->load->view('home', $proverb);
	}
}
?>