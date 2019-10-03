<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function Logout()
    {
        $email = $this->session->userdata('email_user');
        $password = $this->session->userdata('password');
        $this->db->query("UPDATE owner SET session_id = '0', last_login= now() WHERE email_user = '$email' AND password = '$password'");
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('nama');
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', "Logout");
        redirect('home', 'refresh');
    }
}
