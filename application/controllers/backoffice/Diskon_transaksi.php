<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diskon_transaksi extends CI_Controller {

    private $id_business = "";
    private $url_controller = 'backoffice/diskon_transaksi/';
    private $row_number = 0;

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();
        $this->id_business = $this->session->userdata('id_business');
    }

    private function sql() {
        $sql = "select 
        '' as `no`,
        nama,
        outlet.name_outlet,
        persen,
         DATE_FORMAT(tgl_start,'%d/%m/%Y') as tgl_start,
                 DATE_FORMAT(tgl_end,'%d/%m/%Y') as tgl_end,
        active,
        '' as  action,
        id_diskon_transaksi,
        `status`
        from 
        diskon_transaksi
        left JOIN outlet on outlet.idoutlet=diskon_transaksi.idoutlet
        where diskon_transaksi.`status`=1
        and diskon_transaksi.idbusiness=" . $this->id_business . "  ";

//        echo $sql;
//        die();

        return $sql;
    }

    public function index() {
        $data['judul'] = 'Diskon';
        $data['isi'] = 'Kelola Diskon Anda';
        $data['url_controller'] = $this->url_controller;
        $tmp['content'] = $this->load->view('backoffice/diskon_transaksi/diskon_list', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    private function callback_collumn($key, $col, $row) {
        if ($key == 'no') {
            $this->row_number = $this->row_number + 1;
            $col = $this->row_number;
        }

        if ($key == 'active') {
            $id_encrypt = urlencode(base64_encode($row['id_diskon_transaksi']));
            if ($col == 1) {
                $col = '<a href="#"  class="btn btn-primary btn-xs" >active</a>';
            } else {
                $col = '<a href="' . base_url() . $this->url_controller . 'active/' . $id_encrypt . '" class="btn btn-default btn-xs" >not active</a>';
            }
        }


        if ($key == 'action') {
            $id_encrypt = urlencode(base64_encode($row['id_diskon_transaksi']));
            $col = '<a href="' . base_url() . $this->url_controller . 'edit/' . $id_encrypt . '" '
                    . 'class="btn btn-default btn-xs">Edit</a>';
            $col .= '<a href="#" class="btn btn-danger btn-xs" onclick="delete_validation(' . "'" . $id_encrypt . "'" . ')">Hapus</a>';
        }

        return $col;
    }

    public function datatable() {
        $result = $this->db->query($this->sql())->result_array();

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

    public function add() {
        $this->edit(null);
    }

    public function edit($id) {

        if (empty($id)) {
            $id = null;
        } else {
            $id = base64_decode(urldecode($id));
        }

        $field['id_diskon_transaksi'] = $id;
        $field['idbusiness'] = $this->id_business;
        $field['nama'] = '';
        $field['idoutlet'] = '';
        $field['persen'] = '';
        $field['tgl_start'] = '';
        $field['tgl_end'] = '';
        $field['active'] = '';
        $field['status'] = '';
        $field['opt_active'] = array(
            '' => 'Pilih Status',
            1 => 'Active',
            0 => 'Tidak Active'
        );

        $this->load->helper('haris_helper');
        $result = $this->db->where('idbusiness', $this->id_business)->get('outlet')->result_array();
        $opt_outlet = create_dropdown_array($result, 'idoutlet', 'name_outlet');
        $opt_outlet[''] = 'Pilih Outlet';

        $field['opt_outlet'] = $opt_outlet;

        if (!empty(trim($id))) {
            $this->db->where('id_diskon_transaksi', $id);
            $exc = $this->db->get('diskon_transaksi');
            if ($exc->num_rows() > 0) {
                $res = $exc->row_array();

                $field['nama'] = $res['nama'];
                $field['idoutlet'] = $res['idoutlet'];

                $field['persen'] = $res['persen'];
                $field['tgl_start'] = DateTime::createFromFormat('Y-m-d', trim($res['tgl_start']))->format('d/m/Y');
                $field['tgl_end'] = DateTime::createFromFormat('Y-m-d', trim($res['tgl_end']))->format('d/m/Y');

                $field['active'] = $res['active'];
                $field['status'] = 1;
            } else {
                redirect($this->url_controller);
            }
        }

        $field['judul'] = 'Buat Diskon';
        if (empty($id)) {
            $field['judul'] = 'Edit Diskon';
        }

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $field['isi'] = 'Kelola Diskon Anda';
        $field['url_controller'] = $this->url_controller;
        $tmp['content'] = $this->load->view('backoffice/diskon_transaksi/edit_diskon_pertransaksi', $field, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function submit() {
        $status = true;
        $message = "";
        $data = array();


        $form['nama'] = $this->input->post('nama');
        $form['persen'] = $this->input->post('persen');
        $form['idoutlet'] = $this->input->post('idoutlet');
        $form['tgl_start'] = $this->input->post('tgl_start');
        $form['tgl_end'] = $this->input->post('tgl_end');
        $form['active'] = $this->input->post('active');


        $this->load->library('form_validation');
        $this->form_validation->set_data($form);

        $this->form_validation->set_rules('nama', "Nama", 'trim|required');
        $this->form_validation->set_rules('persen', "Persen", 'trim|required');
        $this->form_validation->set_rules('idoutlet', "Outlet", 'trim|required');
        $this->form_validation->set_rules('tgl_start', "Tgl Start", 'trim|required');
        $this->form_validation->set_rules('tgl_end', "Tgl End", 'trim|required');
        $this->form_validation->set_rules('active', "Active", 'trim|required');



        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }


        if ($status) {
            $column = array();
            $column['nama'] = $this->input->post('nama');
            $column['persen'] = $this->input->post('persen');
            $column['idoutlet'] = $this->input->post('idoutlet');
            $column['tgl_start'] = DateTime::createFromFormat('d/m/Y', trim($this->input->post('tgl_start')))->format('Y-m-d');
            $column['tgl_end'] = DateTime::createFromFormat('d/m/Y', trim($this->input->post('tgl_end')))->format('Y-m-d');
            $column['active'] = $this->input->post('active');
            $column['idbusiness'] = $this->id_business;

            if ($column['active'] == 1) {
                $this->db->update('diskon_transaksi', array('active' => 0));
            }

            if (!empty(trim($this->input->post('id_diskon_transaksi')))) {
                $where = array(
                    'id_diskon_transaksi' => $this->input->post('id_diskon_transaksi'),
                );
                $this->db->update('diskon_transaksi', $column, $where);
            } else {
                $this->db->insert('diskon_transaksi', $column);
            }
        }



        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    public function delete() {
        $id = $this->input->post('id_diskon_transaksi');
        $id = base64_decode(urldecode($id));

        $this->db->where('id_diskon_transaksi', $id);
        $this->db->set(array('status' => 0));
        $this->db->update('diskon_transaksi');

        redirect($this->url_controller);
    }

    public function active($id) {
        $id = base64_decode(urldecode($id));
        $this->db->update('diskon_transaksi', array('active' => 0));

        $this->db->where('id_diskon_transaksi', $id);
        $this->db->set('active', 1);
        $this->db->update('diskon_transaksi');

        redirect($this->url_controller);
    }

}
