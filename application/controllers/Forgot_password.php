<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['judul']='Forgot Password';
		$this->load->view('forgot_password/forgot_password',$data);
	}

	public function submit()
	{
		$role = $this->input->post('role');
		$email = $this->input->post('email');

		$cek_email=null;

		if ($role == 1) {
			$cek_email = $this->db->get_where('owner',['email_user' => $email])->row();
		}else{
			$where=null;
			if ($role == 2) {
				$where = array('email_user' => $email, 'role_user' => 2, 'del' => 1);
			}else{
				$where = array('email_user' => $email, 'role_user' => 3, 'del' => 1);
			}
			$cek_email = $this->db->get_where('user',$where)->row();
		}

		if (!empty($cek_email)) {
			if ($cek_email->status_user != 1) {
				$this->session->set_flashdata('message', " Email belum aktif");
				redirect('forgot_password', 'refresh');
			}else{
				$token = base64_encode(random_bytes(32));
				$user_token = array(
					'email' => $email,
					'token' => $token,
					'role_user' => $role
				);

				if ($this->db->insert('user_token', $user_token)) {
					$this->_sendEmail($role, $email, $token);

					$this->session->set_flashdata('message', "Silahkan cek email anda untuk reset password");
					if ($role == 1 || $role == 2) {
						redirect('forgot_password', 'refresh');
					}else{
						header('Location:'.base_url().'forgot_password?role=kasir');
					}

				}

			}
		}else{
			$this->session->set_flashdata('message', " Email tidak tersedia");
			redirect('forgot_password', 'refresh');
		}
			
	}

	private function _sendEmail($role, $email,$token)
	{
		$hui['role']=$role;
		$hui['email']=$email;
		$hui['token']=$token;
		$message = $this->load->view('forgot_password/email_reset_password', $hui, TRUE);
		require_once(APPPATH."third_party/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'aioposapps@gmail.com';                          // SMTP username
		$mail->Password = '1234Aiopos';                                 // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('aioposapps@gmail.com','AIO POS');                          // Set Sender Name
		$mail->addAddress($email);                                // Name is optional
		$mail->isHTML(true);
		$mail->AddEmbeddedImage(FCPATH."assets/group2.png", 'logo_up');   
		$mail->Subject = 'Reset Password';
		
		$mail->MsgHTML( stripslashes( $message ) ); 
		$mail->send();
	}

	public function reset_password()
	{
		$role = $this->input->get('role');
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		if (! $role && ! $email && ! $token) {
			$this->session->set_flashdata('msg-reset-password', 'Gagal Reset Password');
			redirect('home');
		}else{
			$isEmailExist = $this->db->get_where('user_token',['email' => $email, 'is_reset'=>1])->row();
			if ($isEmailExist) {
				if ($isEmailExist->token == $token) {

					$this->session->set_userdata('email-reset', $email);
					$this->session->set_userdata('role-reset', $role);
					$data['judul']='Reset Password';
					$this->load->view('forgot_password/reset_password',$data);

				}else{
					$this->session->set_flashdata('msg-reset-password', 'Gagal Reset Password');
					redirect('home');
				}

			}else{
				$this->session->set_flashdata('msg-reset-password', 'Gagal Reset Password');
				redirect('home');
			}

		}

	}

	public function savePassword()
	{
		$role = $this->session->userdata('role-reset');
		$email = $this->session->userdata('email-reset');
		$password = $this->input->post('password');

		$this->db->set('password',md5($password));
		$this->db->where('email_user', $email);
		if ($role == 1) {
			$this->db->update('owner');
		}else{
			$this->db->update('user');
		}

		// setelah berhasil update password, is_reset di user_token di set ke 0
		$this->db->set('is_reset',0);
		$this->db->where('email', $email);
		$this->db->update('user_token');

		// $this->session->unset_userdata('role-reset');
		// $this->session->unset_userdata('email-reset');


		if ($role == 1 || $role == 2) {
			$this->session->set_flashdata('msg-reset-password', 'Password berhasil diubah. Silahkan login menggunakan password baru Anda.');
			redirect('home','refresh');
		}else{
			$this->session->set_flashdata('msg-reset-password', 'Password berhasil diubah. Silahkan login di device menggunakan password baru Anda.');
			redirect('reset_password_kasir_succsess','refresh');
		}

	}

	public function reset_password_kasir_succsess()
	{
		$this->session->unset_userdata('role-reset');
		$this->session->unset_userdata('email-reset');
		
		$data['judul']='Success';
		$this->load->view('forgot_password/reset_password_kasir_succsess',$data);
	}

}

/* End of file Forgot_password.php */
/* Location: ./application/controllers/Forgot_password.php */
