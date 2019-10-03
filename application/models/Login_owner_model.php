<?php
class Login_owner_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function cek($usr, $psw)
	{
		$u = $usr;
		$p = $psw;
		$q_cek_login = $this->db->get_where('owner', array('email_user' => $u, 'password' => $p));
		if (count($q_cek_login->result()) > 0) {
			foreach ($q_cek_login->result() as $qck) {
				$date = date("Y-m-d");
				$this->db->query("UPDATE owner SET last_login = '$date' WHERE email_user = '$u' AND password = '$p'");

				if ($qck->status_user == 0) {
					$this->session->set_flashdata('message', "no-access");
					redirect('home');
				} else {
					$this->cek_session($u, $p);
					$sess_data['logged_in'] = TRUE;
					$sess_data['owner'] = TRUE;
					$sess_data['idowner'] = $qck->idowner;
					$sess_data['nama_user'] = $qck->nama_user;
					$sess_data['telp_user'] = $qck->telp_user;
					$sess_data['email_user'] = $qck->email_user;
					$sess_data['password'] = $qck->password;

					$this->session->set_userdata($sess_data);
					$this->session->set_flashdata('message', "succes-login");

					redirect('owner/dashboard');
				}
			}
		} else {
			$this->session->set_flashdata('message', "failed-login");
			return array();
			redirect('home', 'refresh');
		}
	}

	function Cek_session($user, $pw)
	{
		$sesid = $this->db->query("SELECT session_id FROM owner WHERE email_user ='$user' AND password = '$pw'")->result();
		foreach ($sesid as $rl) :
			$sess_id = $rl->session_id;
		endforeach;

		$cid = session_id();
		session_write_close();

		// 3. hijack then destroy session specified.
		session_id($sess_id);
		session_start();
		session_destroy();
		session_write_close();

		// 4. restore current session id. If you don't restore it, your current session will refer to the session you just destroyed!
		session_id($cid);
		session_start();

		$this->db->query("UPDATE owner SET session_id = '$cid' WHERE email_user = '$user' AND password = '$pw'");
	}

	function ngecek($u, $pw)
	{
		$this->db->select('idowner,email_user,password');
		$this->db->where('email_user', $u);
		$this->db->where('password', $pw);
		$this->db->limit(1);
		$Q = $this->db->get('owner');

		if ($Q->num_rows() > 0) {
			$row = $Q->row_array();
			return $row;
		} else {
			$this->session->set_flashdata('message', "failed-login");
			return array();
			redirect('home', 'refresh');
		}
	}
}
