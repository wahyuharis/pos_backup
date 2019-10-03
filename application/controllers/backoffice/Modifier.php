<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Modifier extends CI_Controller
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

		$data['judul'] = 'Modifier';
		$data['isi'] = 'Kelola Modifier';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_modifier' => 1);
		$data['jum_mod'] = $this->data_model->count_where('modifier', $daa);

		$this->db->order_by('idmodifier', 'desc');
		$modifier = $this->db->get_where('modifier', $daa)->result();

		$data['modifier'] = $modifier;
		$tmp['content'] = $this->load->view('backoffice/modifier/modifier', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Tambah_modifier()
	{
		$data['judul'] = 'Modifier';
		$data['isi'] = 'Tambah Data Modifier';
		$ar = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => '1');
		$data['compro'] = $this->data_model->getsomething('produk', $ar);
		$tmp['content'] = $this->load->view('backoffice/modifier/tambah_modifier', $data, true);
		$tmp['js_files'] = array(
			'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
		);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_modifier()
	{
		// $sub_modifier = json_decode($this->input->post('sub_modifier'), true);
		// $i = 0;
		// foreach ($sub_modifier as $val) {
		// 	$vari[$i]['nama_sub'] = $val['sub_name'];
		// 	$vari[$i]['harga_sub'] = $val['sub_price'];
		// 	$vari[$i]['idmodifier'] = 1;
		// 	$i++;
		// }
		// print_r($vari);
		// die();


		$this->load->helper('haris_helper');
		$data = array(
			'idbusiness' => $this->idbusiness,
			'nama_modifier' => $this->input->post('nama_modifier'),
			// 'harga' => floatval2($this->input->post('harga_modifier')),
			'status_modifier' => 1
		);
		$this->data_model->insert_something('modifier', $data);
		$idmod = $this->db->insert_id();

		// sub modifier
		// $sub_name = $this->input->post("sub_name");
		// $sub_price = $this->input->post("sub_price");

		// $data_sub = array();
		// foreach ($sub_name as $key => $sub) {
		// 	if (!empty($sub) && $sub_price[$key] != 0) {

		// 		$d = array(
		// 			'idmodifier' => $idmod,
		// 			'nama_sub' => $sub,
		// 			'harga_sub' => floatval2($sub_price[$key]),
		// 		);
		// 		array_push($data_sub, $d);
		// 	}
		// }
		// $this->db->insert_batch('sub_modifier', $data_sub);
		$sub_modifier = json_decode($this->input->post('sub_modifier'), true);
		$ii = 0;
		foreach ($sub_modifier as $val) {
			$var[$ii]['nama_sub'] = $val['sub_name'];
			$var[$ii]['harga_sub'] = floatval2($val['sub_price']);
			$var[$ii]['idmodifier'] = $idmod;
			$ii++;
		}
		$this->db->insert_batch('sub_modifier', $var);


		// $produk = $this->input->post('produk');

		// $arr_mod = array();
		// foreach ($produk as $prod) {
		// 	$d = array(
		// 		'idproduk' => $prod,
		// 		'idmodifier' => $idmod
		// 	);

		// 	array_push($arr_mod, $d);
		// }
		// $this->db->insert_batch('rel_modifier', $arr_mod);

		// produk
		$json = $this->input->post('id_produks');
		$id_produks = array();

		if (strlen($json) > 0) {
			$id_produks = json_decode($json);
			$i = 0;
			foreach ($id_produks as $val) {
				$vari[$i]['idproduk'] = $val;
				$vari[$i]['idmodifier'] = $idmod;
				$i++;
			}
			$this->db->insert_batch('rel_modifier', $vari);
		}


		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/modifier");
	}

	public function Edit_modifier($id = 0)
	{
		$data['judul'] = 'Modifier';
		$data['isi'] = 'Edit Data Modifier';
		$id = base64_decode(urldecode($id));
		$daa = array('idmodifier' => $id);
		$data['modifier'] = $this->data_model->getsomething('modifier', $daa);
		$data['submodifier'] = $this->data_model->getsomething('sub_modifier', $daa);
		$ar = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => '1');
		$data['compro'] = $this->data_model->getsomething('produk', $ar);

		$tmp['js_files'] = array(
			'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
		);

		$tmp['content'] = $this->load->view('backoffice/modifier/edit_modifier', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_modifier()
	{
		$id_modifier = $this->input->post('idmodifier');


		$data = array(
			'idbusiness' => $this->idbusiness,
			'nama_modifier' => $this->input->post('nama_modifier'),
			'status_modifier' => 1
		);
		$this->data_model->update_something('modifier', $data, $id_modifier, 'idmodifier');

		$del = array('idmodifier' => $id_modifier);
		$this->data_model->delete_something('rel_modifier', $del);
		$this->data_model->delete_something('sub_modifier', $del);

		// sub modifier
		// $sub_name = $this->input->post("sub_name");
		// $sub_price = $this->input->post("sub_price");
		// $data_sub = array();
		// foreach ($sub_name as $key => $sub) {
		// 	if (!empty($sub) && $sub_price[$key] != 0) {
		// 		$d = array(
		// 			'idmodifier' => $id_modifier,
		// 			'nama_sub' => $sub,
		// 			'harga_sub' => floatval2($sub_price[$key]),
		// 		);

		// 		array_push($data_sub, $d);
		// 	}
		// }
		// $this->db->insert_batch('sub_modifier', $data_sub);
		$sub_modifier = json_decode($this->input->post('sub_modifier'), true);
		$ii = 0;
		foreach ($sub_modifier as $val) {
			$var[$ii]['nama_sub'] = $val['sub_name'];
			$var[$ii]['harga_sub'] = floatval2($val['sub_price']);
			$var[$ii]['idmodifier'] = $id_modifier;
			$ii++;
		}
		$this->db->insert_batch('sub_modifier', $var);

		$json = $this->input->post('id_produks');
		$id_produks = array();

		if (strlen($json) > 0) {
			$id_produks = json_decode($json);
			$i = 0;
			foreach ($id_produks as $key => $val) {
				$vari[$i]['idproduk'] = $val;
				$vari[$i]['idmodifier'] = $id_modifier;
				$i++;
			}

			$this->db->insert_batch('rel_modifier', $vari);
		}


		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/modifier");
	}

	public function detail_submodifier($id)
	{
		$sub = $this->db->order_by('idsubmodifier', 'desc')->get_where('sub_modifier', ['idmodifier' => $id])->result();
		$data['data'] = array();
		foreach ($sub as $s) {
			$d = array(
				'id' => $s->idsubmodifier,
				'nama' => $s->nama_sub,
				'harga' => nominal($s->harga_sub),
			);

			array_push($data['data'], $d);
		}

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function Delete()
	{
		$id_modifier = $this->input->post('id_modifier');
		$data = array('status_modifier' => 0);
		$data2 = array('idmodifier' => $id_modifier);
		$this->data_model->delete_something('rel_modifier', $data2);
		$this->data_model->delete_something('sub_modifier', $data2);
		$this->data_model->update_something('modifier', $data, $id_modifier, 'idmodifier');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/modifier");
	}

	// public function Export()
	// {
	// 	include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	// 	$excel = new PHPExcel();

	// 	$excel->getProperties()->setCreator('Ultrapos')
	// 		->setLastModifiedBy('Ultrapos')
	// 		->setTitle("Data Modifier Produk")
	// 		->setSubject("Modifier")
	// 		->setDescription("Laporan Data Modifier")
	// 		->setKeywords("Data Modifier");

	// 	$style_col = array(
	// 		'font' => array('bold' => true),
	// 		'alignment' => array(
	// 			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	// 			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	// 		),
	// 		'borders' => array(
	// 			'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
	// 		)
	// 	);

	// 	$style_row = array(
	// 		'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
	// 		'borders' => array(
	// 			'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
	// 			'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
	// 		)
	// 	);

	// 	$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MODIFIER");
	// 	$excel->getActiveSheet()->mergeCells('A1:C1');
	// 	$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	// 	$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
	// 	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// 	$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
	// 	$excel->setActiveSheetIndex(0)->setCellValue('B3', "Modifier");
	// 	$excel->setActiveSheetIndex(0)->setCellValue('C3', "Harga");
	// 	//$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

	// 	$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
	// 	$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
	// 	$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
	// 	//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

	// 	$www = array('idbusiness' => $this->session->userdata('id_business'), 'status_modifier' => 1);
	// 	$register = $this->data_model->getsomething('modifier', $www);

	// 	$no = 1;
	// 	$numrow = 4;
	// 	foreach ($register as $data) :

	// 		$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
	// 		$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_modifier);
	// 		$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, 'Rp.' . $data->harga);

	// 		$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
	// 		$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
	// 		$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);

	// 		$no++;
	// 		$numrow++;
	// 	endforeach;

	// 	foreach (range('A', 'C') as $columnID) :
	// 		$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	// 	endforeach;

	// 	$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

	// 	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	// 	$excel->getActiveSheet(0)->setTitle("Laporan Data Modifier");
	// 	$excel->setActiveSheetIndex(0);

	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 	header('Content-Disposition: attachment; filename="Laporan Data Modifier.xlsx"');
	// 	header('Cache-Control: max-age=0');

	// 	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	// 	ob_end_clean();
	// 	$write->save('php://output');
	// }

	public function Export2()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
			->setLastModifiedBy('Ultrapos')
			->setTitle("Data Modifier")
			->setSubject("Modifier")
			->setDescription("Laporan Data Modifier")
			->setKeywords("Data Modifier");

		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$style_row = array(
			'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
			'borders' => array(
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MODIFIER");
		$excel->getActiveSheet()->mergeCells('A1:E1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$excel->getActiveSheet()->mergeCells('A3:A4');
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Modifier");
		$excel->getActiveSheet()->mergeCells('B3:B4');
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Items");
		$excel->getActiveSheet()->mergeCells('C3:D3');
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "Nama");
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "harga");

		$excel->setActiveSheetIndex(0)->setCellValue('E3', "Qty Produk");
		$excel->getActiveSheet()->mergeCells('E3:E4');

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3:D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_modifier' => 1);
		$this->db->order_by('idmodifier', 'desc');
		$modifier = $this->db->get_where('modifier', $daa)->result();

		$no = 1;
		$numrow = 5;
		foreach ($modifier as $data) :
			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_modifier);

			$ta = array('idmodifier' => $data->idmodifier);
			$sub_mod = $this->data_model->getsomething('sub_modifier', $ta);
			$tot = $this->data_model->count_where('rel_modifier', $ta);

			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $tot > 0 ? $tot . ' Produk' : '-');

			$int = 5;
			// $numrowsss = 5;
			foreach ($sub_mod as $sm) {

				$excel->getActiveSheet()->mergeCells('A5:A' . $int);
				$excel->getActiveSheet()->mergeCells('B5:B' . $int);

				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $sm->nama_sub);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $sm->harga_sub);


				$excel->getActiveSheet()->mergeCells('E5:E' . $int);


				$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

				$int++;
				$numrow++;
			}

			$no++;
			$numrow++;
		endforeach;

		foreach (range('A', 'E') as $columnID) :
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Modifier");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Modifier.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		$write->save('php://output');
	}
}
