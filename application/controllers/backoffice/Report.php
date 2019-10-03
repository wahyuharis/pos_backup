<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Report extends CI_Controller
{

	private $column_number = 0;

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul'] = 'Report';
		$data['isi'] = 'Kelola Hasil Bisnis Anda';

		$this->load->helper("haris_helper");

		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$res1 = $this->db->get('kategori')->result_array();
		$form['opt_kategori'] = create_dropdown_array($res1, 'idkategori', 'nama_kategori');
		$form['opt_kategori'][""] = "All Kategori";


		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$res2 = $this->db->get('outlet')->result_array();
		$form['opt_outlet'] = create_dropdown_array($res2, 'idoutlet', 'name_outlet');
		$form['opt_outlet'][''] = "All Outlet";

		$data['form'] = $form;

		$tmp['content'] = $this->load->view('backoffice/report', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function sql()
	{
		$where = " and trans_header.tgl_transHD between '" . date('Y-m-01') . "' and '" . date('Y-m-t') . "' ";

		if (!empty($this->input->get('tanggal'))) {
			$tanggal_input = $this->input->get('tanggal');
			$tanggal_buffer = explode("-", $tanggal_input);
			$tanggal_start = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[0]))->format('Y-m-d');
			$tanggal_end = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[1]))->format('Y-m-d');

			$where = " and "
				. " trans_header.tgl_transHD "
				. " between '" . $this->db->escape_str($tanggal_start) . "' and '" . $this->db->escape_str($tanggal_end) . "' ";
		}

		$idoutlet = $this->input->get('outlet');
		$idkategory = $this->input->get('kategori');
		$nama_produk = $this->input->get('nama_produk');
		$harga_prod = $this->input->get('harga_produk');

		if (!empty($idoutlet)) {
			$where .= " and outlet.idoutlet = '" . $this->db->escape_str($idoutlet) . "' ";
		}
		if (!empty($idkategory)) {
			$where .= " and produk.idkategori = '" . $this->db->escape_str($idkategory) . "' ";
		}
		if (!empty($nama_produk)) {
			$where .= " and produk.nama_produk like '%" . $this->db->escape_str($nama_produk) . "%' ";
		}
		if (!empty($harga_prod)) {
			$where .= " and trans_list.harga_satuan < '" . $this->db->escape_str($harga_prod) . "' ";
		}

		$sql = "select  
            
        trans_list.idproduk,
        produk.nama_produk,
        kategori.nama_kategori,
        sum(trans_list.qty) as total_qty,
        sum( trans_list.`harga_satuan` * trans_list.qty ) as total_jual,
        sum( trans_list.`harga_satuan` * trans_list.qty ) as total_jual_int,
        outlet.name_outlet,
        tax.besaran_tax

        from trans_header
        join trans_list on trans_list.idtransHD=trans_header.idtransHD

        left join produk on produk.idproduk=trans_list.idproduk

        left join kategori on kategori.idkategori = produk.idkategori
        
        left join outlet on outlet.idoutlet = trans_header.idoutlet
        
        left join tax on tax.idtax=trans_header.idtax

        where trans_header.status_transHD = 1
        and trans_header.idbusiness= " . $this->session->userdata('id_business') . "
        
        
        " . $where . "

        group by trans_list.idproduk
        ORDER BY `total_jual_int` DESC";

		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	private function callback_column($key, $col, $row)
	{
		//        if($key=='total_jual_tax'){
		//            $col=$row['total_jual_int']+(($row['total_jual_int']*$row['besaran_tax'])/100);
		//            $col= number_format($col,2);
		//        }

		if ($key == 'idproduk') {
			$this->column_number = $this->column_number + 1;
			$col = $this->column_number;
		}

		if ($key == 'total_jual') {
			$col = "IDR " . number_format($col, 2);
		}

		return $col;
	}

	public function sales_peritem()
	{
		$result = $this->sql();

		$datatables_format = array(
			'data' => array(),
			'total_jual' => 0,
			'total_pendapatan' => 0,
		);

		foreach ($result as $row) {
			$buffer = array();
			foreach ($row as $key => $col) {
				$col = $this->callback_column($key, $col, $row);
				array_push($buffer, $col);
			}
			array_push($datatables_format['data'], $buffer);
			$datatables_format['total_jual'] += $row['total_qty'];
			$datatables_format['total_pendapatan'] += $row['total_jual_int'];
		}
		$datatables_format['total_pendapatan'] = "IDR " . number_format($datatables_format['total_pendapatan'], 2);

		header('Content-Type: application/json');
		echo json_encode($datatables_format);
	}

	public function export_excel2()
	{
		require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		$dataArray = array(
			array(
				'No',
				'Produk',
				'Kategori',
				'Qty Jual',
				'Total Jual',
				'Outlet'
			)
		);

		foreach ($this->sql() as $row) {
			$buff = array(
				$row['idproduk'],
				$row['nama_produk'],
				$row['nama_kategori'],
				$row['total_qty'],
				$row['total_jual_int'],
				$row['name_outlet']
			);
			array_push($dataArray, $buff);
		}

		// create php excel object
		$doc = new PHPExcel();

		// set active sheet 
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

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

		$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel2007');

		//force user to download the Excel file without writing it to server's HD
		ob_end_clean();
		$objWriter->save('php://output');
	}
}
