<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();
    }

    public function index() {
        $data['judul'] = 'Pajak';
        $data['isi'] = 'Manajemen Data Pajak';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_tax' => 1);
        $data['tax'] = $this->data_model->getsomething('tax', $daa);
        $data['jum_tax'] = $this->data_model->count_where('tax', $daa);
        $tmp['content'] = $this->load->view('backoffice/tax/tax', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    private function opt_outlet() {
        $sql = "select * from outlet 
        where 
        outlet.idbusiness= " . $this->db->escape($this->session->userdata('id_business')) . "
        and outlet.status_outlet=1
        and outlet.idoutlet not in 
            ( select tax.idoutlet 
                from tax 
                where 
                tax.idbusiness=" . $this->db->escape($this->session->userdata('id_business')) . "
                and tax.status_tax=1
           ) ";

        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    public function Tambah_tax() {
        $data['judul'] = 'Tax';
        $data['isi'] = 'Tambah Data Tax';

        $this->load->helper('haris_helper');
        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $this->db->where('status_outlet', '1');
        $res = $this->db->get('outlet')->result_array();
        $opt_outlet = create_dropdown_array($res, 'idoutlet', 'name_outlet');
        $opt_outlet[''] = "Pilih Outlet";
        $data['opt_outlet'] = $opt_outlet;

        $wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
        $data['comout'] = $this->data_model->getsomething('outlet', $wh);
        $tmp['content'] = $this->load->view('backoffice/tax/tambah_tax', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_tax() {
        $data = array(
            'idbusiness' => $this->input->post('id_business'),
            'nama_tax' => $this->input->post('nama_tax'),
            'besaran_tax' => $this->input->post('besaran_tax'),
            'idoutlet' => $this->input->post('outlet'),
            'status_tax' => 1
        );
        $this->data_model->insert_something('tax', $data);
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/tax");
    }

    public function Edit_tax($id = 0) {
        $data['judul'] = 'Tax';
        $data['isi'] = 'Edit Data Tax';
        $ai=$this->my_encrypt->decode($id);
        $daa = array('idtax' => $ai);
        $data['tax'] = $this->data_model->getsomething('tax', $daa);
        $wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
        $data['comout'] = $this->data_model->getsomething('outlet', $wh);
        $tmp['content'] = $this->load->view('backoffice/tax/edit_tax', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Update_tax() {
        $id_tax = $this->input->post('id_tax');

        $data = array(
            'idbusiness' => $this->input->post('id_business'),
            'nama_tax' => $this->input->post('nama_tax'),
            'besaran_tax' => $this->input->post('besaran_tax'),
            'idoutlet' => $this->input->post('outlet'),
            'status_tax' => 1
        );
        $this->data_model->update_something('tax', $data, $id_tax, 'idtax');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/tax");
	}

    public function Delete() {
        $id_tax = $this->input->post('id_tax');
        $data = array('status_tax' => 0);
        $this->data_model->update_something('tax', $data, $id_tax, 'idtax');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/tax");
    }

    public function Export() {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                ->setLastModifiedBy('Ultrapos')
                ->setTitle("Data Tax")
                ->setSubject("Tax")
                ->setDescription("Laporan Data Tax")
                ->setKeywords("Data Tax");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA TAX");
        $excel->getActiveSheet()->mergeCells('A1:D1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Tax");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Outlet");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Besaran");
        //$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        //$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

        $www = array('idbusiness' => $this->session->userdata('id_business'), 'status_tax' => 1);
        $register = $this->data_model->getsomething('tax', $www);

        $no = 1;
        $numrow = 4;
        foreach ($register as $data):

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_tax);

            $query = $this->db->query("SELECT name_outlet FROM outlet where idoutlet='$data->idoutlet'");
            foreach ($query->result_array() as $rw)
                $nama_out = $rw['name_outlet'];

            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $nama_out);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->besaran_tax . '%');

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        endforeach;

        foreach (range('A', 'D') as $columnID):
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Tax");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Tax.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        ob_end_clean();
        $write->save('php://output');
    }

}
