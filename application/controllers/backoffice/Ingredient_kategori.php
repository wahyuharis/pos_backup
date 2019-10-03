<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredient_kategori extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index()
	{
		$data['judul']='Kategori Ingredient';
		$data['isi']='Kelola Kategori Ingredient';
		$daa=array('idbusiness'=>$this->session->userdata('id_business'),'status_kategori'=>1);
		$data['jum_kat']=$this->data_model->count_where('ingredient_kategori',$daa);
		$data['kategori']=$this->data_model->getsomething('ingredient_kategori',$daa);
		$tmp['content']=$this->load->view('backoffice/ingredient_kategori/kategori',$data,true);
		$this->load->view('backoffice/template',$tmp);
		
	}

	public function tambah_kategori()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data=array(
				'idbusiness'=>$this->input->post('id_business'),
				'nama_kategori'=>$this->input->post('nama_kategori'),
				'status_kategori'=>1
			);
			$this->data_model->insert_something('ingredient_kategori',$data);
			$this->session->set_flashdata('message',"modal-success");
      	redirect("backoffice/ingredient_kategori");
			
		}else{
			$data['judul']='Kategori Ingredient';
			$data['isi']='Tambah Kategori Ingredient';
			$tmp['content']=$this->load->view('backoffice/ingredient_kategori/tambah_kategori',$data,true);
			$this->load->view('backoffice/template',$tmp);
		}
	}

	public function edit_kategori()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $this->input->post('id');

			$data=array(
				// 'idbusiness'=>$this->input->post('id_business'),
				'nama_kategori'=>$this->input->post('nama_kategori'),
			);
			$this->data_model->Update_something('ingredient_kategori',$data,$id,'idkatingredient');
			$this->session->set_flashdata('message',"modal-success");
      	redirect("backoffice/ingredient_kategori");
			
		}else{
			$id = $this->uri->segment(4);
			$data['judul']='Kategori Ingredient';
			$data['isi']='Edit Kategori Ingredient';
			$daa=array('idkatingredient'=>$id);
			$data['kategori']=$this->data_model->getsomething('ingredient_kategori',$daa);

			$tmp['content']=$this->load->view('backoffice/ingredient_kategori/edit_kategori',$data,true);
			$this->load->view('backoffice/template',$tmp);
		}
	}

	public function hapus_kategori()
	{
		$id = $this->input->post('id');
		$data=array('status_kategori'=>0);
		$this->data_model->update_something('ingredient_kategori',$data,$id,'idkatingredient');
		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/ingredient_kategori");
	}

	public function Export()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                 ->setLastModifiedBy('Ultrapos')
                 ->setTitle("Data Kategori Ingredient")
                 ->setSubject("Kategori Ingredient")
                 ->setDescription("Laporan Data Kategori Ingredient")
                 ->setKeywords("Data Kategori Ingredient");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KATEGORI INGREDIENT");
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
        $register=$this->data_model->getsomething('ingredient_kategori',$www);

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

        $excel->getActiveSheet(0)->setTitle("Laporan Kategori Ingredient");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Kategori Ingredient.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

}

/* End of file Ingredient_kategori.php */
/* Location: ./application/controllers/Ingredient_kategori.php */
