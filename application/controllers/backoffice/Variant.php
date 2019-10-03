<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variant extends CI_Controller {

	private $number_column = 0;

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	/*
	public function index()
	{
		$data['judul']='Variant';
		$data['isi']='Kelola Variant';
		$daa=array('idbusiness'=>$this->session->userdata('id_business'),'status'=>1);
		$data['jum_var']=$this->data_model->count_where('variant',$daa);
		$data['variant']=$this->data_model->getsomething('variant',$daa);
		$tmp['content']=$this->load->view('backoffice/variant/variant',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}
	*/

	public function index()
	{
		$data['judul'] = 'Variant';
		$data['isi'] = 'Kelola Variant';

		$table_header = array(
			'<label><input type="checkbox" name="cb-all" > #</label>',
			'No',
			'Nama Variant',
			'Produk',
			'Harga',
			'Action');

		$data['table_header'] = $table_header;

		$tmp['content'] = $this->load->view('backoffice/variant/variant_datatables', $data, true);
		$this->load->view('backoffice/template', $tmp);
		
		//$this->datatable();
	}

	private function sql()
	{
		$resut=array();

		$id_business=$this->session->userdata('id_business');

		$sql="SELECT 
		' ' as checkbox,
		variant.idvariant, variant.nama_variant, 
		produk.nama_produk, stok.harga ,' ' as action
		FROM variant LEFT JOIN produk ON variant.idproduk = produk.idproduk 
		LEFT JOIN stok ON variant.idvariant = stok.idvariant 
		WHERE variant.idbusiness = '$id_business' 
		AND stok.idstok = (SELECT MAX(idstok) FROM stok WHERE idvariant = variant.idvariant) 
		AND variant.status = '1'";
		$result = $this->db->query($sql)->result_array();

		return $result;
	}

	private function callback_collumn($key, $col, $row)
	{

		if ($key == 'action')
		{
			$url = base_url() . "backoffice/variant/edit_variant/" . $row['idvariant'];
			$col .= '<a href="' . $url . '" class="btn btn-default btn-xs">Edit</a>';
			$col .= '<a href="#" '
			. ' class="btn btn-danger btn-xs" '
			. ' onclick="delete_validation(' . $row['idvariant'] . ')" >Delete</a>';
		}

		if ($key == 'idvariant')
		{
			$this->number_column = $this->number_column + 1;
			$col = $this->number_column;
		}

		if ($key == 'checkbox')
		{
			$col = '<input type="checkbox" name="variant-cb" class="list-checkbox" value="' . $row['idvariant'] . '" >';
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

	public function Tambah_variant()
	{
		$data['judul']='Variant';
		$data['isi']='Tambah Data Variant';
		$wh=array('idbusiness'=>$this->session->userdata('id_business'),'status_produk'=>1,'variant'=>2);
		$data['comprod']=$this->data_model->getsomething('produk',$wh);
		$tmp['content']=$this->load->view('backoffice/variant/tambah_variant',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Insert_variant()
	{
		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_variant'=>$this->input->post('nama_variant'),
			'idproduk'=>$this->input->post('produk'),
			'status'=>1
		);
		$this->data_model->insert_something('variant',$data);

		$idbis=$this->input->post('id_business');
		$navr=$this->input->post('nama_variant');
		$sel=$this->db->query("SELECT idvariant FROM variant WHERE idbusiness='$idbis' AND nama_variant='$navr'")->result();

		foreach($sel as $rw):
			$id_var=$rw->idvariant;
		endforeach;

		$tanggal = time();
		$waktu = "Y-m-d";
		$sekarang = date($waktu, $tanggal);

		$md=array(
			'idproduk'=>$this->input->post('produk'),
			'idvariant'=>$id_var,
			'awal'=>$this->input->post('stock_awal'),
			'akhir'=>$this->input->post('stock_awal'),
			'harga'=>$this->input->post('harga_variant'),
			'tanggal'=>$sekarang,
			'status'=>1);
		$this->data_model->insert_something('stok',$md);

		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/variant");
	}

	public function Edit_variant($id=0)
	{
		$data['judul']='Variant';
		$data['isi']='Edit Data Variant';
		$daa=array('idvariant'=>$id);
		$wh=array('idbusiness'=>$this->session->userdata('id_business'),'status_produk'=>1,'variant'=>2);
		$data['comprod']=$this->data_model->getsomething('produk',$wh);
		$data['variant']=$this->data_model->getsomething('variant',$daa);
		$tmp['content']=$this->load->view('backoffice/variant/edit_variant',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Update_variant()
	{
		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_variant'=>$this->input->post('nama_variant'),
			'idproduk'=>$this->input->post('produk'),
			'status'=>1
		);

		$id_variant=$this->input->post('id_variant');
		$this->data_model->update_something('variant',$data,$id_variant,'idvariant');

		$tanggal = time();
		$waktu = "Y-m-d";
		$sekarang = date($waktu, $tanggal);
		$hg=$this->input->post('harga_variant');
		$pd=$this->input->post('produk');

		$this->db->query("UPDATE stok SET harga = '$hg', idproduk = '$pd' WHERE idvariant = '$id_variant' AND tanggal = '$sekarang'");

		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/variant");
	}

	public function Delete()
	{
		$id_variant=$this->input->post('id_variant');
		$data=array('status'=>0);
		$this->data_model->update_something('variant',$data,$id_variant,'idvariant');
		$this->data_model->update_something('stok',$data,$id_variant,'idvariant');
		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/variant");
	}

	public function Export()
	{
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
		->setLastModifiedBy('Ultrapos')
		->setTitle("Data Variant")
		->setSubject("Variant")
		->setDescription("Laporan Data Variant")
		->setKeywords("Data Variant");

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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA VARIANT");
		$excel->getActiveSheet()->mergeCells('A1:D1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Variant");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Produk");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Harga");
        //$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        //$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		$www=array('idbusiness'=>$this->session->userdata('id_business'),'status'=>1);
		$register=$this->data_model->getsomething('variant',$www);

		$no = 1;
		$numrow = 4;
		foreach($register as $data):

			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_variant);

			$query = $this->db->query("SELECT nama_produk FROM produk where idproduk='$data->idproduk'");
			foreach ($query->result_array() as $rw) $nama_prod=$rw['nama_produk'];

			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $nama_prod);

			$query = $this->db->query("SELECT harga FROM stok WHERE tanggal=(SELECT MAX(tanggal) FROM stok WHERE idvariant='$data->idvariant') AND idvariant='$data->idvariant' AND status = 1");
			foreach ($query->result_array() as $rw) $harga_var=$rw['harga'];

			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, 'Rp.'.$harga_var);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		endforeach;

		foreach(range('A','D') as $columnID):
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Variant");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Variant.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}