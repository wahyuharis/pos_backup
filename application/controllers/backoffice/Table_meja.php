<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Table_meja extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	private function sql()
	{
		$sql = "
			SELECT a.idtable, a.no_meja,a.status, b.name_outlet, c.nama_group
			FROM table_management a
			LEFT JOIN outlet b ON b.idoutlet = a.idoutlet
			LEFT JOIN table_group c ON c.idgroup = a.idgroupmeja
			WHERE a.status_meja=1 AND a.idbusiness=" . $this->session->userdata('id_business') . "
			ORDER BY a.idtable desc 
		";

		return $this->db->query($sql)->result();
	}

	public function index()
	{
		$data['judul'] = 'Meja';
		$data['isi'] = 'Kelola Meja';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_meja' => 1);

		$data['jum_meja'] = $this->data_model->count_where('table_management', $daa);
		$data['meja'] = $this->sql();
		$tmp['content'] = $this->load->view('backoffice/table_meja/meja', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Tambah_meja()
	{
		$data['judul'] = 'Meja';
		$data['isi'] = 'Tambah Meja';

		$daaOutlet = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$daaGroup = array('idbusiness' => $this->session->userdata('id_business'), 'status_group' => 1);
		$data['outlet'] = $this->data_model->getsomething('outlet', $daaOutlet);
		$data['group'] = $this->data_model->getsomething('table_group', $daaGroup);
		$tmp['content'] = $this->load->view('backoffice/table_meja/tambah_meja', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_meja()
	{
		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'no_meja' => $this->input->post('no_meja'),
			'idgroupmeja' => $this->input->post('idgroup'),
			'idoutlet' => $this->input->post('idoutlet'),
		);
		$this->data_model->insert_something('table_management', $data);
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/table_meja");
	}

	public function Edit_meja($id = 0)
	{
		$data['judul'] = 'Meja';
		$data['isi'] = 'Edit Meja';
		$daa = array('idtable' => $id);
		$daaOutlet = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$daaGroup = array('idbusiness' => $this->session->userdata('id_business'), 'status_group' => 1);
		$data['outlet'] = $this->data_model->getsomething('outlet', $daaOutlet);
		$data['group'] = $this->data_model->getsomething('table_group', $daaGroup);
		$data['meja'] = $this->data_model->getsomething('table_management', $daa);
		$tmp['content'] = $this->load->view('backoffice/table_meja/edit_meja', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_meja()
	{
		$id = $this->input->post('idtable');

		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'no_meja' => $this->input->post('no_meja'),
			'idgroupmeja' => $this->input->post('idgroup'),
			'idoutlet' => $this->input->post('idoutlet'),
		);
		$this->data_model->update_something('table_management', $data, $id, 'idtable');

		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/table_meja");
	}


	public function Delete()
	{
		$id = $this->input->post('idtable');
		$data = array('status_meja' => 0);
		// $data2=array('idgroup'=>0);
		$this->data_model->update_something('table_management', $data, $id, 'idtable');
		// $this->data_model->update_something('produk',$data2,$id_kategori,'idkategori');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/table_meja");
	}

	public function cekTableExist()
	{
		$no_meja = $this->input->post("no_meja");
		$idgroup = $this->input->post("idgroup");
		$idoutlet = $this->input->post("idoutlet");

		$this->db->select('no_meja');
		$this->db->from('table_management');
		$this->db->where('no_meja', $no_meja);
		$this->db->where('idgroupmeja', $idgroup);
		$this->db->where('idoutlet', $idoutlet);
		$this->db->where('status_meja', 1);
		$exist = $this->db->get();

		if ($exist->num_rows() > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}

	public function Export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
			->setLastModifiedBy('Ultrapos')
			->setTitle("Data Meja")
			->setSubject("Meja")
			->setDescription("Laporan Meja")
			->setKeywords("Data Meja");

		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$style_row = array(
			'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MEJA");
		$excel->getActiveSheet()->mergeCells('A1:D1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Group");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Meja");
		//$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);


		$register = $this->sql();

		$no = 1;
		$numrow = 4;
		foreach ($register as $data) :

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->name_outlet);
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_group);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->no_meja);

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

		$excel->getActiveSheet(0)->setTitle("Laporan Data Meja");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Meja.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		$write->save('php://output');
	}
}
