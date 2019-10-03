<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

	private $number_column = 0;
	private $role_user;

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
		$this->role_user = $this->session->userdata('role_user');
	}

	/*
  public function index()
  {
      $data['judul']='Karyawan';
      $data['isi']='Manajemen Data karyawan';
      $daa=array('idbusiness'=>$this->session->userdata('id_business'),'status_user'=>1);
      $data['jum_tot']=$this->data_model->count_where('user',$daa);
      $data['karyawan']=$this->data_model->getsomething('user',$daa);
      $tmp['content']=$this->load->view('backoffice/karyawan/karyawan',$data,true);
      $this->load->view('backoffice/template',$tmp);
  }
  */

	public function index()
	{
		$data['judul'] = 'Karyawan';
		$data['isi'] = 'Manajemen Data Karyawan';

		// $table_header = array(
		// 	'<label><input type="checkbox" name="cb-all" > #</label>',
		// 	'No',
		// 	'Email',
		// 	'Nama Karyawan',
		// 	'Username',
		// 	'Nama Outlet',
		// 	'Role Karyawan',
		// 	'No Telp',
		// 	'Action'
		// );
		$table_header = array(
			'<label><input type="checkbox" name="cb-all" > #</label>',
			'No',
			'Nama Karyawan',
			'No Telp',
			'Nama Outlet',
			'Username',
			'Role Karyawan',
			'Action'
		);

		$data['table_header'] = $table_header;

		$tmp['content'] = $this->load->view('backoffice/karyawan/karyawan_datatables', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	private function sql()
	{
		$resut = array();

		$id_business = $this->session->userdata('id_business');

		$sql = "SELECT
        ' ' as checkbox,
        user.iduser, 
        user.nama_user,user.telp_user,  outlet.name_outlet,user.username,
        user.role_user,  ' ' as action
		  FROM user LEFT JOIN outlet ON outlet.idoutlet = user.idoutlet";
		$sql .= " WHERE user.idbusiness = '" . $id_business . "' AND user.del = '1'";
		if ($this->session->userdata('role_user') == 2) {
			$sql .= " AND user.role_user = '3'";
		}
		$result = $this->db->query($sql)->result_array();

		return $result;
		// user.status_user as status
	}

	private function callback_collumn($key, $col, $row)
	{

		if ($key == 'action') {
			$new = $this->my_encrypt->encode($row['iduser']);

			$url = base_url() . "backoffice/user/edit_karyawan/" . $new;
			$col .= '<a href="' . $url . '" class="btn btn-default btn-xs">Edit</a>';
			$col .= '<a href="#" '
				. ' class="btn btn-danger btn-xs" '
				. ' onclick="delete_validation(' . $row['iduser'] . ')" >Delete</a>';
		}

		if ($key == 'iduser') {
			$this->number_column = $this->number_column + 1;
			$col = $this->number_column;
		}

		if ($key == 'role_user') {
			if ($row['role_user'] == '1') {
				$col = "Manajer";
			} elseif ($row['role_user'] == '2') {
				$col = "Backofficer";
			} else {
				$col = "Kasir";
			}
		}

		// if($key == 'status')
		// {
		//     if($row['status'] == 1)
		//     {
		//         $col = '<a href="#" class="btn btn-info btn-xs">ACTIVE</a>';
		//     }
		//     else
		//     {
		//         $col = '<a href="#" class="btn btn-danger btn-xs">INACTIVE</a>';
		//     }
		// }

		if ($key == 'checkbox') {
			$col = '<input type="checkbox" name="karyawan-cb" class="list-checkbox" value="' . $row['iduser'] . '" >';
		}

		return $col;
	}

	public function datatable()
	{
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

	public function Tambah_user()
	{
		$alphanum = "abcdefghijklpqrstuvxyz1248967";
		$data['kode'] = str_shuffle($alphanum);
		$data['judul'] = 'Karyawan';
		$data['isi'] = 'Tambah Data karyawan';
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$tmp['content'] = $this->load->view('backoffice/karyawan/tambah_karyawan', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Insert_karyawan()
	{

		$sess_data['email_kar'] = $this->input->post('email_karyawan');
		$sess_data['outlet_kar'] = $this->input->post('outlet');
		$sess_data['nama_kar'] = $this->input->post('nama_karyawan');
		$sess_data['username'] = $this->input->post('username');
		$sess_data['role_kar'] = $this->input->post('role');
		$sess_data['telp_kar'] = $this->input->post('telp');
		$this->session->set_userdata($sess_data);

		$whr = array('email_user' => $this->input->post('email_karyawan'), 'del' => 1);
		$cek = $this->data_model->Count_where('user', $whr);


		if ($cek > 0) {
			$this->session->set_flashdata("message", "user-dipakai");
			redirect("backoffice/user/tambah_user", 'refresh');
		} else {
			$str = $this->input->post('email_karyawan');
			$passm5 = md5($this->input->post('password'));
			if (!$this->input->post('email_karyawan')) {
				$data = array(
					'nama_user' => $this->input->post('nama_karyawan'),
					'username' => $this->input->post('username'),
					'telp_user' => $this->input->post('telp'),
					'password' => $passm5,
					'role_user' => $this->input->post('role'),
					'idbusiness' => $this->input->post('id_business'),
					'idoutlet' => $this->input->post('outlet'),
					'kode_user' => $this->input->post('kode_karyawan'),
					'del' => '1',
					'status_user' => '1',
				);

				$this->data_model->insert_something('user', $data);
			} else {
				$data = array(
					'nama_user' => $this->input->post('nama_karyawan'),
					'username' => $this->input->post('username'),
					'telp_user' => $this->input->post('telp'),
					'email_user' => strtolower($str),
					'password' => $passm5,
					'role_user' => $this->input->post('role'),
					'idbusiness' => $this->input->post('id_business'),
					'idoutlet' => $this->input->post('outlet'),
					'kode_user' => $this->input->post('kode_karyawan'),
					'del' => '1',
					'status_user' => '0',
				);

				$this->data_model->insert_something('user', $data);
			}


			$hui['email'] = $this->input->post('email_karyawan');
			$hui['username'] = $this->input->post('username');
			$hui['password'] = $this->input->post('password');
			$hui['kode'] = $this->input->post('kode_karyawan');
			$hui['role'] = $this->input->post('role');
			$email = $this->input->post('email_karyawan');
			$message = $this->load->view('backoffice/karyawan/email_karyawan', $hui, TRUE);
			require_once(APPPATH . "third_party/phpmailer/PHPMailerAutoload.php");
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'aioposapps@gmail.com';
			$mail->Password = '1234Aiopos';
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->setFrom('aioposapps@gmail.com', 'AIO POS');
			$mail->addAddress($email);
			$mail->isHTML(true);
			$mail->AddEmbeddedImage(FCPATH . "assets/group2.png", 'logo_up');
			$mail->Subject = 'Konfirmasi Registrasi';

			$mail->MsgHTML(stripslashes($message));
			$mail->send();

			$this->session->unset_userdata('email_kar');
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('nama_kar');
			$this->session->unset_userdata('role_kar');
			$this->session->unset_userdata('telp_kar');
			$this->session->unset_userdata('outlet_kar');

			$this->session->set_flashdata('message', "modal-success");
			redirect("backoffice/user");
		}
	}

	public function Edit_karyawan($id = 0)
	{
		$data['judul'] = 'Karyawan';
		$data['isi'] = 'Edit Data karyawan';
		$ai = $this->my_encrypt->decode($id);
		$daa = array('iduser' => $ai);
		$data['karyawan'] = $this->data_model->getsomething('user', $daa);
		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$tmp['content'] = $this->load->view('backoffice/karyawan/edit_karyawan', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function Update_karyawan()
	{
		if (!$this->input->post('password')) {
			$data = array(
				'nama_user' => $this->input->post('nama_karyawan'),
				'username' => $this->input->post('username'),
				'telp_user' => $this->input->post('telp'),
				'idoutlet' => $this->input->post('outlet'),
				'email_user' => $this->input->post('email_karyawan'),
				'role_user' => $this->input->post('role')
			);
			$this->data_model->update_something('user', $data, $this->input->post('id_karyawan'), 'iduser');
			$this->session->set_flashdata('message', "modal-success");
			redirect("backoffice/user");
		} else {
			$passm5 = md5($this->input->post('password'));
			$data = array(
				'nama_user' => $this->input->post('nama_karyawan'),
				'username' => $this->input->post('username'),
				'telp_user' => $this->input->post('telp'),
				'idoutlet' => $this->input->post('outlet'),
				'email_user' => $this->input->post('email_karyawan'),
				'role_user' => $this->input->post('role'),
				'password' => $passm5
			);
			$this->data_model->update_something('user', $data, $this->input->post('id_karyawan'), 'iduser');
			$this->session->set_flashdata('message', "modal-success");
			redirect("backoffice/user");
		}
	}

	public function Delete()
	{
		$id_user = $this->input->post('id_karyawan');
		$data = array('del' => 0);
		$this->data_model->update_something('user', $data, $id_user, 'iduser');
		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/user");
	}

	public function Delete_batch()
	{
		$json = $this->input->post('id_karyawans');
		$id_karyawan = array();

		if (strlen($json) > 0) {
			$id_karyawan = json_decode($json);
		}

		if (count($id_karyawan) > 0) {
			$id_karyawan_str = "";
			$id_karyawan_str = implode(',', $id_karyawan);

			$sql = "UPDATE user SET user.del=0 WHERE user.iduser IN (" . $id_karyawan_str . ") ";
			$this->db->query($sql);

			$this->session->set_flashdata('message', "modal-success");
			redirect("backoffice/user");
		}
	}

	public function cekUsrExist($action, $ids_karyawan = null)
	{
		$usr = $this->input->post('username');
		if ($action == 'tambah_user') {

			$whr = array(
				'username' => $usr,
			);
			$is_exist = $this->db->get_where('user', $whr);
			if ($is_exist->num_rows() > 0) {
				echo 'false';
			} else {
				echo 'true';
			}
		} else {
			$this->db->where_not_in('iduser', $ids_karyawan);
			$this->db->where('username', $usr);
			$is_exist = $this->db->get('user');
			if ($is_exist->num_rows() > 0) {
				echo 'false';
			} else {
				echo 'true';
			}
		}
	}

	public function Export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();

		$excel->getProperties()->setCreator('Ultrapos')
			->setLastModifiedBy('Ultrapos')
			->setTitle("Data Karyawan")
			->setSubject("Karyawan")
			->setDescription("Laporan Data Karyawan")
			->setKeywords("Data Karyawan");

		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$style_row = array(
			'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KARYAWAN");
		$excel->getActiveSheet()->mergeCells('A1:E1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Telp");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Username");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "Role");
		//$excel->setActiveSheetIndex(0)->setCellValue('F3', "Outlet");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		$www = array('idbusiness' => $this->session->userdata('id_business'), 'del' => 1);
		$register = $this->data_model->getsomething('user', $www);

		$no = 1;
		$numrow = 4;
		foreach ($register as $data) :

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_user);
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->telp_user);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->username);

			$daa = $data->role_user;
			$role = '';
			if ($daa == '1') {
				$role = "Owner";
			} elseif ($daa == '2') {
				$role = "Backofficer";
			} else {
				$role = "Kasir";
			}

			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $role);

			/*
            $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$data->idoutlet'");
            foreach ($query->result_array() as $rw) $outlet=$rw['name_outlet'];
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $outlet);
            */

			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		endforeach;


		//$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		foreach (range('A', 'E') as $columnID) :
			$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		endforeach;

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Data Karyawan");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data User.xlsx"');
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		$write->save('php://output');
	}
}
