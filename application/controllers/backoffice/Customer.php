<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller
{

	private $number_column = 0;
	private $idbusiness;

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
		$this->load->helper('haris_helper');
		$this->idbusiness = $this->session->userdata('id_business');
	}

	/*
	public function index()
	{
		if(!empty($_POST))
		{
			$provinsi=$this->input->post('provinsi');
			$kabupaten=$this->input->post('kabupaten');
			$kota=$this->input->post('kecamatan');
			$juml=$this->input->post('jumlah_data');
			$outlet=$this->input->post('outlet');
			$id_bus=$this->session->userdata('id_business');

			if (isset($_POST['filter']))
			{
				$data['judul']='Customer';
				$data['isi']='Manajemen Data Customer';
				$wh=array('idbusiness'=>$this->session->userdata('id_business'),'status_outlet'=>1);
				$data['comout']=$this->data_model->getsomething('outlet',$wh);
				$data['comprov']=$this->data_model->get_all('tb_provinces');
				$data['jum_tot']=$this->data_model->count_total('customer');

				$data['customer']=$this->db->query("SELECT * FROM customer WHERE (idoutlet='$outlet' OR '$outlet' = '') AND (province_id='$provinsi' OR '$provinsi' = '') AND (regencies_id='$kabupaten' OR '$kabupaten' = '') AND (district_id='$kota' OR '$kota' = '') AND idbusiness = '$id_bus' LIMIT $juml")->result();

				$tmp['content']=$this->load->view('backoffice/customer/customer',$data,true);
				$this->load->view('backoffice/template',$tmp);
			}
			else
			{
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				$excel = new PHPExcel();

				$excel->getProperties()->setCreator('AIO Pos')
				->setLastModifiedBy('AIO Pos')
				->setTitle("Data Customer")
				->setSubject("Customer")
				->setDescription("Laporan Data Customer")
				->setKeywords("Data Customer");

				$style_col = array(
					'font' => array('bold' => true),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
					'borders' => array(
						'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)));

				$style_row = array(
					'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
					'borders' => array(
						'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)));

				$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA CUSTOMER");
				$excel->getActiveSheet()->mergeCells('A1:I1');
				$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
				$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
				$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Customer");
				$excel->setActiveSheetIndex(0)->setCellValue('C3', "Email");
				$excel->setActiveSheetIndex(0)->setCellValue('D3', "No Telp");
				$excel->setActiveSheetIndex(0)->setCellValue('E3', "No Telp2");
				$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");
				$excel->setActiveSheetIndex(0)->setCellValue('G3', "Provinsi");
				$excel->setActiveSheetIndex(0)->setCellValue('H3', "Kabupaten");
				$excel->setActiveSheetIndex(0)->setCellValue('I3', "Kecamatan");

				$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);

				$register=$this->db->query("SELECT * FROM customer WHERE (idoutlet='$outlet' OR '$outlet' = '') AND (province_id='$provinsi' OR '$provinsi' = '') AND (regencies_id='$kabupaten' OR '$kabupaten' = '') AND (district_id='$kota' OR '$kota' = '') AND idbusiness = '$id_bus' LIMIT $juml")->result();

				$no = 1;
				$numrow = 4;
				foreach($register as $data):

					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
					$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_pelanggan);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->email_pelanggan);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->telp_pelanggan);
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->telepon_pelanggan2);

					$query = $this->db->query("SELECT name_outlet FROM outlet where idoutlet='$data->idoutlet'");
					foreach ($query->result_array() as $rw) $nama_out=$rw['name_outlet'];

					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $nama_out);

					$query = $this->db->query("SELECT name FROM tb_provinces where id='$data->province_id'");
					foreach ($query->result_array() as $rw) $nama_prov=$rw['name'];

					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $nama_prov);

					$query = $this->db->query("SELECT name FROM tb_regencies where id='$data->regencies_id'");
					foreach ($query->result_array() as $rw) $nama_kab=$rw['name'];

					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $nama_kab);

					$query = $this->db->query("SELECT name FROM tb_districts where id='$data->district_id'");
					foreach ($query->result_array() as $rw) $nama_kot=$rw['name'];

					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $nama_kot);

					$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);

					$no++;
					$numrow++;
				endforeach;

				foreach(range('A','I') as $columnID):
					$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
				endforeach;

				$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

				$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

				$excel->getActiveSheet(0)->setTitle("Laporan Data Customer");
				$excel->setActiveSheetIndex(0);

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment; filename="Laporan Data Customer.xlsx"');
				header('Cache-Control: max-age=0');

				$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
				$write->save('php://output');
			}
		}
		else
		{
			$data['judul']='Customer';
			$data['isi']='Manajemen Data Customer';
			$daa=array('idbusiness'=>$this->session->userdata('id_business'),'status_pelanggan'=>1);
			$wh=array('idbusiness'=>$this->session->userdata('id_business'),'status_outlet'=>1);
			$data['comout']=$this->data_model->getsomething('outlet',$wh);
			$data['comprov']=$this->data_model->get_all('tb_provinces');
			$data['jum_tot']=$this->data_model->count_where('customer',$daa);
			$data['customer']=$this->data_model->getsomething('customer',$daa);
			$tmp['content']=$this->load->view('backoffice/customer/customer',$data,true);
			$this->load->view('backoffice/template',$tmp);
		}
	}
	*/
	public function index()
	{
		$data['judul'] = 'Transaksi';
		$data['isi'] = 'View Data Transaksi';

		$res = $this->db->get('tb_provinces')->result_array();
		$opt_outlet = create_dropdown_array($res, 'id', 'name');
		$opt_outlet[''] = "Semua Provinsi";
		$data['opt_provinsi'] = $opt_outlet;

		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$this->db->where('status_outlet', '1');
		$res2 = $this->db->get('outlet')->result_array();
		$data['opt_outlet'] = create_dropdown_array($res2, 'idoutlet', 'name_outlet');
		$data['opt_outlet'][''] = "Semua Outlet";

		$table_header = array(
			'<label><input type="checkbox" name="cb-all" > #</label>',
			'No',
			'Nama Pelanggan',
			'Email',
			'Telp Pelanggan',
			'Nama Outlet',
			'Kabupaten',
			'Provinsi',
			'Action'
		);

		$data['table_header'] = $table_header;

		$tmp['content'] = $this->load->view('backoffice/customer/customer_datatables', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}


	public function export_excel()
	{
		require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		$dataArray = array(
			array(
				'No',
				'Nama Pelanggan',
				'Email Pelanggan',
				'Telp Pelanggan',
				'Nama Outlet',
				'Kabupaten',
				'Provinsi',
			)
		);

		$num = 1;
		$customer = $this->sql();
		foreach ($customer as $row) {
			$buff = array(
				$num,
				$row['nama_pelanggan'],
				$row['email_pelanggan'],
				$row['telp_pelanggan'],
				$row['name_outlet'],
				$row['kabupaten'],
				$row['provinsi']
			);
			array_push($dataArray, $buff);
			$num++;
		}

		$doc = new PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
		$doc->getActiveSheet()->fromArray($dataArray);
		$filename = 'Report.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');

		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
	}

	private function sql()
	{
		$result = array();

		$id_business = $this->session->userdata('id_business');

		$outlet = $this->input->get('outlet');
		$provinsi = $this->input->get('provinsi');
		$kabupaten = $this->input->get('kabupaten');
		$kecamatan = $this->input->get('kecamatan');

		$where = " ";
		if (!empty($outlet)) {
			$where .= "AND customer.idoutlet = '$outlet'";
		}
		if (!empty($provinsi)) {
			$where .= "AND customer.province_id = '$provinsi'";
		}
		if (!empty($kabupaten)) {
			$where .= "AND customer.regencies_id = '$kabupaten'";
		}
		if (!empty($kecamatan)) {
			$where .= "AND customer.district_id = '$kecamatan'";
		}

		$sql = "SELECT 
    	' ' as checkbox,
    	customer.idctm, customer.nama_pelanggan,
    	customer.email_pelanggan, customer.telp_pelanggan,
    	outlet.name_outlet, tb_regencies.name as kabupaten,
    	tb_provinces.name as provinsi,
    	' ' as action
    	FROM customer LEFT JOIN tb_provinces ON tb_provinces.id = customer.province_id
    	LEFT JOIN tb_regencies ON tb_regencies.id = customer.regencies_id
    	LEFT JOIN outlet ON outlet.idoutlet = customer.idoutlet
		WHERE customer.idbusiness = '$id_business' " . $where . " AND customer.status_pelanggan = '1'
		ORDER BY customer.idctm DESC";

		$result = $this->db->query($sql)->result_array();

		return $result;
	}

	private function callback_collumn($key, $col, $row)
	{

		if ($key == 'action') {
			$new = $this->encrypt->encode($row['idctm']);

			$url = base_url() . "backoffice/customer/edit_customer/" . $new;
			$col .= '<a href="' . $url . '" class="btn btn-default btn-xs">Edit</a>';
			$col .= '<a href="#" '
				. ' class="btn btn-danger btn-xs" '
				. ' onclick="delete_validation(' . $row['idctm'] . ')" >Delete</a>';
		}

		if ($key == 'idctm') {
			$this->number_column = $this->number_column + 1;
			$col = $this->number_column;
		}

		if ($key == 'checkbox') {
			$col = '<input type="checkbox" name="customer-cb" class="list-checkbox" value="' . $row['idctm'] . '" >';
		}

		return $col;
	}

	public function datatable()
	{
		$result = $this->sql();

		$datatables_format = array(
			'data' => array(),
		);

		foreach ($result as $row) {
			$buffer = array();

			foreach ($row as $key => $col) {
				$col = $this->callback_collumn($key, $col, $row);
				array_push($buffer, $col);
			}
			array_push($datatables_format['data'], $buffer);
		}
		header('Content-Type: application/json');
		echo json_encode($datatables_format);
	}

	function ambil_data()
	{
		$modul = $this->input->post('modul');
		$id = $this->input->post('id');
		if ($modul == "kabupaten") {
			$kab = $this->db->get_where('tb_regencies', ['province_id' => $id])->result_array();
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

			// echo $this->data_model->kabupaten_filter($id);
		} else if ($modul == "kecamatan") {
			$kec = $this->db->get_where('tb_districts', ['regency_id' => $id])->result_array();
			$arr = array();
			foreach ($kec as $k) {
				$d = array(
					'id' => $k['id'],
					'name' => $k['name'],
				);
				array_push($arr, $d);
			}
			header('Content-Type: application/json');
			echo json_encode($arr);

			// echo $this->data_model->kecamatan_filter($id);
		}
	}

	public function tambah_customer()
	{
		$data['judul'] = 'Customer';
		$data['isi'] = 'Tambah Data Customer';


		$this->db->select('idoutlet, name_outlet');
		$this->db->from('outlet');
		$this->db->where('idbusiness', $this->idbusiness);
		$this->db->where('status_outlet', 1);
		$outlet = $this->db->get()->result();

		$data['outlet'] = $outlet;
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('backoffice/customer/tambah_customer', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function insert_customer()
	{
		$data = array(
			'nama_pelanggan' => $this->input->post('nama_customer'),
			'email_pelanggan' => $this->input->post('email_customer'),
			'telp_pelanggan' => $this->input->post('telp_customer'),
			'province_id' => $this->input->post('provinsi'),
			'regencies_id' => $this->input->post('kabupaten'),
			'district_id' => $this->input->post('kecamatan'),
			'idoutlet' => $this->input->post('outlet'),
			'idbusiness' => $this->idbusiness,
			'status_pelanggan' => 1,
		);
		$this->data_model->Insert_something('customer', $data);
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/customer");
	}

	public function Edit_customer($id = 0)
	{
		$data['judul'] = 'Customer';
		$data['isi'] = 'Edit Data Customer';
		$ai = $this->encrypt->decode($id);
		$wh = array('idctm' => $ai);
		$data['customer'] = $this->data_model->getsomething('customer', $wh);
		$data['comprov'] = $this->data_model->get_all('tb_provinces');
		$tmp['content'] = $this->load->view('backoffice/customer/edit_customer', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_customer()
	{
		$data = array(
			'nama_pelanggan' => $this->input->post('nama_customer'),
			'email_pelanggan' => $this->input->post('email_customer'),
			'telp_pelanggan' => $this->input->post('telp_customer'),
			// 'telepon_pelanggan2' => $this->input->post('telp_customer2'),
			'province_id' => $this->input->post('provinsi'),
			'regencies_id' => $this->input->post('kabupaten'),
			'district_id' => $this->input->post('kecamatan')
		);
		$this->data_model->update_something('customer', $data, $this->input->post('idctm'), 'idctm');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/customer");
	}

	public function Delete()
	{
		$idctm = $this->input->post('idctm');
		$data = array('status_pelanggan' => 0);
		$this->data_model->update_something('customer', $data, $idctm, 'idctm');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/customer");
	}

	public function Delete_batch()
	{
		$json = $this->input->post('id_customer');
		$id_customer = array();

		if (strlen($json) > 0) {
			$id_customer = json_decode($json);
		}

		if (count($id_customer) > 0) {
			$id_customer_str = "";
			$id_customer_str = implode(',', $id_customer);

			$sql = "UPDATE customer SET customer.status_pelanggan=0 where customer.idctm in (" . $id_customer_str . ") ";
			$this->db->query($sql);

			$this->session->set_flashdata('message', "modal-success");
			redirect("backoffice/customer");
		}
	}

	// public function cekEmailExist($action, $id = null)
	// {
	// 	$usr = $this->input->post('username');
	// 	if ($action == 'tambah_customer') {

	// 		$whr = array(
	// 			'username' => $usr,
	// 			'idbusiness' => $this->session->userdata('id_business'),
	// 		);
	// 		$is_exist = $this->db->get_where('user', $whr);
	// 		if ($is_exist->num_rows() > 0) {
	// 			echo 'false';
	// 		} else {
	// 			echo 'true';
	// 		}
	// 	} else {
	// 		$this->db->where_not_in('iduser', $id);
	// 		$this->db->where('username', $usr);
	// 		$this->db->where('idbusiness', $this->session->userdata('id_business'));
	// 		$is_exist = $this->db->get('user');
	// 		if ($is_exist->num_rows() > 0) {
	// 			echo 'false';
	// 		} else {
	// 			echo 'true';
	// 		}
	// 	}
	// }
}
