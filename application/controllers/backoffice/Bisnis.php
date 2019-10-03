<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Bisnis extends CI_Controller
{
	private $idbusiness;
	// test

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
		$this->idbusiness = $this->session->userdata('id_business');
	}

	public function index()
	{
		$data['judul'] = 'Bisnis';
		$data['isi'] = 'Edit Bisnis';
		$wh = array('status_tb' => 1);
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$data['comtyp'] = $this->data_model->getsomething('businesstype_setup', $wh);
		$daa = array('idbusiness' => $this->session->userdata('id_business'));
		$data['bisnis'] = $this->data_model->getsomething('business', $daa);
		$tmp['content'] = $this->load->view('backoffice/bisnis', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	function ambil_data()
	{
		$modul = $this->input->post('modul');
		$id = $this->input->post('id');
		if ($modul == "kabupaten") {
			echo $this->data_model->kabupaten($id);
		} else if ($modul == "kecamatan") {
			echo $this->data_model->kecamatan($id);
		}
	}

	public function Update_bisnis()
	{

		// delete gambar yang ada di server
		$img_business = $this->db->get_where('business', ['idbusiness'=> $this->idbusiness])->row()->img_business;

		if ($img_business != 'noimage.png') {
			$old = 'picture/150/'.$img_business;
			if (file_exists($old)) {
				unlink($old);
			}
		}


		$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$nama = str_shuffle($alphanum);
		$config['upload_path'] = "picture"; // lokasi penyimpanan file
		$config['allowed_types'] = 'gif|jpg|png|JPEG'; // format foto yang diizinkan 
		$config['file_name'] = $nama;
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('logo')) {
			$daat = array(
				'province_id' => $this->input->post('provinsi'),
				'regencies_id' => $this->input->post('kabupaten'),
				'district_id' => $this->input->post('kecamatan'),
				'nama_business' => $this->input->post('nama_business'),
				'alamat_business' => $this->input->post('alamat_business'),
				'tlp_business' => $this->input->post('tlp_bisnis'),
				'website_business' => $this->input->post('website_business'),
				'instagram_business' => $this->input->post('instagram_business'),
				'twitter_business' => $this->input->post('twitter_business'),
				'facebook_business' => $this->input->post('facebook_business'),
				'description_business' => $this->input->post('description_business'),
				//'idtb'=>$this->input->post('business_type')
			);

			$this->data_model->update_something('business', $daat, $this->input->post('unik_id'), 'register_business');
			$this->session->set_flashdata('message', "modal-success");
			redirect('backoffice/bisnis', 'refresh');
		} else {
			$daat = array(
				'province_id' => $this->input->post('provinsi'),
				'regencies_id' => $this->input->post('kabupaten'),
				'district_id' => $this->input->post('kecamatan'),
				'nama_business' => $this->input->post('nama_business'),
				'alamat_business' => $this->input->post('alamat_business'),
				'tlp_business' => $this->input->post('tlp_bisnis'),
				'website_business' => $this->input->post('website_business'),
				'instagram_business' => $this->input->post('instagram_business'),
				'twitter_business' => $this->input->post('twitter_business'),
				'facebook_business' => $this->input->post('facebook_business'),
				'description_business' => $this->input->post('description_business'),
				//'idtb'=>$this->input->post('business_type'),
				'img_business' => $this->upload->file_name
			);

			$gbr = $this->upload->data();
			$this->load->library("Image_moo");
			$image_moo = new Image_moo();
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(50, 50, true)->save($gbr['full_path'], true);

			$this->data_model->update_something('business', $daat, $this->input->post('unik_id'), 'register_business');
			$this->session->set_flashdata('message', "modal-success");
			redirect('backoffice/bisnis', 'refresh');
		}
	}
}
