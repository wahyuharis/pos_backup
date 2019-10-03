<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_1 extends CI_Controller {

    private $id_business = "";
    private $type_business = "";
    private $numbering_row = 0;
    private $pakai_stok = false;

    public function __construct() {
        parent::__construct();

        $this->security_model->loggedin_check();
        $this->load->helper('haris_helper');

        $this->id_business = $this->session->userdata('id_business');
        $this->type_business = $this->session->userdata('type_bus');
    }

    public function index() {
        $this->load->library('form_validation');

        $succes = true;
        $message = false;
        $data = array();


        $data1 = array(
            'customer' => '',
            'tanggal' => '2019-08-31',
        );

        $this->form_validation->set_data($data1);
        $this->form_validation->set_rules('customer', 'customer', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
        if ($this->form_validation->run() == false) {
            $message .= validation_errors();
            $this->form_validation->reset_validation();
        }


        $data2 = array(
            array(
                'item' => 'item 1',
                'qty' => 10,
                'harga' => 12000,
            ),
            array(
                'item' => 'item 2',
                'qty' => 12,
                'harga' => '',
            ),
            array(
                'item' => 'item 3',
                'qty' => 20,
                'harga' => '',
            ),
        );

        $no = 0;
        foreach ($data2 as $row) {
            $no++;
            $this->form_validation->set_data($row);
            $this->form_validation->set_rules('item', 'Item' . ' ' . $no, 'trim|required');
            $this->form_validation->set_rules('qty', 'Qty' . ' ' . $no, 'trim|required');
            $this->form_validation->set_rules('harga', 'harga' . ' ' . $no, 'trim|required');
            if ($this->form_validation->run() == false) {
                $message .= validation_errors();
            }
            $this->form_validation->reset_validation();
        }

        echo $message;
    }

}
