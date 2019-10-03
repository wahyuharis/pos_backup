<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul']='Profile';
		$data['isi']='Kelola Profil Anda';
		$daa=array('iduser'=>$this->session->userdata('iduser'));
		$data['profile']=$this->data_model->getsomething('user',$daa);
		$tmp['content']=$this->load->view('backoffice/profile/profile',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Update()
	{
		if(!$this->input->post('password'))
		{
			$data=array(
				'nama_user'=>$this->input->post('nama_user'),
				'telp_user'=>$this->input->post('telp_user')
			);
			$this->data_model->update_something('user',$data,$this->input->post('iduser'),'iduser');
			$this->session->set_flashdata('message',"modal-success");
			redirect("backoffice/profile");
		}
		else
		{
			$passm5=md5($this->input->post('password'));
			$data=array(
				'nama_user'=>$this->input->post('nama_user'),
				'telp_user'=>$this->input->post('telp_user'),
				'password'=>$passm5
			);
			$this->data_model->update_something('user',$data,$this->input->post('iduser'),'iduser');
			$this->session->set_flashdata('message',"modal-success");
			redirect("backoffice/profile");
		}
	}
}