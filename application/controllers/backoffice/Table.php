<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul']='Group Meja';
		$data['isi']='Kelola Group Meja';
		$daa=array('idbusiness'=>$this->session->userdata('id_business'),'status_group'=>1);
		$data['jum_group']=$this->data_model->count_where('table_group',$daa);
		$data['group']=$this->data_model->Getsomething_order('table_group',$daa, 'idgroup', 'desc');
		$tmp['content']=$this->load->view('backoffice/table_group/group',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Tambah_group()
	{
		$data['judul']='Group Meja';
		$data['isi']='Tambah Group Meja';
		$tmp['content']=$this->load->view('backoffice/table_group/tambah_group',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Insert_group()
	{
		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_group'=>$this->input->post('nama_group'),
			'status_group'=>1
		);
		$this->data_model->insert_something('table_group',$data);
		$this->session->set_flashdata('message',"modal-success");
        redirect("backoffice/table_group");
	}

	public function Edit_group($id=0)
	{
		$data['judul']='Group Meja';
		$data['isi']='Edit Group Meja';
		$daa=array('idgroup'=>$id);
		$data['group']=$this->data_model->getsomething('table_group',$daa);
		$tmp['content']=$this->load->view('backoffice/table_group/edit_group',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Update_group()
	{
		$id=$this->input->post('id_group');

		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_group'=>$this->input->post('nama_group'),
			'status_group'=>1
		);
        	$this->data_model->update_something('table_group',$data,$id,'idgroup');

		$this->session->set_flashdata('message',"modal-success");
        	redirect("backoffice/table_group");
	}


    public function Delete()
	{
		$id=$this->input->post('id_group');
		$data=array('status_group'=>0);
        // $data2=array('idgroup'=>0);
		$this->data_model->update_something('table_group',$data,$id,'idgroup');
        // $this->data_model->update_something('produk',$data2,$id_kategori,'idkategori');
		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/table_group");
	}

	public function Export()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                 ->setLastModifiedBy('Ultrapos')
                 ->setTitle("Data Kategori Produk")
                 ->setSubject("Kategori")
                 ->setDescription("Laporan Data Kategori")
                 ->setKeywords("Data Kategori");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KATEGORI");
        $excel->getActiveSheet()->mergeCells('A1:B1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Kategori");
        //$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        //$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

        $www=array('idbusiness'=>$this->session->userdata('id_business'),'status_kategori'=>1);
        $register=$this->data_model->getsomething('kategori',$www);

        $no = 1;
        $numrow = 4;
        foreach($register as $data):

            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_kategori);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        endforeach;

        foreach(range('A','B') as $columnID):
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Kategori");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Kategori.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

}
