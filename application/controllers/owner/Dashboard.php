<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->security_model->owner_check();
    }

    public function index() {
        $data['judul'] = 'Dashboard';
        $data['isi'] = 'Kelola Dashboard';
        $whr=array('idowner'=>$this->session->userdata('idowner'));
        $data['data'] = $this->data_model->getsomething('business',$whr);

        $tmp['content'] = $this->load->view('owner/business', $data, true);
        $this->load->view('owner/template', $tmp);
    }

    public function Backoffice($id=0)
    {
        $whr=array('idbusiness'=>$id);
        $heh=$this->data_model->getsomething('business',$whr);

        foreach($heh as $rw):
            $idbusiness=$rw->idbusiness;
            $stok=$rw->stok;
        endforeach;

        $sess_data['stok']=$stok;
        $sess_data['id_business']=$idbusiness;
        $this->session->set_userdata($sess_data);

        redirect('backoffice/dashboard');
    }
}
