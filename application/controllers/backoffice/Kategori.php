<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();
    }

    public function index() {
        $data['judul'] = 'Kategori';
        $data['isi'] = 'Kelola Kategori';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);
        $data['jum_kat'] = $this->data_model->count_where('kategori', $daa);
        $data['kategori'] = $this->data_model->getsomething('kategori', $daa);
        $tmp['content'] = $this->load->view('backoffice/kategori/kategori', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Tambah_kategori() {
        $data['judul'] = 'Kategori';
        $data['isi'] = 'Tambah Data Kategori';
        $tmp['content'] = $this->load->view('backoffice/kategori/tambah_kategori', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_kategori() {
        $data = array(
            'idbusiness' => $this->input->post('id_business'),
            'nama_kategori' => $this->input->post('nama_kategori'),
            'status_kategori' => 1
        );
        $this->data_model->insert_something('kategori', $data);
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/kategori");
    }

    public function Edit_kategori($id = 0) {
        $data['judul'] = 'Kategori';
        $data['isi'] = 'Edit Data Kategori';
        
        $daa = array('idkategori' => $id,'idbusiness'=> $this->session->userdata('id_business'));
        
        $data['kategori'] = $this->data_model->getsomething('kategori', $daa);
        $tmp['content'] = $this->load->view('backoffice/kategori/edit_kategori', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Update_kategori() {
        $id_kategori = $this->input->post('id_kategori');

        $data = array(
            'idbusiness' => $this->input->post('id_business'),
            'nama_kategori' => $this->input->post('nama_kategori'),
            'status_kategori' => 1
        );
        $this->data_model->update_something('kategori', $data, $id_kategori, 'idkategori');

        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/kategori");
    }

    public function Delete() {
        $id_kategori = $this->input->post('id_kategori');
        $data = array('status_kategori' => 0);
        $data2 = array('idkategori' => 0);
        $this->data_model->update_something('kategori', $data, $id_kategori, 'idkategori');
        $this->data_model->update_something('produk', $data2, $id_kategori, 'idkategori');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/kategori");
    }

    public function Export() {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
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
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $style_row = array(
            'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

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

        $www = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);
        $register = $this->data_model->getsomething('kategori', $www);

        $no = 1;
        $numrow = 4;
        foreach ($register as $data):

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_kategori);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        endforeach;

        foreach (range('A', 'B') as $columnID):
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
        ob_end_clean();
        $write->save('php://output');
    }

}
