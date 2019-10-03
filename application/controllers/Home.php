<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') == TRUE && $this->session->userdata('owner') == TRUE) {
			$this->session->set_flashdata('message', "succes-login");
			redirect('owner/dashboard');
		} else if ($this->session->userdata('logged_in') == TRUE) {
			$this->session->set_flashdata('message', "succes-login");
			redirect('backoffice/dashboard');
		} else {
			$this->session->unset_userdata('role-reset');
			$this->session->unset_userdata('email-reset');

			$data['judul'] = 'Silahkan login';
			$this->load->view('login', $data);
		}
	}

	public function Login()
	{
		$log = $this->input->post('login');
		if ($log == 1) {
			$this->load->model('Login_owner_model');
			if ($this->input->post('email') and $this->input->post('password')) {
				$user = $this->input->post('email');
				$pass = md5($this->input->post('password'));
				$login_owner_model = new Login_owner_model();
				$login_cek = $login_owner_model->ngecek($user, $pass);

				if (count($login_cek) > 0) {
					$u = $this->input->post('email');
					$p = $pass;
					$login_cek = $login_owner_model->cek($u, $p);
				} else {
					$this->session->set_flashdata('message', "failed-login");
					redirect('home', 'refresh');
				}
			} else {
				$this->session->set_flashdata('message', "failed-login");
				redirect('home', 'refresh');
			}
		} else {
			// if ($this->input->post('email') and $this->input->post('password')) {
			// 	$user = $this->input->post('email');
			// 	$pass = md5($this->input->post('password'));

			// 	$login_cek = $this->login_model->ngecek($user, $pass);
			// 	if (count($login_cek) > 0) {
			// 		$u = $this->input->post('email');
			// 		$p = $pass;
			// 		$login_cek = $this->login_model->cek($u, $p);
			// 	} else {
			// 		$this->session->set_flashdata('message', "failed-login");
			// 		redirect('home', 'refresh');
			// 	}
			// } else {
			// 	$this->session->set_flashdata('message', "failed-login");
			// 	redirect('home', 'refresh');
			// }
			if ($this->input->post('username') and $this->input->post('password')) {
				$user = $this->input->post('username');
				$pass = md5($this->input->post('password'));

				$login_cek = $this->login_model->ngecek($user, $pass);
				if (count($login_cek) > 0) {
					$u = $this->input->post('username');
					$p = $pass;
					$login_cek = $this->login_model->cek($u, $p);
				} else {
					$this->session->set_flashdata('message', "failed-login");
					redirect('home', 'refresh');
				}
			} else {
				$this->session->set_flashdata('message', "failed-login");
				redirect('home', 'refresh');
			}
		}
	}

	public function Logout()
	{
		$email = $this->session->userdata('email_user');
		$password = $this->session->userdata('password');
		if ($this->session->userdata('owner') == TRUE) {
			$date = date("Y-m-d");
			$this->db->query("UPDATE owner SET session_id = '0', last_login = '$date' WHERE email_user = '$email' AND password = '$password'");
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('password');
			$this->session->unset_userdata('nama');
			$this->session->sess_destroy();
			$this->session->set_flashdata('message', "Logout");
			redirect('home', 'refresh');
		} else {
			$this->db->query("UPDATE user SET session_id = '0' WHERE email_user = '$email' AND password = '$password'");
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('password');
			$this->session->unset_userdata('nama');
			$this->session->sess_destroy();
			$this->session->set_flashdata('message', "Logout");
			redirect('home', 'refresh');
		}
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

	public function Register()
	{
		// test
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$nama = str_shuffle($alphanum);
		$data['idbusiness'] = $nama;
		$data['deskripsi'] = "Step pertama dalam wizard adalah memilih tipe bisnis yang anda inginkan, tipe bisnis akan menentukan modul apa yang akan anda gunakan dalam mengelola pos, stok akan menentukan apakah bisnis anda akan menggunakan stok atau tidak untuk tipe bisnis barbershop, salon kecantikan atau tipe bisnis yang bersifat jasa kami sarankan tidak menggunakan stok perhatian anda tidak bisa merubah tipe bisnis & stok bisnis yang telah diinputkan.";
		$whr = array('status_tb' => 1);
		$data['comtype'] = $this->db->query("SELECT * FROM businesstype_setup WHERE status_tb='1' AND idtb > '1'")->result();
		$tmp['content'] = $this->load->view('wizard/register', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register2()
	{
		// if ($this->session->userdata('step1') != 'step1')  {
		// 	redirect('home/register','refresh');
		// }

		$data['judul'] = 'Registrasi';
		$data['deskripsi'] = "Step kedua adalah nama bisnis, silahkan masukan nama bisnis anda dengan benar nama bisnis ini yang akan tercetak di dalam nota pembelian untuk setiap transaksi.";
		$tmp['content'] = $this->load->view('wizard/register2', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register3()
	{
		// if ($this->session->userdata('step2') != 'step2')  {
		// 	redirect('home/register2','refresh');
		// }

		$data['deskripsi'] = "Step ketiga adalah deskripsi bisnis, harap isi seluruh deskripsi bisnis anda dengan benar deskripsi bisnis akan tercetak di dalam nota setiap transaksi.";
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('wizard/register3', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register4()
	{
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$data['kode'] = str_shuffle($alphanum);
		$data['deskripsi'] = "Step keempat adalah data owner, silahkan mengisi data owner bisnis anda dengan benar owner bisnis adalah pimpinan tertinggi bisnis anda.";
		$data['judul'] = 'Registrasi';
		$tmp['content'] = $this->load->view('wizard/register4', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register5()
	{
		$data['deskripsi'] = "Step kelima adalah outlet/kantor silahkan masukan data otlet/kantor anda, jika anda memiliki kantor pusat tolong isikan alamat kantor pusat anda, setelah proses registrasi selesai anda dapat menambahkan outlet di backoffice. Anda dapat menambah outlet anda pada backoffice maksimal 5 outlet";
		$data['judul'] = 'Registrasi';
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('wizard/register5', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register6()
	{
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$data['kode'] = str_shuffle($alphanum);
		$data['deskripsi'] = "Step keenam adalah data backofficer, backofficer adalah orang yang mengelola bisnis anda mulai dari mengelola karyawan, outlet, produk, stock, pajak, modifier dan lain-lain.";
		$data['judul'] = 'Registrasi';
		$tmp['content'] = $this->load->view('wizard/register6', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register7()
	{
		$data['deskripsi'] = "Apakah anda sudah melengkapi seluruh data dengan benar ? Jika sudah klik tombol finish untuk menginputkan data anda.";
		$data['judul'] = 'Registrasi';
		$tmp['content'] = $this->load->view('wizard/register7', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Register8()
	{
		$data['deskripsi'] = "Selesai registrasi, terimakasih telah mendaftar.";
		$data['judul'] = 'Registrasi';
		$tmp['content'] = $this->load->view('wizard/register8', $data, true);
		$this->load->view('template_register', $tmp);
	}

	public function Step1()
	{
		$sess_data['step1'] = 'step1';
		$sess_data['typ_business'] = $this->input->post('business_type');
		$sess_data['stok'] = $this->input->post('stok');
		$sess_data['unik_idbisnis'] = $this->input->post('id_new');
		$this->session->set_userdata($sess_data);
		redirect("home/register2");
	}

	public function Step2()
	{
		$sess_data['step2'] = 'step2';
		$sess_data['nama_business'] = $this->input->post('nama_business');
		$this->session->set_userdata($sess_data);
		redirect("home/register3");
	}

	public function Step3()
	{
		$sess_data['desc_business'] = $this->input->post('description_business');
		$sess_data['prov_business'] = $this->input->post('provinsi');
		$sess_data['kab_business'] = $this->input->post('kabupaten');
		$sess_data['kec_business'] = $this->input->post('kecamatan');
		$sess_data['ala_business'] = $this->input->post('alamat_business');
		$sess_data['tlp_business'] = $this->input->post('tlp_bisnis');
		$sess_data['email_business'] = $this->input->post('email_bisnis');
		$this->session->set_userdata($sess_data);
		redirect("home/register4");
	}

	public function Step4()
	{
		$sess_data['nama_own'] = $this->input->post('nama_own');
		$sess_data['telp_own'] = $this->input->post('telp');
		$sess_data['email_own'] = $this->input->post('email_own');
		$sess_data['password_own'] = $this->input->post('password_own');
		$sess_data['kode_own'] = $this->input->post('kode_own');
		$this->session->set_userdata($sess_data);

		$whr = array('email_user' => $this->input->post('email_own'));
		$cek = $this->data_model->Count_where('owner', $whr);

		if ($cek > 0) {
			$this->session->set_flashdata("message", "user-dipakai");
			redirect("home/register4", 'refresh');
		} else {
			redirect("home/register5");
		}
	}

	public function Step5()
	{
		$sess_data['nama_out'] = $this->input->post('nama_out');
		$sess_data['prov_out'] = $this->input->post('provinsi');
		$sess_data['kab_out'] = $this->input->post('kabupaten');
		$sess_data['kec_out'] = $this->input->post('kecamatan');
		$sess_data['telp_out'] = $this->input->post('kecamatan');
		$sess_data['ala_out'] = $this->input->post('alamat');
		$sess_data['zip_out'] = $this->input->post('zip');
		$sess_data['pjk_out'] = $this->input->post('tax');

		$this->session->set_userdata($sess_data);
		redirect("home/register6");
	}

	public function Step6()
	{
		$sess_data['nama_kar'] = $this->input->post('nama_kar');
		$sess_data['username_kar'] = $this->input->post('username');
		$sess_data['kode_bo'] = $this->input->post('kode_bo');
		$sess_data['telp_kar'] = $this->input->post('telp_kar');
		$sess_data['password_kar'] = $this->input->post('password');
		$this->session->set_userdata($sess_data);

		$whr = array('email_user' => $this->input->post('email_kar'));
		$cek = $this->data_model->Count_where('user', $whr);

		if ($cek > 0) {
			$this->session->set_flashdata("message", "user-dipakai");
			redirect("home/register6", 'refresh');
		} else {
			redirect("home/register7", 'refresh');
		}
	}

	public function Step7()
	{
		$passown = md5($this->session->userdata('password_own'));
		$str_email_own = $this->session->userdata('email_own');
		$data_own = array(
			'nama_user' => $this->session->userdata('nama_own'),
			'telp_user' => $this->session->userdata('telp_own'),
			'email_user' => strtolower($str_email_own),
			'register_id' => $this->session->userdata('kode_own'),
			'password' => $passown,
			'status_user' => 0,
			'idSA' => 1
		);
		$this->data_model->insert_something('owner', $data_own);

		$email_own = $this->session->userdata('email_own');
		$sel_own = $this->db->query("SELECT idowner FROM owner WHERE email_user='$email_own' AND password='$passown'")->result();

		foreach ($sel_own as $rw) :
			$id_owner = $rw->idowner;
		endforeach;
		$str_email_bus = $this->session->userdata('email_business');
		$data_bus = array(
			'province_id' => $this->session->userdata('prov_business'),
			'regencies_id' => $this->session->userdata('kab_business'),
			'district_id' => $this->session->userdata('kec_business'),
			'nama_business' => $this->session->userdata('nama_business'),
			'idowner' => $id_owner,
			'alamat_business' => $this->session->userdata('ala_business'),
			'tlp_business' => $this->session->userdata('tlp_business'),
			'email_business' => strtolower($str_email_bus),
			'stok' => $this->session->userdata('stok'),
			'description_business' => $this->session->userdata('desc_business'),
			'img_business' => 'noimage.png',
			'idtb' => $this->session->userdata('typ_business'),
			'status_business' => 1,
			'register_business' => $this->session->userdata('unik_idbisnis')
		);
		$this->data_model->insert_something('business', $data_bus);

		$unik_id = $this->session->userdata('unik_idbisnis');
		$sel_bus = $this->db->query("SELECT idbusiness FROM business WHERE idowner='$id_owner' AND register_business='$unik_id'")->result();

		foreach ($sel_bus as $rw) :
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
			'settax_outlet' => $this->session->userdata('pjk_out'),
			'status_outlet' => 1
		);
		$this->data_model->insert_something('outlet', $data_out);
		$id_out = $this->db->insert_id();

		// saat outlet dibikin, create sales_type default -> Dine In
		$data_sales_type = array(
			'idbusiness' => $id_business,
			'idoutlet' => $id_out,
			'nama_saltype' => "Dine In",
			'lock' => 1,
			'status_saltype' => 1,
		);

		$this->data_model->insert_something('sales_type', $data_sales_type);

		$passkar = md5($this->session->userdata('password_kar'));
		//$str_email_kar = $this->session->userdata('email_kar');
		$str_username_kar = $this->session->userdata('username_kar');
		$data_us = array(
			'nama_user' => $this->session->userdata('nama_kar'),
			'telp_user' => $this->session->userdata('telp_kar'),
			'username' => strtolower($str_username_kar),
			'kode_user' => $this->session->userdata('kode_bo'),
			'password' => $passkar,
			'role_user' => 2,
			'del' => 1,
			'idbusiness' => $id_business,
			'status_user' => 1
		);
		$this->data_model->insert_something('user', $data_us);

		$this->email_owner();
		//$this->email_manajer();

		$this->session->unset_userdata('nama_business');
		$this->session->unset_userdata('prov_business');
		$this->session->unset_userdata('kab_business');
		$this->session->unset_userdata('kec_business');
		$this->session->unset_userdata('ala_business');
		$this->session->unset_userdata('tlp_business');
		$this->session->unset_userdata('desc_business');
		$this->session->unset_userdata('typ_business');
		$this->session->unset_userdata('telp_own');
		$this->session->unset_userdata('nama_own');
		$this->session->unset_userdata('email_own');
		$this->session->unset_userdata('password_own');
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
		$this->session->unset_userdata('email_kar');
		$this->session->unset_userdata('telp_kar');

		$this->session->sess_destroy();
		redirect("home/register8", 'refresh');
	}

	public function Email_manajer()
	{
		$hui['email'] = $this->session->userdata('email_kar');
		$hui['password'] = $this->session->userdata('password_kar');
		$hui['kode_user'] = $this->session->userdata('kode_bo');
		$email = $this->session->userdata('email_kar');
		$message = $this->load->view('register_manajer', $hui, TRUE);
		require_once(APPPATH . "third_party/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'aioposapps@gmail.com';                          // SMTP username
		$mail->Password = '1234Aiopos';                                 // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('aioposapps@gmail.com', 'AIO POS');                          // Set Sender Name
		$mail->addAddress($email);                                // Name is optional
		$mail->isHTML(true);
		$mail->AddEmbeddedImage(FCPATH . "assets/group2.png", 'logo_up');
		$mail->Subject = 'Konfirmasi Registrasi';

		$mail->MsgHTML(stripslashes($message));
		$mail->send();
	}

	public function cekUsrExist()
	{
		$usr = $this->input->post('username');

		$whr = array(
			'username' => $usr,
		);
		$is_exist = $this->db->get_where('user', $whr);
		if ($is_exist->num_rows() > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	public function Email_owner()
	{
		// test API

		// $email = $this->input->post('email_own');
		// $hui['email'] = $this->input->post('email_own');
		// $hui['password'] = $this->input->post('password_own');
		// $hui['kode_own'] = $this->input->post('kode_own');

		// end test API

		$hui['email'] = $this->session->userdata('email_own');
		$hui['password'] = $this->session->userdata('password_own');
		$hui['kode_own'] = $this->session->userdata('kode_own');
		$email = $this->session->userdata('email_own');
		$message = $this->load->view('register_owner', $hui, TRUE);
		require_once(APPPATH . "third_party/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'aioposapps@gmail.com';                          // SMTP username
		$mail->Password = '1234Aiopos';                                 // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('aioposapps@gmail.com', 'AIO POS');                          // Set Sender Name
		$mail->addAddress($email);                                // Name is optional
		$mail->isHTML(true);
		$mail->AddEmbeddedImage(FCPATH . "assets/group2.png", 'logo_up');
		$mail->Subject = 'Konfirmasi Registrasi';

		$mail->MsgHTML(stripslashes($message));
		$mail->send();
		// echo json_encode("kirim");
	}
}
