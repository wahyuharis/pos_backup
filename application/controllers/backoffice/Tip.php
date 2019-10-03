<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tip extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul']='Tip';
		$data['isi']='Manajemen Data Tips';
		$daa=array('idbusiness'=>$this->session->userdata('id_business'),'status_gratuity'=>1);
		$data['gratuity']=$this->data_model->getsomething('gratuity',$daa);
		$data['jum_tip']=$this->data_model->count_where('gratuity',$daa);
		$tmp['content']=$this->load->view('backoffice/tip/tip',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Tambah_tip()
	{
		$data['judul']='Tip';
		$data['isi']='Tambah Data Tip';
		$tmp['content']=$this->load->view('backoffice/tip/tambah_tip',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Insert_tip()
	{
		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_gratuity'=>$this->input->post('nama_tip'),
			'besaran_gratuity'=>$this->input->post('besaran'),
			'status_gratuity'=>1
		);
		$this->data_model->insert_something('gratuity',$data);
		$this->session->set_flashdata('message',"modal-success");
        redirect("backoffice/tip");
	}

	public function Edit_tip($id=0)
	{
		$data['judul']='Tip';
		$data['isi']='Edit Data Tip';
        	$ai=$this->my_encrypt->decode($id);
		$daa=array('idgratuity'=>$ai);
		$data['tip']=$this->data_model->getsomething('gratuity',$daa);
		$tmp['content']=$this->load->view('backoffice/tip/edit_tip',$data,true);
		$this->load->view('backoffice/template',$tmp);
	}

	public function Update_tip()
	{
		$id_gratuity=$this->input->post('id_tip');

		$data=array(
			'idbusiness'=>$this->input->post('id_business'),
			'nama_gratuity'=>$this->input->post('nama_tip'),
			'besaran_gratuity'=>$this->input->post('besaran'),
			'status_gratuity'=>1
		);
        	$this->data_model->update_something('gratuity',$data,$id_gratuity,'idgratuity');

		$this->session->set_flashdata('message',"modal-success");
        	redirect("backoffice/tip");
	}

	public function Delete()
	{
		$id_tip=$this->input->post('id_tip');
		$data=array('status_gratuity'=>0);
		$this->data_model->update_something('gratuity',$data,$id_tip,'idgratuity');
		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/tip");
	}

	public function Export()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                 ->setLastModifiedBy('Ultrapos')
                 ->setTitle("Data Tip")
                 ->setSubject("Tip")
                 ->setDescription("Laporan Data Tip")
                 ->setKeywords("Data Tip");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA TIP");
        $excel->getActiveSheet()->mergeCells('A1:C1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Tip");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Besaran");
        //$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        //$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

        $www=array('idbusiness'=>$this->session->userdata('id_business'),'status_gratuity'=>1);
        $register=$this->data_model->getsomething('gratuity',$www);

        $no = 1;
        $numrow = 4;
        foreach($register as $data):

            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_gratuity);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->besaran_gratuity.'%');

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        endforeach;

        foreach(range('A','C') as $columnID):
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Tip");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Tip.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        ob_end_clean();
        $write->save('php://output');
    }
}
