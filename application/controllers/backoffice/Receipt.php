<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Receipt extends CI_Controller
{
	private $idbusiness;
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


		$whr = array('idbusiness' => $this->idbusiness);
		$whroutlet = array('idbusiness' => $this->idbusiness, 'status_outlet' => 1);

		$data['provinsi'] = $this->db->get('tb_provinces')->result();
		$data['business'] = $this->db->get_where('business', $whr)->row();
		$data['outlet'] = $this->data_model->getsomething('outlet', $whroutlet);
		$tmp['content'] = $this->load->view('backoffice/receipt/edit_receipt', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function receiptJSON($outlet_id)
	{
		// query select receipt berdasarkan business dan outlet
		$this->db->select('r.id_receipt, r.idbusiness, r.idoutlet, r.notes,o.name_outlet, o.province_id, o.regencies_id, o.alamat_outlet, o.zip_outlet, o.telp_outlet');
		$this->db->from('receipt r');
		$this->db->join('outlet o', 'r.idoutlet = o.idoutlet');
		$this->db->where('r.idbusiness', $this->idbusiness);
		$this->db->where('r.idoutlet', $outlet_id);
		$receipt = $this->db->get()->result();

		echo json_encode(['data' => $receipt]);
	}

	public function Update_receipt()
	{
		$res = array();
		$idreceipt = $this->input->post("idreceipt");
		$idoutlet = $this->input->post("idoutlet");
		$idregencies = $this->input->post("idregencies");
		$idprovince = $this->input->post("idprovince");
		$zip =  $this->input->post("zip");
		$telp = $this->input->post("telp");
		$alamat = $this->input->post("alamat");
		$note = $this->input->post("note");
		$facebook = $this->input->post("facebook");
		$instagram = $this->input->post("instagram");
		$website = $this->input->post("website");
		$twitter = $this->input->post("twitter");




		$this->db->set('notes', $note);
		$this->db->where('id_receipt', $idreceipt);
		$this->db->where('idbusiness', $this->idbusiness);

		if ($this->db->update('receipt')) {

			$data_outlet = array(
				'province_id' => $idprovince,
				'regencies_id' => $idregencies,
				'alamat_outlet' => $alamat,
				'zip_outlet' => $zip,
				'telp_outlet' => $telp
			);
			$this->db->where('idoutlet', $idoutlet);
			$this->db->where('idbusiness', $this->idbusiness);
			$this->db->update('outlet', $data_outlet);

			$data_business = array(
				'website_business' => $website,
				'facebook_business' => $facebook,
				'instagram_business' => $instagram,
				'twitter_business' => $twitter,
			);
			$this->db->where('idbusiness', $this->idbusiness);
			$this->db->update('business', $data_business);

			$res = array(
				'status' => true, 'message' => 'Data Berhasil Disimpan'
			);
			header('Content-Type: application/json');
			echo json_encode($res);

			// if ($this->db->update('outlet', $data_outlet)) {
			// } else {
			// 	$res = array(
			// 		'status' => false, 'message' => 'Data Gagal Disimpan'
			// 	);
			// 	header('Content-Type: application/json');
			// 	echo json_encode($res);
			// }

		} else {
			$res = array(
				'status' => false, 'message' => 'Data Gagal Disimpan'
			);
			header('Content-Type: application/json');
			echo json_encode($res);
		}
	}

	public function generate()
	{
		$data = array(
			'idbusiness' => $this->idbusiness,
			'idoutlet' => $this->input->post('idoutlet'),
			'notes' => 'Terimakasih atas kunjungannya'
		);

		if ($this->db->insert('receipt', $data)) {
			redirect('backoffice/receipt', 'refresh');
		};
	}

	public function regencies($provinsi)
	{
		$kab = $this->db->get_where('tb_regencies', ['province_id' => $provinsi])->result_array();
		$arr = array();
		foreach ($kab as $k) {
			$d = array(
				'id' => $k['id'],
				'name' => $k['name'],
			);
			array_push($arr, $d);
		}
		header('Content-Type: application/json');
		echo json_encode($arr);
	}
}
