<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Business extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->security_model->owner_check();
	}

	public function index()
	{

		$data['judul'] = 'Dashboard';
		$data['isi'] = 'Kelola Dashboard';
		$where = array(
			'idowner' => $this->session->userdata('idowner'),
			'status_business' => 1
		);
		$this->db->where($where);
		$data['data'] = $this->db->get('business')->result();

		$tmp['content'] = $this->load->view('owner/business', $data, true);
		$this->load->view('owner/template', $tmp);
	}

	public function add()
	{
		$this->edit();
	}

	public function Edit($idbusiness = null)
	{
		$data['judul'] = 'Bisnis';
		$data['isi'] = 'Edit Bisnis';

		if ($_POST) {
			$this->submit();
		}

		$form = array(
			'id' => $idbusiness,
			'img_show' => base_url() . '/picture/B068EH5D7F4AW1MCPG3LIYUNQRVZOS92KXTJ.png',
			'img_business' => '',
			'business_description' => '',
			'business_name' => '',
			'province' => '',
			'regency' => '',
			'district' => '',
			'alamat' => '',
			'tlp_business' => '',
			'website_business' => '',
			'instagram_business' => '',
			'twitter_business' => '',
			'facebook_business' => '',
		);

		$this->db->where('idbusiness', $idbusiness);
		$res = $this->db->get('business')->row_array();

		$this->load->helper('haris_helper');

		$res1 = $this->db->get('tb_provinces')->result_array();
		$opt_provinces = create_dropdown_array($res1, 'id', 'name');

		$res2 = $this->db->get('tb_regencies')->result_array();
		$opt_regencies = create_dropdown_array($res2, 'id', 'name');

		$res3 = $this->db->get('tb_districts')->result_array();
		$opt_districts = create_dropdown_array($res3, 'id', 'name');

		$tb = $res['idtb'];
		$sele = $this->db->query("SELECT namatype_business FROM businesstype_setup WHERE idtb = '$tb'")->row_array();

		$form = array(
			'id' => $idbusiness,
			'img_show' => base_url() . '/picture/150/' . $res['img_business'],
			'img_business' => $res['img_business'],
			'business_description' => $res['description_business'],
			'business_name' => $res['nama_business'],
			'province' => $res['province_id'],
			'regency' => $res['regencies_id'],
			'district' => $res['district_id'],
			'opt_provinces' => $opt_provinces,
			'opt_regencies' => $opt_regencies,
			'opt_districts' => $opt_districts,
			'alamat' => $res['alamat_business'],
			'tlp_business' => $res['tlp_business'],
			'website_business' => $res['website_business'],
			'instagram_business' => $res['instagram_business'],
			'twitter_business' => $res['twitter_business'],
			'facebook_business' => $res['facebook_business'],
			'idtb' => $sele['namatype_business']
		);

		$data['form'] = $form;

		$tmp['content'] = $this->load->view('owner/business_edit', $data, true);
		$this->load->view('owner/template', $tmp);
	}

	private function Submit()
	{
		$this->load->library('upload');

		$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$nama = str_shuffle($alphanum);
		$config['upload_path'] = "picture"; // lokasi penyimpanan file
		$config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|PNG|JPEG'; // format foto yang diizinkan 
		$this->upload->initialize($config);
		$image_name = "";

		if (!$this->upload->do_upload('img_business')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$upload_data = array('upload_data' => $this->upload->data());
			$image_name = $upload_data['upload_data']['file_name'];

			$gbr = $this->upload->data();

			$this->load->library("Image_moo");
			$image_moo = new Image_moo();
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(50, 50, true)->save($gbr['full_path'], true);
		}

		$save = array(
			'province_id' => $this->input->post('province'),
			'regencies_id' => $this->input->post('regency'),
			'district_id' => $this->input->post('district'),
			'idowner' => $this->session->userdata('idowner'),
			'nama_business' => $this->input->post('business_name'),
			'alamat_business' => $this->input->post('alamat'),
			'tlp_business' => $this->input->post('tlp_business'),
			'website_business' => $this->input->post('website_business'),
			'instagram_business' => $this->input->post('instagram_business'),
			'twitter_business' => $this->input->post('twitter_business'),
			'facebook_business' => $this->input->post('facebook_business'),
			'description_business' => $this->input->post('business_description'),
		);

		if (!empty($image_name)) {
			$save['img_business'] = $image_name;
		}

		if (!empty($this->input->post('idbusiness'))) {
			$this->db->where('idbusiness', $this->input->post('idbusiness'));
			$this->db->update('business', $save);

			redirect('owner/business/edit/' . $this->input->post('idbusiness'));
		} else {
			$this->db->insert('business', $save);

			redirect('owner/business/edit/' . $this->db->insert_id);
		}
	}

	public function ambil_data()
	{
		$this->load->model('Data_model');
		$modul = $this->input->get('modul');
		$id = $this->input->get('id');
		if ($modul == "kabupaten") {
			$kabupaten = new Data_model();
			echo $kabupaten->kabupaten($id);
		} else if ($modul == "kecamatan") {
			$kecamatan = new Data_model();
			echo $kecamatan->kecamatan($id);
		}
	}

	public function Tambah_business()
	{
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$nama = str_shuffle($alphanum);

		$data['judul'] = 'Bisnis';
		$data['isi'] = 'Tambah Bisnis';
		$data['idbusiness'] = $nama;
		$wh = array('status_tb' => 1);
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$data['comtyp'] = $this->data_model->getsomething('businesstype_setup', $wh);
		$tmp['content'] = $this->load->view('owner/tambah_business1', $data, true);
		$this->load->view('owner/template', $tmp);
	}

	public function Tambah_business2()
	{
		$data['judul'] = 'Outlet';
		$data['isi'] = 'Tambah Data Outlet';
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('owner/tambah_business2', $data, true);
		$this->load->view('owner/template', $tmp);
	}

	public function Tambah_business3()
	{
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$data['kode'] = str_shuffle($alphanum);
		$data['judul'] = 'Karyawan';
		$data['isi'] = 'Tambah Data karyawan';
		$tmp['content'] = $this->load->view('owner/tambah_business3', $data, true);
		$this->load->view('owner/template', $tmp);
	}

	public function Step1()
	{
		$sess_data['nama_business'] = $this->input->post('nama_business');
		$sess_data['prov_business'] = $this->input->post('provinsi');
		$sess_data['kab_business'] = $this->input->post('kabupaten');
		$sess_data['kec_business'] = $this->input->post('kecamatan');
		$sess_data['ala_business'] = $this->input->post('alamat_business');
		$sess_data['tlp_business'] = $this->input->post('tlp_bisnis');
		$sess_data['typ_business'] = $this->input->post('business_type');
		$sess_data['desc_business'] = $this->input->post('description_business');
		$sess_data['web_business'] = $this->input->post('website_business');
		$sess_data['fac_business'] = $this->input->post('facebook_business');
		$sess_data['ins_business'] = $this->input->post('instagram_business');
		$sess_data['twt_business'] = $this->input->post('twitter_business');
		$sess_data['unik_idbisnis'] = $this->input->post('id_new');
		$sess_data['stok_nb'] = $this->input->post('stok');
		$sess_data['email_business'] = $this->input->post('email_business');

		$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$nama = str_shuffle($alphanum);
		$config['upload_path'] = "picture";
		$config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
		$config['file_name'] = $nama;
		$this->upload->initialize($config);

		if ($this->upload->do_upload('logo')) {
			$sess_data['log_business'] = $this->upload->file_name;


			$gbr = $this->upload->data();

			$this->load->library("Image_moo");
			$image_moo = new Image_moo();
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
			$image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(50, 50, true)->save($gbr['full_path'], true);
		} else {
			$sess_data['log_business'] = "noimage.png";
		}
		$this->session->set_userdata($sess_data);
		redirect("owner/business/tambah_business2");
	}

	public function Step2()
	{
		$sess_data['nama_out'] = $this->input->post('nama_outlet');
		$sess_data['prov_out'] = $this->input->post('provinsi');
		$sess_data['kab_out'] = $this->input->post('kabupaten');
		$sess_data['kec_out'] = $this->input->post('kecamatan');
		$sess_data['telp_out'] = $this->input->post('kecamatan');
		$sess_data['ala_out'] = $this->input->post('alamat');
		$sess_data['zip_out'] = $this->input->post('zip');
		$sess_data['pjk_out'] = $this->input->post('tax');

		$this->session->set_userdata($sess_data);
		redirect("owner/business/tambah_business3");
	}

	public function Step3()
	{
		$sess_data['nama_kar'] = $this->input->post('nama_karyawan');
		$sess_data['username_kar'] = $this->input->post('username');
		// $sess_data['email_kar'] = $this->input->post('email_karyawan');
		$sess_data['telp_kar'] = $this->input->post('telp');
		$this->session->set_userdata($sess_data);

		// $whr = array('email_user' => $this->input->post('email_karyawan'));
		// $cek = $this->data_model->Count_where('user', $whr);

		// if ($cek > 0) {
		// 	$this->session->set_flashdata("message", "user-dipakai");
		// 	redirect("owner/business/tambah_business3", 'refresh');
		// } else {
		$data_bus = array(
			'province_id' => $this->session->userdata('prov_business'),
			'regencies_id' => $this->session->userdata('kab_business'),
			'district_id' => $this->session->userdata('kec_business'),
			'nama_business' => $this->session->userdata('nama_business'),
			'idowner' => $this->session->userdata('idowner'),
			'alamat_business' => $this->session->userdata('ala_business'),
			'tlp_business' => $this->session->userdata('tlp_business'),
			'website_business' => $this->session->userdata('web_business'),
			'instagram_business' => $this->session->userdata('ins_business'),
			'twitter_business' => $this->session->userdata('twt_business'),
			'email_business' => $this->session->userdata('email_business'),
			'facebook_business' => $this->session->userdata('fac_business'),
			'description_business' => $this->session->userdata('desc_business'),
			'img_business' => $this->session->userdata('log_business'),
			'idtb' => $this->session->userdata('typ_business'),
			'status_business' => 1,
			'stok' => $this->session->userdata('stok_nb'),
			'register_business' => $this->session->userdata('unik_idbisnis'),
		);
		$this->data_model->insert_something('business', $data_bus);

		$idowner = $this->session->userdata('idowner');
		$unik_id = $this->session->userdata('unik_idbisnis');
		$sel = $this->db->query("SELECT idbusiness FROM business WHERE idowner='$idowner' AND register_business='$unik_id'")->result();

		foreach ($sel as $rw) :
			$id_business = $rw->idbusiness;
		endforeach;

		$data_out = array(
			'idbusiness' => $id_business,
			'province_id' => $this->session->userdata('prov_out'),
			'regencies_id' => $this->session->userdata('kab_out'),
			'district_id' => $this->session->userdata('kec_out'),
			'name_outlet' => $this->session->userdata('nama_out'),
			'alamat_outlet' => $this->session->userdata('ala_out'),
			'zip_outlet' => $this->session->userdata('zip_out'),
			'telp_outlet' => $this->session->userdata('telp_out'),
			'settax_outlet' => $this->session->userdata('pjk_out'),
			'status_outlet' => '1'
		);

		$this->data_model->insert_something('outlet', $data_out);
		// saat outlet dibikin, create sales_type default -> Dine In
		$data_sales_type = array(
			'idbusiness' => $id_business,
			'idoutlet' => $this->session->userdata('nama_out'),
			'nama_saltype' => "Dine In",
			'lock' => 1,
			'status_saltype' => 1,
		);
		$this->data_model->insert_something('sales_type', $data_sales_type);

		$passm5 = md5($this->input->post('password'));
		$data_us = array(
			'nama_user' => $this->session->userdata('nama_kar'),
			'telp_user' => $this->session->userdata('telp_kar'),
			// 'email_user' => $this->session->userdata('email_kar'),
			'username' => $this->session->userdata('username_kar'),
			'password' => $passm5,
			'role_user' => '2',
			'idbusiness' => $id_business,
			'del' => '1',
			'kode_user' => $this->input->post('kode_user'),
			'status_user' => 1
		);
		$this->data_model->insert_something('user', $data_us);

		// $hui['email'] = $this->input->post('email_karyawan');
		// $hui['password'] = $this->input->post('password');
		// $hui['kode'] = $this->input->post('kode_user');
		// $hui['role'] = '2';
		// $email = $this->input->post('email_karyawan');
		// $message = $this->load->view('backoffice/karyawan/email_karyawan', $hui, TRUE);
		// require_once(APPPATH . "third_party/phpmailer/PHPMailerAutoload.php");
		// $mail = new PHPMailer;
		// $mail->isSMTP();
		// $mail->Host = 'smtp.gmail.com';
		// $mail->SMTPAuth = true;
		// $mail->Username = 'aioposapps@gmail.com';
		// $mail->Password = '1234Aiopos';
		// $mail->SMTPSecure = 'ssl';
		// $mail->Port = 465;
		// $mail->setFrom('aioposapps@gmail.com', 'AIO POS');
		// $mail->addAddress($email);
		// $mail->isHTML(true);
		// $mail->AddEmbeddedImage(FCPATH . "assets/group2.png", 'logo_up');
		// $mail->Subject = 'Konfirmasi Registrasi';

		// $mail->MsgHTML(stripslashes($message));
		// $mail->send();

		$this->session->unset_userdata('nama_business');
		$this->session->unset_userdata('prov_business');
		$this->session->unset_userdata('kab_business');
		$this->session->unset_userdata('kec_business');
		$this->session->unset_userdata('ala_business');
		$this->session->unset_userdata('tlp_business');
		$this->session->unset_userdata('desc_business');
		$this->session->unset_userdata('web_business');
		$this->session->unset_userdata('fac_business');
		$this->session->unset_userdata('ins_business');
		$this->session->unset_userdata('twt_business');
		$this->session->unset_userdata('unik_idbisnis');
		$this->session->unset_userdata('nama_out');
		$this->session->unset_userdata('prov_out');
		$this->session->unset_userdata('kab_out');
		$this->session->unset_userdata('kec_out');
		$this->session->unset_userdata('telp_out');
		$this->session->unset_userdata('ala_out');
		$this->session->unset_userdata('zip_out');
		$this->session->unset_userdata('pjk_out');
		$this->session->unset_userdata('nama_kar');
		$this->session->unset_userdata('username_kar');
		$this->session->unset_userdata('telp_kar');
		$this->session->unset_userdata('log_business');
		$this->session->unset_userdata('email_business');
		$this->session->unset_userdata('stok_nb');
		$this->session->unset_userdata('typ_business');
		$this->session->unset_userdata('log_business');

		$this->session->set_flashdata("message", "modal-success");
		redirect("owner/business", 'refresh');
		// }
	}

	public function cekUsrExist()
	{
		$usr = $this->input->post('username');
		$cek = $this->db->get_where('user', ['username' => $usr])->num_rows();
		echo $cek > 0 ? 'false' : 'true';
	}
}
