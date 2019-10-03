<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->owner_check();
	}

	public function index()
	{
		$data['judul']='Profile';
		$data['isi']='Kelola Profil Anda';
		$daa=array('idowner'=>$this->session->userdata('idowner'));
		$data['profile']=$this->data_model->getsomething('owner',$daa);
		$tmp['content']=$this->load->view('owner/profile',$data,true);
		$this->load->view('owner/template',$tmp);
	}

	public function Update()
	{
		if(!$this->input->post('password'))
		{
			$data=array(
				'nama_user'=>$this->input->post('nama_owner'),
				'telp_user'=>$this->input->post('telp_owner')
			);
			$this->data_model->update_something('owner',$data,$this->input->post('idowner'),'idowner');
			$this->session->set_flashdata('message',"modal-success");
			redirect("owner/profile");
		}
		else
		{
			$passm5=md5($this->input->post('password'));
			$data=array(
				'nama_user'=>$this->input->post('nama_owner'),
				'telp_user'=>$this->input->post('telp_owner'),
				'password'=>$passm5
			);
			$this->data_model->update_something('owner',$data,$this->input->post('idowner'),'idowner');
			$this->session->set_flashdata('message',"modal-success");
			redirect("owner/profile");
		}
	}
}