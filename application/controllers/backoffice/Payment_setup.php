<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_setup extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul'] = 'Payment Setup';
		$data['isi'] = 'Manajemen Metode Pembayaran';
		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_pay' => 1);
		$data['payment'] = $this->data_model->getsomething('payment_setup', $daa);
		$data['jum_tot'] = $this->data_model->count_where('payment_setup', $daa);
		$tmp['content'] = $this->load->view('backoffice/payment/payment', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Tambah_payment()
	{
		$data['judul'] = 'Payment';
		$data['isi'] = 'Tambah Metode Pembayaran';
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$tmp['content'] = $this->load->view('backoffice/payment/tambah_payment', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_payment()
	{
		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'nama_pay' => $this->input->post('nama_payment'),
			'norek_pay' => $this->input->post('norek'),
			'holdername_pay' => $this->input->post('holder'),
			'idoutlet' => $this->input->post('outlet'),
			'status_pay' => 1
		);
		$this->data_model->insert_something('payment_setup', $data);
		$this->session->set_flashdata('pesan', "Payment Berhasil Disimpan");
		redirect("backoffice/payment_setup");
	}

	public function Edit_payment($id = 0)
	{
		$data['judul'] = 'Payment';
		$data['isi'] = 'Edit Data Payment';
		$ai = $this->my_encrypt->decode($id);
		$daa = array('idpay' => $ai);
		$data['payment'] = $this->data_model->getsomething('payment_setup', $daa);
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$tmp['content'] = $this->load->view('backoffice/payment/edit_payment', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_payment()
	{
		$id_pay = $this->input->post('id_pay');

		$data = array(
			'idbusiness' => $this->input->post('id_business'),
			'nama_pay' => $this->input->post('nama_payment'),
			'norek_pay' => $this->input->post('norek'),
			'holdername_pay' => $this->input->post('holder'),
			'idoutlet' => $this->input->post('outlet'),
			'status_pay' => 1
		);
		$this->data_model->update_something('payment_setup', $data, $id_pay, 'idpay');
		$this->session->set_flashdata('pesan', "Payment Berhasil Diubah");
		redirect("backoffice/payment_setup");
	}

	public function isactive($id, $is)
	{
		$data = array();
		if ($is == 1) {
			$data['is_active'] = 0;
			$this->data_model->update_something('payment_setup', $data, $id, 'idpay');
			$this->session->set_flashdata('pesan', "Payment Berhasil DiNon-aktifkan");
		} else {
			$data['is_active'] = 1;
			$this->data_model->update_something('payment_setup', $data, $id, 'idpay');
			$this->session->set_flashdata('pesan', "Payment Berhasil Diaktifkan");
		}

		redirect("backoffice/payment_setup");
	}

	public function Delete()
	{
		$id_pay = $this->input->post('id_pay');
		$data = array('status_pay' => 0);
		$this->data_model->update_something('payment_setup', $data, $id_pay, 'idpay');
		$this->session->set_flashdata('pesan', "Payment Berhasil Dihapus");
		redirect("backoffice/payment_setup");
	}

	public function Export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
			->setLastModifiedBy('Ultrapos')
			->setTitle("Data Payment Setup")
			->setSubject("Payment Setup")
			->setDescription("Laporan Data Payment Setup")
			->setKeywords("Data Payment Setup");

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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PAYMENT SETUP");
		$excel->getActiveSheet()->mergeCells('A1:E1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Pay");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Outlet");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Nomor Rekening");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "Holder");
		//$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		$www = array('idbusiness' => $this->session->userdata('id_business'), 'status_pay' => 1);
		$register = $this->data_model->getsomething('payment_setup', $www);

		$no = 1;
		$numrow = 4;
		foreach ($register as $data) :

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_pay);

			$query = $this->db->query("SELECT name_outlet FROM outlet where idoutlet='$data->idoutlet'");
			foreach ($query->result_array() as $rw) $nama_out = $rw['name_outlet'];

			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $nama_out);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->norek_pay);
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->holdername_pay);

			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		endforeach;

		foreach (range('A', 'E') as $columnID) :
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Payment Setup");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Payment Setup.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
