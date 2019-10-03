<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Sales_type extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul'] = 'Sales Type';
		$data['isi'] = 'Manajemen Data Sales Type';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_saltype' => 1);
		$data['sales_type'] = $this->data_model->getsomething('sales_type', $daa);
		$data['jum_sty'] = $this->data_model->count_where('sales_type', $daa);
		$tmp['content'] = $this->load->view('backoffice/sales_type/sales_type', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Tambah_sales_type()
	{
		$data['judul'] = 'Sales Type';
		$data['isi'] = 'Manajemen Data Sales Type';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_gratuity' => 1);
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$data['tip'] = $this->data_model->getsomething('gratuity', $daa);
		$tmp['content'] = $this->load->view('backoffice/sales_type/tambah_sales_type', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_sales_type()
	{
		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'nama_saltype' => $this->input->post('nama_sales_type'),
			'idoutlet' => $this->input->post('outlet'),
			'status_saltype' => 1
		);
		$this->data_model->insert_something('sales_type', $data);
		$id_st = $this->db->insert_id();

		$tip = $this->input->post('tip');
		foreach ($tip as $color) {
			$dat = array('idsaltype' => $id_st, 'idgratuity' => $color, 'status' => 1);
			$this->data_model->insert_something('rel_salestype', $dat);
		}
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/sales_type");
	}

	public function Edit_sales_type($id = 0)
	{
		$data['judul'] = 'Sales Type';
		$data['isi'] = 'Manajemen Data Sales Type';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_gratuity' => 1);
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);

		$ai = base64_decode(urldecode(($id)));

		$wh2 = array('idsaltype' => $ai);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$data['tip'] = $this->data_model->getsomething('gratuity', $daa);
		$data['saltype'] = $this->data_model->getsomething('sales_type', $wh2);
		$tmp['content'] = $this->load->view('backoffice/sales_type/edit_sales_type', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_sales_type()
	{
		$id_saltype = $this->input->post('idsaltype');

		$Hapus1 = array('idsaltype' => $id_saltype);
		$this->data_model->delete_something('rel_salestype', $Hapus1);

		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'nama_saltype' => $this->input->post('nama_sales_type'),
			'idoutlet' => $this->input->post('outlet'),
			'status_saltype' => 1
		);
		$this->data_model->update_something('sales_type', $data, $id_saltype, 'idsaltype');

		$tip = $this->input->post('tip');
		foreach ($tip as $color) {
			$dat = array('idsaltype' => $id_saltype, 'idgratuity' => $color, 'status' => 1);
			$this->data_model->insert_something('rel_salestype', $dat);
		}
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/sales_type");
	}

	public function Delete()
	{
		$id_saltype = $this->input->post('id_saltype');
		$data = array('status_saltype' => 0);
		$data2 = array('status' => 0);
		$this->data_model->update_something('sales_type', $data, $id_saltype, 'idsaltype');
		$this->data_model->update_something('rel_salestype', $data2, $id_saltype, 'idsaltype');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/sales_type");
	}

	public function Export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
			->setLastModifiedBy('Ultrapos')
			->setTitle("Data Sales Type")
			->setSubject("Sales Type")
			->setDescription("Laporan Data Sales Type")
			->setKeywords("Data Sales Type");

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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SALES TYPE");
		$excel->getActiveSheet()->mergeCells('A1:D1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Sales Type");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Gratuity");
		//$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		$www = array('idbusiness' => $this->session->userdata('id_business'), 'status_saltype' => 1);
		$register = $this->data_model->getsomething('sales_type', $www);

		$no = 1;
		$numrow = 4;
		foreach ($register as $data) :

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_saltype);

			$query = $this->db->query("SELECT name_outlet FROM outlet where idoutlet='$data->idoutlet'");
			foreach ($query->result_array() as $rw)
				$nama_out = $rw['name_outlet'];

			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $nama_out);

			$daa = array('idsaltype' => $data->idsaltype);
			$tot_sal = $this->data_model->count_where('rel_salestype', $daa);

			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $tot_sal . ' Gratuity');

			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		endforeach;

		foreach (range('A', 'D') as $columnID) :
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Sales Type");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Sales Type.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
