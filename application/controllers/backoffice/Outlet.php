<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Outlet extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul'] = 'Outlet';
		$data['isi'] = 'Kelola Outlet';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['jum_out'] = $this->data_model->count_where('outlet', $daa);
		$data['outlet'] = $this->data_model->getsomething('outlet', $daa);
		$tmp['content'] = $this->load->view('backoffice/outlet/outlet', $data, true);
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

	public function Tambah_outlet()
	{
		$data['judul'] = 'Outlet';
		$data['isi'] = 'Tambah Data Outlet';
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('backoffice/outlet/tambah_outlet', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_outlet()
	{
		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'province_id' => $this->input->post('provinsi'),
			'regencies_id' => $this->input->post('kabupaten'),
			'district_id' => $this->input->post('kecamatan'),
			'name_outlet' => $this->input->post('nama_outlet'),
			'alamat_outlet' => $this->input->post('alamat'),
			'zip_outlet' => $this->input->post('zip'),
			'telp_outlet' => $this->input->post('telp'),
			'settax_outlet' => $this->input->post('tax'),
			'status_outlet' => 1
		);

		$this->data_model->insert_something('outlet', $data);
		$id_outlet = $this->db->insert_id();


		$data_sales_type = array(
			'idbusiness' => $this->session->userdata("id_business"),
			'idoutlet' => $id_outlet,
			'nama_saltype' => "Dine In",
			'lock' => 1,
			'status_saltype' => 1,
		);

		$this->data_model->insert_something('sales_type', $data_sales_type);

		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/outlet");
	}

	public function Edit_outlet($id = 0)
	{
		$data['judul'] = 'Outlet';
		$data['isi'] = 'Edit Data Outlet';
		$ai = $this->my_encrypt->decode($id);
		$daa = array('idoutlet' => $id);
		$data['outlet'] = $this->data_model->getsomething('outlet', $daa);
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('backoffice/outlet/edit_outlet', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_outlet()
	{

		$id_outlet = $this->input->post('id_outlet');
		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'province_id' => $this->input->post('provinsi'),
			'regencies_id' => $this->input->post('kabupaten'),
			'district_id' => $this->input->post('kecamatan'),
			'name_outlet' => $this->input->post('nama_outlet'),
			'alamat_outlet' => $this->input->post('alamat'),
			'zip_outlet' => $this->input->post('zip'),
			'telp_outlet' => $this->input->post('telp'),
			'settax_outlet' => $this->input->post('tax'),
			'status_outlet' => 1
		);
		$this->data_model->update_something('outlet', $data, $id_outlet, 'idoutlet');

		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/outlet");
	}

	public function Delete()
	{
		$id_outlet = $this->input->post('id_outlet');
		$data = array('status_outlet' => 0);
		$data_sales_type = array('lock' => 0, 'status_saltype' => 0);
		$this->data_model->update_something('outlet', $data, $id_outlet, 'idoutlet');
		$this->data_model->update_something('sales_type', $data_sales_type, $id_outlet, 'idoutlet');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/outlet");
	}

	public function Export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('AIO Pos')
			->setLastModifiedBy('AIO Pos')
			->setTitle("Data Outlet")
			->setSubject("Outlet")
			->setDescription("Laporan Data Outlet")
			->setKeywords("Data Outlet");

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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA OUTLET");
		$excel->getActiveSheet()->mergeCells('A1:H1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Provinsi");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Kabupaten");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "Kecamatan/Kota");
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "Alamat Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "Zip Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "Telp Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);

		$www = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$register = $this->data_model->getsomething('outlet', $www);

		$no = 1;
		$numrow = 4;
		foreach ($register as $data) :

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->name_outlet);

			$query = $this->db->query("SELECT name FROM tb_provinces where id='$data->province_id'");
			foreach ($query->result_array() as $rw)
				$nama_prov = $rw['name'];

			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $nama_prov);

			$query = $this->db->query("SELECT name FROM tb_regencies where id='$data->regencies_id'");
			foreach ($query->result_array() as $rw)
				$nama_kab = $rw['name'];

			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $nama_kab);

			$query = $this->db->query("SELECT name FROM tb_districts where id='$data->district_id'");
			foreach ($query->result_array() as $rw)
				$nama_kot = $rw['name'];

			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $nama_kot);
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->alamat_outlet);
			$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->zip_outlet);
			$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->telp_outlet);

			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		endforeach;

		foreach (range('A', 'H') as $columnID) :
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Outlet");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Outlet.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		$write->save('php://output');
	}
}
