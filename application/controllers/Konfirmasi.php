<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {

    public function index($id=0)
    {
        $kode_own=$id;
        $this->db->query("UPDATE owner SET status_user = '1' WHERE register_id = '$kode_own'");
        $this->load->view('konfirmasi');
    }
	
	public function Karyawan($id=0)
    {
        $kode_own=$id;
        $this->db->query("UPDATE user SET status_user = '1' WHERE kode_user = '$kode_own'");
        $this->load->view('konfirmasi');
    }

    
}
