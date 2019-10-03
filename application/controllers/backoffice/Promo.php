<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promo extends CI_Controller {

    private $id_business = "";
    private $row_number = 0;

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();

        $this->id_business = $this->session->userdata('id_business');
    }

    private function sql() {
        $sql = "select 
                '' as `no`,
                '' as `buy`,
                promo.qty,
                '' as `get`,
                promo.qty_get,
                promo.tanggal_mulai,
                promo.tanggal_akhir,
                '' as `action`,
                promo.*
            from promo
            where
            promo.idbusiness=" . $this->id_business . "
            and
            promo.status_promo=1";
        $data = $this->db->query($sql)->result_array();


        return $data;
    }

    public function index() {
        $data['judul'] = 'Promo';
        $data['isi'] = 'Kelola Promo Anda';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_promo' => 1);
        $data['jum_pro'] = $this->data_model->count_where('promo', $daa);
        $data['promo'] = $this->data_model->getsomething('promo', $daa);
        $tmp['content'] = $this->load->view('backoffice/promo/promo_list', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    private function callback_collumn($key, $col, $row) {

        if ($key == 'no') {
            $this->row_number = $this->row_number + 1;
            $col = $this->row_number;
        }

        if ($key == 'tanggal_mulai') {
            $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
        }

        if ($key == 'tanggal_akhir') {
            $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
        }

        if ($key == 'buy') {
            $nama_produk = $this->db->get_where('produk', array('idproduk' => $row['idproduk']))->row_array()['nama_produk'];
            $nama_variant = $this->db->get_where('variant', array('idvariant' => $row['idvariant']))->row_array()['nama_variant'];
            $col = $nama_produk;
            if (!empty($nama_variant)) {
                $col .= " - " . $nama_variant;
            }
        }

        if ($key == 'get') {
            $nama_produk = $this->db->get_where('produk', array('idproduk' => $row['idproduk_get']))->row_array()['nama_produk'];
            $nama_variant = $this->db->get_where('variant', array('idvariant' => $row['idvariant_get']))->row_array()['nama_variant'];
            $col = $nama_produk;
            if (!empty($nama_variant)) {
                $col .= " - " . $nama_variant;
            }
        }

        if ($key == 'action') {
            $col = "";
            $url = base_url() . "backoffice/promo/edit/" . $row['idpromo'];
            $col .= '<a href="' . $url . '" class="btn btn-default btn-xs">Edit</a>';

            $col .= '<a href="#" onclick="delete_validation(' . $row['idpromo'] . ')" '
                    . 'class="btn btn-danger btn-xs">Hapus</a>';
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

    public function testpromo()
    {
    	$result = $this->sql();

        $datatables_format = array();

        foreach ($result as $row) {
            $buffer = array();

            foreach ($row as $key => $col) {
                $col = $this->callback_collumn($key, $col, $row);
                array_push($buffer, $col);
            }
            // array_push($datatables_format, $buffer);

            echo $buffer[3];

        }
        // print_r($datatables_format[0][1]);
        // foreach ($datatables_format as $df) {
        // 	echo $df[1];
        // }
        // for ($i=0; $i < count($datatables_format) ;  $i++) { 
        // 	print_r($datatables_format[$i][1]);
        // }
    }

    public function ajax_pilih_produk() {
        $ofsite = intval($this->input->get('page'));

        if (!empty($ofsite)) {
            $ofsite = ($ofsite - 1) * 10;
        }
        $sql = "SELECT
        produk.idproduk,
        variant.idvariant,
        concat(
                produk.nama_produk,
                '-',
                (case when ISNULL(variant.nama_variant) then '' else variant.nama_variant end)
        ) as item
        from produk
        left join variant on variant.idproduk=produk.idproduk
        where produk.idbusiness=".$this->id_business."
        and 
        produk.status_produk=1
        and 
        (case WHEN  ISNULL(variant.idvariant) then 1
        else variant.`status` end)=1
        and
        concat(
                produk.nama_produk,
                '-',
                (case when ISNULL(variant.nama_variant) then '' else variant.nama_variant end)
        ) like '%" . $this->db->escape_str($this->input->get('q')) . "%'
        limit " . $ofsite . ",10";
        $data = $this->db->query($sql)->result_array();
        $paging = true;
        if (count($data) < 1) {
            $paging = false;
        }
        $output = array();
        foreach ($data as $row) {
            $buff = array();
            $buff['id'] = $row['idproduk'] . "-" . $row['idvariant'];
            $buff['text'] = rtrim($row['item'], '-');
            array_push($output, $buff);
        }
        $select2 = array(
            'results' => $output,
            'pagination' => array(
                "more" => $paging,
            )
        );
        header('Content-Type: application/json');
        echo json_encode($select2);
    }

    public function Tambah_promosi() {
        $data['judul'] = 'Kategori';
        $data['isi'] = 'Tambah Data Kategori';


        $data['selected_item'] = '';
        $data['qty_buy'] = '';
        $data['idpromo'] = '';
        $data['selected_item_get'] = '';
        $data['qty_get'] = '';
        $data['tanggal_mulai'] = '';
        $data['tanggal_akhir'] = '';

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/promo/tambah_promo', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_promo() {
        $jenis_buy = $this->input->post('jenis_buy');
        $jenis_get = $this->input->post('jenis_get');

        if ($jenis_buy == 1) {
            if ($jenis_get == 1) {
                $data = array(
                    'idbusiness' => $this->session->userdata('id_business'),
                    'idproduk' => $this->input->post('produk_buy'),
                    'qty' => $this->input->post('qty_buy'),
                    'tanggal_mulai' => $this->input->post('tgl_mulai'),
                    'tanggal_akhir' => $this->input->post('tgl_akhir'),
                    'idproduk_get' => $this->input->post('produk_get'),
                    'qty_get' => $this->input->post('qty_get'),
                    'status_promo' => '1');
                $this->data_model->insert_something('promo', $data);
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/promo");
            } else {
                $data = array(
                    'idbusiness' => $this->session->userdata('id_business'),
                    'idproduk' => $this->input->post('produk_buy'),
                    'qty' => $this->input->post('qty_buy'),
                    'tanggal_mulai' => $this->input->post('tgl_mulai'),
                    'tanggal_akhir' => $this->input->post('tgl_akhir'),
                    'idvariant_get' => $this->input->post('variant_get'),
                    'qty_get' => $this->input->post('qty_get'),
                    'status_promo' => '1');
                $this->data_model->insert_something('promo', $data);
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/promo");
            }
        } else {
            if ($jenis_get == 1) {
                $data = array(
                    'idbusiness' => $this->session->userdata('id_business'),
                    'idvariant' => $this->input->post('variant_buy'),
                    'qty' => $this->input->post('qty_buy'),
                    'tanggal_mulai' => $this->input->post('tgl_mulai'),
                    'tanggal_akhir' => $this->input->post('tgl_akhir'),
                    'idproduk_get' => $this->input->post('produk_get'),
                    'qty_get' => $this->input->post('qty_get'),
                    'status_promo' => '1');
                $this->data_model->insert_something('promo', $data);
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/promo");
            } else {
                $data = array(
                    'idbusiness' => $this->session->userdata('id_business'),
                    'idvariant' => $this->input->post('variant_buy'),
                    'qty' => $this->input->post('qty_buy'),
                    'tanggal_mulai' => $this->input->post('tgl_mulai'),
                    'tanggal_akhir' => $this->input->post('tgl_akhir'),
                    'idvariant_get' => $this->input->post('variant_get'),
                    'qty_get' => $this->input->post('qty_get'),
                    'status_promo' => '1');
                $this->data_model->insert_something('promo', $data);
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/promo");
            }
        }
    }

    public function Edit_promo($id = 0) {
        $data['judul'] = 'Promo';
        $data['isi'] = 'Edit Promo Anda';
        $ai = ($id);
        $dat = array('idpromo' => $ai);
        $data['promo'] = $this->data_model->getsomething('promo', $dat);
        $tmp['content'] = $this->load->view('backoffice/promo/edit_promo', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Update_promo() {
        $idpro = $this->input->post('idpromo');

        $data = array(
            'qty' => $this->input->post('qty_buy'),
            'tanggal_mulai' => $this->input->post('tgl_mulai'),
            'tanggal_akhir' => $this->input->post('tgl_akhir'),
            'qty_get' => $this->input->post('qty_get'));
        $this->data_model->update_something('promo', $data, $idpro, 'idpromo');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/promo");
    }

    public function Delete() {
        $id_promo = $this->input->post('id_promo');
        $data = array('status_promo' => 0);
        $this->data_model->update_something('promo', $data, $id_promo, 'idpromo');
        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/promo");
    }

    public function edit($id) {
        $data['judul'] = 'Kategori';
        $data['isi'] = 'Tambah Data Kategori';

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $this->load->helper('haris_helper');

        $this->db->where('idpromo', $id);
        $db = $this->db->get('promo');
        if ($db->num_rows() < 1) {
            redirect('backoffice/promo/');
        }
        $result = $db->row_array();


        $nama_variant = $this->db->get_where('variant', array('idvariant' => $result['idvariant']))->row_array()['nama_variant'];
        $nama_produk = $this->db->get_where('produk', array('idproduk' => $result['idproduk']))->row_array()['nama_produk'];
        $selected_item = '<option selected="true" value="' . $result['idproduk'] . '-' . $result['idvariant'] . '">' . $nama_produk . '-' . $nama_variant . '</option>';
        $data['selected_item'] = $selected_item;
        $data['qty_buy'] = $result['qty'];

        $nama_variant = $this->db->get_where('variant', array('idvariant' => $result['idvariant_get']))->row_array()['nama_variant'];
        $nama_produk = $this->db->get_where('produk', array('idproduk' => $result['idproduk_get']))->row_array()['nama_produk'];
        $selected_item = '<option selected="true"  value="' . $result['idproduk_get'] . '-' . $result['idvariant_get'] . '">' . $nama_produk . '-' . $nama_variant . '</option>';
        $data['selected_item_get'] = $selected_item;
        $data['qty_get'] = $result['qty_get'];
        $data['idpromo'] = $id;
        $data['tanggal_mulai'] = date('d/m/Y',strtotime($result['tanggal_mulai'] )) ;
        $data['tanggal_akhir'] = date('d/m/Y',strtotime($result['tanggal_akhir'] ));

        // print_r($data);die();

        $tmp['content'] = $this->load->view('backoffice/promo/tambah_promo', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function submit() {
        $status = true;
        $message = "";
        $data = array();

        $form['produk_buy'] = $this->input->post('produk_buy');
        $form['qty_buy'] = $this->input->post('qty_buy');
        $form['produk_get'] = $this->input->post('produk_get');
        $form['qty_get'] = $this->input->post('qty_get');
        $form['tgl_mulai'] = $this->input->post('tgl_mulai');
        $form['tgl_akhir'] = $this->input->post('tgl_akhir');

        $this->load->library('form_validation');
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules('produk_buy', "Produk Promo", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('qty_buy', "Qty Promo", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('produk_get', "Produk Bonus", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('qty_get', "Qty Bonus", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('tgl_mulai', "Tgl Mulai", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);
        $this->form_validation->set_rules('tgl_akhir', "Tgl Akhir", 'trim|required',
        	array('required' => '*%s ada yang kosong.')
    	);

        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }

        if ($status) {
            $buff1 = explode('-', $this->input->post('produk_buy'));
            $buff2 = explode('-', $this->input->post('produk_get'));

            $tgl_mulai = DateTime::createFromFormat('d/m/Y', trim($form['tgl_mulai']))->format('Y-m-d');
            $tgl_akhir = DateTime::createFromFormat('d/m/Y', trim($form['tgl_akhir']))->format('Y-m-d');

            $arr = array();

            $arr['idbusiness'] = $this->id_business;
            $arr['idproduk'] = $buff1[0];
            $arr['idvariant'] = $buff1[1];
            $arr['qty'] = intval($this->input->post('qty_buy'));
            $arr['tanggal_mulai'] = $tgl_mulai;
            $arr['tanggal_akhir'] = $tgl_akhir;
            $arr['idproduk_get'] = $buff2[0];
            $arr['idvariant_get'] = $buff2[1];
            $arr['qty_get'] = intval($this->input->post('qty_get'));
            $arr['status_promo'] = 1;

            if (empty(trim($this->input->post('idpromo')))) {
                $this->db->insert('promo', $arr);
            } else {
                $this->db->where('idpromo', trim($this->input->post('idpromo')));
                $this->db->update('promo', $arr);
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    public function Export()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('Ultrapos')
                 ->setLastModifiedBy('Ultrapos')
                 ->setTitle("Data Promo")
                 ->setSubject("Promo")
                 ->setDescription("Laporan Data Promo")
                 ->setKeywords("Data Promo");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PROMO");
        $excel->getActiveSheet()->mergeCells('A1:G1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Buy");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Qty");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Get");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Qty");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Mulai");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Akhir");
        //$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

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
        	$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $buffer[5]);
        	$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $buffer[6]);

        	$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);

            $numrow++;
        }


        // $www=array('idbusiness'=>$this->session->userdata('id_business'),'status_kategori'=>1);
        // $register=$this->data_model->getsomething('kategori',$www);

        // $no = 1;
        // $numrow = 4;
        // foreach($register as $data):

        //     $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
        //     $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_kategori);

        //     $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        //     $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);

        //     $no++;
        //     $numrow++;
        // endforeach;

        foreach(range('A','G') as $columnID):
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Promo");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Data Promo.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        ob_end_clean();
        $write->save('php://output');
    }

}
