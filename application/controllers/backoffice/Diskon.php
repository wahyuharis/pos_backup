<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diskon extends CI_Controller {

    private $id_business = "";
    private $row_number = 0;

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();

        $this->id_business = $this->session->userdata('id_business');
    }

    private function sql() {
        $sql = "select 
                '' as no,
                '' as produk,
            	 diskon,
                DATE_FORMAT(tgl_mulai,'%d/%m/%Y') as tgl_mulai_dmy,
                DATE_FORMAT(tgl_akhir,'%d/%m/%Y') as tgl_akhir_dmy,
                '' as action,
                diskon_produk.*
            from diskon_produk
            where 
            diskon_produk.status_diskon=1
            and diskon_produk.idbusiness=" . $this->id_business . " ";

        return $this->db->query($sql)->result_array();
    }

    public function index() {
        $data['judul'] = 'Diskon';
        $data['isi'] = 'Kelola Diskon Anda';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_diskon' => 1);
//        $data['jum_dis'] = $this->data_model->count_where('diskon_produk', $daa);
//        $data['diskon'] = $this->data_model->getsomething('diskon_produk', $daa);
        $tmp['content'] = $this->load->view('backoffice/diskon/diskon_list', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Tambah_diskon() {
        $data['judul'] = 'Diskon';
        $data['isi'] = 'Tambah Diskon';
        $idbus = $this->session->userdata('id_business');

        $data['iddiskon'] = '';
        $data['selected_item'] = '<option value="" > Pilih Produk/Variant </option>';
        $data['diskon'] = '';

        $data['tgl_mulai'] = '';
        $data['tgl_akhir'] = '';

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/diskon/tambah_diskon', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Edit_diskon($id = 0) {
        $data['judul'] = 'Diskon';
        $data['isi'] = 'Tambah Diskon';
        $idbus = $this->session->userdata('id_business');

        $diskon = $this->db->where('iddiskon', $id)->get('diskon_produk')->row_array();
        $produk = $this->db->where('idproduk', $diskon['idproduk'])->get('produk')->row_array();
        $variant = $this->db->where('idvariant', $diskon['idvariant'])->get('variant')->row_array();

        $selected_item = '<option value="' . $produk['idproduk'] . '-" >' . $produk['nama_produk'] . '</option>';
        if (isset($variant['idvariant'])) {
            $selected_item = '<option value="' . $produk['idproduk'] . '-' . $variant['idvariant'] . '" >' . $produk['nama_produk'] . '-' . $variant['nama_variant'] . '</option>';
        }

        $data['iddiskon'] = $id;
        $data['selected_item'] = $selected_item;
        $data['diskon'] = $diskon['diskon'];

        $tgl_mulai = DateTime::createFromFormat('Y-m-d', trim($diskon['tgl_mulai']))->format('d/m/Y');
        $tgl_akhir = DateTime::createFromFormat('Y-m-d', trim($diskon['tgl_akhir']))->format('d/m/Y');

        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_akhir'] = $tgl_akhir;

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/diskon/tambah_diskon', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Update_diskon() {
        $iddiskon = $this->input->post('iddiskon');

        $data = array(
            'diskon' => $this->input->post('diskon'),
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_akhir' => $this->input->post('tgl_akhir'));
        $this->data_model->update_something('diskon_produk', $data, $iddiskon, 'iddiskon');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/diskon");
    }

    public function delete() {
        $id_diskon = $this->input->post('id_diskon');
        $data = array('status_diskon' => 0);
        $this->db->where('iddiskon', $id_diskon)->set($data)->update('diskon_produk');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/diskon");
    }

    public function submit() {
        $status = true;
        $message = "";
        $data = array();

        $form['iddiskon'] = $this->input->post('iddiskon');
        $form['produk_buy'] = $this->input->post('produk_buy');
        $form['diskon'] = $this->input->post('diskon');
        $form['tgl_mulai'] = $this->input->post('tgl_mulai');
        $form['tgl_akhir'] = $this->input->post('tgl_akhir');


        $this->load->library('form_validation');
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules('produk_buy', "Produk", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('diskon', "Diskon", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('tgl_mulai', "Tanggal Mulai", 'trim|required');
        $this->form_validation->set_rules('tgl_akhir', "Tanggal Akhir", 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }
        if ($status) {
            $buff1 = explode('-', $this->input->post('produk_buy'));

            $tgl_mulai = DateTime::createFromFormat('d/m/Y', trim($form['tgl_mulai']))->format('Y-m-d');
            $tgl_akhir = DateTime::createFromFormat('d/m/Y', trim($form['tgl_akhir']))->format('Y-m-d');

            $arr = array();

            $arr['idbusiness'] = $this->id_business;
            $arr['idproduk'] = $buff1[0];
            $arr['idvariant'] = $buff1[1];
            $arr['diskon'] = intval($form['diskon']);
            $arr['tgl_mulai'] = $tgl_mulai;
            $arr['tgl_akhir'] = $tgl_akhir;
            $arr['status_diskon'] = 1;

            if (empty(trim($this->input->post('iddiskon')))) {
                $this->db->insert('diskon_produk', $arr);
            } else {
                $this->db->where('iddiskon', trim($this->input->post('iddiskon')));
                $this->db->update('diskon_produk', $arr);
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    private function callback_collumn($key, $col, $row) {
        if ($key == 'no') {
            $this->row_number = $this->row_number + 1;
            $col = $this->row_number;
        }

        if ($key == 'produk') {
            $produk = $this->db->where('idproduk', $row['idproduk'])->get('produk')->row_array();
            $variant = $this->db->where('idvariant', $row['idvariant'])->get('variant')->row_array();

            $col = $produk['nama_produk'] . " - " . $variant['nama_variant'];
            if (empty($variant['nama_variant'])) {
                $col = $produk['nama_produk'];
            }
        }

        if ($key == 'action') {

            $col = '<a href="' . base_url() . 'backoffice/diskon/Edit_diskon/' . $row['iddiskon'] . '" '
                    . 'class="btn btn-default btn-xs">Edit</a>';
            $col .= '<a href="#" class="btn btn-danger btn-xs" onclick="delete_validation(' . $row['iddiskon'] . ')">Hapus</a>';
        }

        return $col;
    }

    public function datatable() {
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

    public function Export()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                 ->setLastModifiedBy('Ultrapos')
                 ->setTitle("Data Diskon")
                 ->setSubject("Diskon")
                 ->setDescription("Laporan Data Diskon")
                 ->setKeywords("Data Diskon");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA DISKON");
        $excel->getActiveSheet()->mergeCells('A1:E1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Produk");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Diskon (%)");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Mulai");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Akhir");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        $result = $this->sql();

        $numrow = 4;
        $num=1;
        foreach ($result as $row) {
            $buffer = array();
            foreach ($row as $key => $col) {
                $col = $this->callback_collumn($key, $col, $row);
                array_push($buffer, $col);
            }
            // array_push($data_format, $buffer);
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $num++);
        	$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $buffer[1]);
        	$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $buffer[2]);
        	$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $buffer[3]);
        	$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $buffer[4]);

        	$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

            $numrow++;
        }

        foreach(range('A','G') as $columnID):
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Diskon");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Diskon.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        ob_end_clean();
        $write->save('php://output');
    }

}
