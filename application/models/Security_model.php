<?php
class Security_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function Loggedin_check()
	{
		$sta=$this->session->userdata("logged_in");
		if($sta != TRUE)
		{
			$this->session->set_flashdata("message","no-access");
			redirect("home",'refresh');
		}
	}

	function Owner_check()
	{
		if ($this->session->userdata('owner') != TRUE)
		{
			$this->session->set_flashdata("message","no-access");
			redirect("home",'refresh');
		}
	}

	function User_check()
	{
		if($this->session->userdata("logged_in") == FALSE)
		{
			$this->session->set_flashdata("message","<script>alert('Maaf anda harus login terlebih dahulu');</script>");
			redirect("home",'refresh');
		}
	}

	public function admin_check()
	{
		if ($this->session->userdata('admin') != TRUE )
		{
			$this->session->set_flashdata("message","no-access");
			redirect("administrator/login",'refresh');
		}
	}
}
?>