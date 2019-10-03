<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->uri->uri_string() != 'administrator/login') {
			$this->security_model->admin_check();
		}
	}

	public function index()
	{
		// cek jika klient sudah lama tidak aktif

		$clients = $this->db->query('
			SELECT idowner, nama_user FROM owner WHERE status_user = 1 AND TIMESTAMPDIFF(DAY,last_login, NOW()) >= 365
		')->result();

		// update status ke 0
		$data = array('status_user' => 0);
		foreach ($clients as $c) {
			$this->data_model->Update_something('owner', $data, $c->idowner, 'idowner');
		}

		// get data owner
		$this->db->order_by('idowner', 'desc');
		$owners = $this->db->get('owner')->result();

		$data['judul'] = 'Dashboard';
		$data['isi'] = 'Kelola Dashboard';
		// $data['owners'] = $this->data_model->Get_all('owner');
		$data['owners'] = $owners;
		$data['aktif'] = $this->data_model->Count_where('owner', array('status_user' => 1));
		$data['nonaktif'] = $this->data_model->Count_where('owner', array('status_user' => 0));
		$data['owner_count'] = $this->data_model->Count_total('owner');
		$tmp['content'] = $this->load->view('administrator/dashboard', $data, true);
		$this->load->view('administrator/template', $tmp);
	}

	public function edit_owner()
	{
		$ids = $this->uri->segment(3);
		$own = $this->db->select('idowner, nama_user,telp_user, email_user,last_login,session_id')
			->from('owner')
			->where('idowner', $ids)
			->get()->row();

		if ($own->session_id == 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$id = $this->input->post('idowner');
				$email_owner_input = $this->input->post('email_checked');
				$data = array(
					'nama_user' => $this->input->post('nama_user'),
					'telp_user' => $this->input->post('telp_user'),
				);

				if ($this->input->post('password')) {
					$data["password"] = md5($this->input->post('password'));
				}

				if ($email_owner_input) {
					$data["email_user"] = $email_owner_input;
					$data["status_user"] = 0;
				}

				$this->data_model->Update_something('owner', $data, $id, 'idowner');
				$this->session->set_flashdata('message', "Data Owner Berhasil Diupdate-modal");
				redirect("administrator");
			} else {
				$data['judul'] = 'Edit Owner';
				$data['isi'] = 'Kelola Owner';
				$data['row'] = $own;

				$tmp['content'] = $this->load->view('administrator/edit_client', $data, true);
				$this->load->view('administrator/template', $tmp);
			}
		} else {
			$this->session->set_flashdata('message', "Owner Sedang Aktif-modal");
			redirect("administrator");
		}
	}

	public function bisnis_owner($idowner)
	{
		$whr = array('idowner' => $idowner, 'status_business' => 1);
		$this->db->order_by('idbusiness', 'desc');
		$business = $this->db->get_where('business', $whr);

		$data['judul'] = 'Dashboard';
		$data['isi'] = 'Kelola Bisnis Owner';
		$data['business'] = $business->result();
		$data['business_count'] = $business->num_rows();
		$tmp['content'] = $this->load->view('administrator/bisnis_owner', $data, true);
		$this->load->view('administrator/template', $tmp);
	}

	public function checkEmailExist()
	{
		$email = $this->input->post('email_checked');
		$is_exist = $this->db->select('email_user')
			->from('owner')
			->where('email_user', $email)->get()->row();
		if ($is_exist) {
			echo "false";
		} else {
			echo "true";
		}
	}
	public function getEmailOwnerJSN($id)
	{
		$emailOwner = $this->db->select('email_user')->from('owner')->where('idowner', $id)->get()->row();
		echo json_encode($emailOwner);
	}

	public function block_owner($id)
	{
		// non-aktifkan owner 
		$data_owner = array('status_user' => 0);
		$this->data_model->Update_something('owner', $data_owner, $id, 'idowner');

		// non-aktifkan bisnis 
		$data_business = array('status_business' => 0);
		$this->data_model->Update_something('business', $data_business, $id, 'idowner');

		$this->session->set_flashdata('message', "Owner Berhasil Diblock-modal");
		redirect("administrator");
	}

	public function aktif_owner($id)
	{
		$data_owner = array('status_user' => 1);
		$this->data_model->Update_something('owner', $data_owner, $id, 'idowner');

		$data_business = array('status_business' => 1);
		$this->data_model->Update_something('business', $data_business, $id, 'idowner');

		$this->session->set_flashdata('message', "Owner Berhasil Diaktifkan-modal");
		redirect("administrator");
	}

	public function delete()
	{
		$sess['idowner'] = $this->input->post('idowner');
		$this->session->set_userdata($sess);

		$this->data_model->Delete_something('owner', array('idowner' =>  $this->session->userdata('idowner')));

		$business = $this->data_model->Getsomething('business', array('idowner' => $this->session->userdata('idowner')));
		foreach ($business as $d) {
			// $sess['id_business'] = $d->idbusiness;
			// $this->session->set_userdata( $sess );
			// $sess_idbusiness =  $this->session->userdata('id_business');

			// delete business
			$this->data_model->Delete_something('business', array('idbusiness' =>  $d->idbusiness));
			// delete outlet
			$this->data_model->Delete_something('outlet', array('idbusiness' =>  $d->idbusiness));
			// delete produk
			$this->data_model->Delete_something('produk', array('idbusiness' =>  $d->idbusiness));
			// delete payment-setup
			$this->data_model->Delete_something('payment_setup', array('idbusiness' =>  $d->idbusiness));
			// delete trans-header
			$this->data_model->Delete_something('trans_header', array('idbusiness' =>  $d->idbusiness));
			// delete user
			$this->data_model->Delete_something('user', array('idbusiness' =>  $d->idbusiness));
			// delete tax
			$this->data_model->Delete_something('tax', array('idbusiness' =>  $d->idbusiness));
			// delete customer
			$this->data_model->Delete_something('customer', array('idbusiness' =>  $d->idbusiness));
		}
		$this->session->unset_userdata('idowner');
		$this->session->set_flashdata('message', "Owner Berhasil Dihapus-modal");
		redirect("administrator");
	}

	// public function clients()
	// {
	// 	$data['judul'] = 'AIO POS Clients';
	//     	$data['isi'] = '';
	//     	$tmp['content'] = $this->load->view('administrator/clients', $data, true);
	//     	$this->load->view('administrator/template', $tmp);
	// }

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$email = $this->input->post('email');
			$pass = md5($this->input->post('password'));
			$cek = $this->db->get_where('sa_ultrapos', array('email_SA' => $email, 'password_SA' => $pass))->row();
			if (!empty($cek)) {
				$sess = array(
					'id' => $cek->idSA,
					'nama_SA' => $cek->nama_SA,
					'emai_SA' => $cek->emai_SA,
					'admin' => TRUE,
				);
				$this->session->set_userdata($sess);
				// $this->session->set_flashdata('message',"succes-login");
				redirect('administrator');
			} else {
				$this->session->set_flashdata('message', "failed-login");
				redirect('administrator/login', 'refresh');
			}
		} else {
			$data['judul'] = 'Silahkan login';
			$this->load->view('login', $data);
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('administrator/login', 'refresh');
	}
}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */
