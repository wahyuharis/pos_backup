<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Cashopname extends CI_Controller
{

	private $numbering_row = 0;
	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function sql()
	{
		$sql = "select 
            cashopname.idcop,
            outlet.name_outlet,
            `user`.nama_user,
            cashopname.tanggalcop,
            cashopname.beginning,
				cashopname.ending,
				cashopname.jam_mulai,
				cashopname.jam_akhir,
            '' as `action`
            from cashopname
            join outlet on outlet.idoutlet=cashopname.idoutlet
            join `user` on `user`.iduser=cashopname.iduser 
            where 1 ";

		$sql .= " and cashopname.idbusiness= " . $this->session->userdata('id_business') . "
                and cashopname.status_cop=1";

		if (!empty($this->input->get('tanggal'))) {
			$tanggal_input = $this->input->get('tanggal');
			$tanggal_buffer = explode("-", $tanggal_input);
			$tanggal_start = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[0]))->format('Y-m-d');
			$tanggal_end = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[1]))->format('Y-m-d');

			$sql .= " and cashopname.tanggalcop "
				. " between '" . $tanggal_start . "' and '" . $tanggal_end . "' ";
		} else {
			$sql .= " and cashopname.tanggalcop "
				. " between '" . date('Y-m-01') . "' and '" . date('Y-m-t') . "' ";
		}

		if (!empty($this->input->get('kasir'))) {
			$sql .= " and  cashopname.iduser = " . $this->input->get('kasir') . " ";
		}

		if (!empty($this->input->get('outlet'))) {
			$sql .= " and  cashopname.idoutlet = " . $this->input->get('outlet') . " ";
		}

		$sql .= "ORDER BY cashopname.tanggalcop DESC";

		$result_array = $this->db->query($sql)->result_array();

		return $result_array;
	}

	public function index()
	{
		$data['judul'] = 'Cashopname';
		$data['isi'] = 'Manajemen Cashopname';

		$this->db->where('status_user', 1);
		$this->db->where('role_user', 3);
		$this->db->where('del', 1);
		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$res = $this->db->get('user')->result_array();

		$this->load->helper('haris_helper');
		$opt_kasir = create_dropdown_array($res, 'iduser', 'nama_user');
		$opt_kasir[''] = "Pilih Kasir";
		$data['opt_kasir'] = $opt_kasir;

		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$this->db->where('status_outlet', 1);

		$res2 = $this->db->get('outlet')->result_array();

		$opt_outlet = create_dropdown_array($res2, 'idoutlet', 'name_outlet');
		$opt_outlet[''] = "Pilih Outlet";
		$data['opt_outlet'] = $opt_outlet;

		$data['cashopname'] = [];

		$data['jum_cop'] = "";
		$tmp['content'] = $this->load->view('backoffice/cashopname/cashopname', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Detail($id = 0)
	{
		$data['judul'] = 'Cashopname';
		$data['isi'] = 'Detail Cashopname';

		$edc = 0;
		$cash = 0;
		$invoice = 0;
		$refund = 0;
		$tot_jual = 0;
		$tot_refund = 0;

		$this->db->select('*');
		$this->db->from('trans_header');
		$this->db->where('idcop', $id);
		$trans_hd = $this->db->get()->result_array();

		foreach ($trans_hd as $rw) {
			if (($rw['idpay'] != 0) && ($rw['idrefund'] == 0)) {
				$edc = $edc + $rw['total_transHD'];
			}
			if (($rw['idpay'] == 0) && ($rw['idrefund'] == 0)) {
				$cash = $cash + $rw['total_transHD'];
			}
			if (($rw['noinv_transHD'] != 0) && ($rw['idrefund'] == 0)) {
				$invoice = $invoice + $rw['total_transHD'];
			}
			$idtransHD = $rw['idtransHD'];

			$this->db->select('*');
			$this->db->from('trans_list');
			$this->db->where('idtransHD', $idtransHD);
			$total = $this->db->get()->result_array();

			if ($rw['idrefund'] != 0) {
				$refund = $refund + $rw['total_transHD'];
				foreach ($total as $ro) {
					$tot_refund = $tot_refund + $ro['qty'];
				}
			} else {
				foreach ($total as $ro) {
					$tot_jual = $tot_jual + $ro['qty'];
				}
			}
		}

		$hasil = $this->db->query("SELECT cashopname.*, outlet.name_outlet, user.nama_user FROM cashopname LEFT JOIN outlet ON cashopname.idoutlet = outlet.idoutlet LEFT JOIN user ON cashopname.iduser = user.iduser WHERE idcop = '$id'")->result_array();
		foreach ($hasil as $row) {
			$data["idcop"] = $row["idcop"];
			$data["outlet"] = $row["name_outlet"];
			$data["karyawan"] = $row["nama_user"];
			$data["tanggalcop"] = $row["tanggalcop"];
			$data["beginning"] = $row["beginning"];
			$data["ending"] = $row["ending"];
			$data["kas_masuk"] = $row["kas_masuk"];
			$data["kas_keluar"] = $row["kas_keluar"];
			$data["ket_masuk"] = $row["keterangan_masuk"];
			$data["ket_keluar"] = $row["keterangan_keluar"];
			$data["jam_mulai"] = $row["jam_mulai"];
			$data["jam_akhir"] = $row["jam_akhir"];
			$data["total_cash"] = $cash;
			$data["total_invoice"] = $invoice;
			$data["total_edc"] = $edc;
			$data["total_refund"] = $refund;
			$data["item_jual"] = $tot_jual;
			$data["item_refund"] = $tot_refund;
		}

		$data['kas_masuk'] = $this->data_model->Getsomething('cashopname_list', [
			'idcop' => $id,
			'status' => 1
		]);
		$data['kas_keluar'] = $this->data_model->Getsomething('cashopname_list', [
			'idcop' => $id,
			'status' => 2
		]);
		$tmp['content'] = $this->load->view('backoffice/cashopname/detail_cashopname', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	private function callback_collumn($key, $col, $row)
	{
		if ($key == 'idcop') {
			$this->numbering_row = $this->numbering_row + 1;
			$col = $this->numbering_row;
		}
		if ($key == 'action') {
			$url = base_url() . 'backoffice/cashopname/detail/' . $row['idcop'];
			$col = '<a href="' . $url . '" class="btn btn-default btn-xs">Lihat Detail</a>';
		}
		if ($key == 'kas_masuk') {
			$col = "Rp " . number_format($col, 2);
		}

		if ($key == 'kas_keluar') {
			$col = "Rp " . number_format($col, 2);
		}

		if ($key == 'tanggalcop') {
			$col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
		}

		return $col;
	}

	public function datatables()
	{
		$result = $this->sql();

		$datatables_format = array(
			'data' => array(),
		);

		// $i = 1;
		foreach ($result as $row) {
			$buffer = array();
			// $row['idcop'] = $i;

			foreach ($row as $key => $col) {
				$col = $this->callback_collumn($key, $col, $row);
				array_push($buffer, $col);
			}
			array_push($datatables_format['data'], $buffer);
			// $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($datatables_format);
	}

	public function export_excel2()
	{
		require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		$dataArray = array(
			array(
				'No',
				'Outlet',
				'Kasir',
				'Tanggal',
				'Begining',
				'Ending',
			)
		);

		$i = 1;
		foreach ($this->sql() as $row) {
			$buff = array(
				$i,
				$row['name_outlet'],
				$row['nama_user'],
				$row['tanggalcop'],
				$row['kas_masuk'],
				$row['kas_keluar'],
			);
			array_push($dataArray, $buff);
			$i++;
		}

		// create php excel object
		$doc = new PHPExcel();
		// set active sheet 
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
		// read data to active sheet
		$doc->getActiveSheet()->fromArray($dataArray);
		//save our workbook as this file name
		$filename = 'Report.xls';
		//mime type
		header('Content-Type: application/vnd.ms-excel');
		//tell browser what's the file name
		header('Content-Disposition: attachment;filename="' . $filename . '"');

		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format

		$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

		//force user to download the Excel file without writing it to server's HD
		ob_end_clean();
		$objWriter->save('php://output');
	}
}
