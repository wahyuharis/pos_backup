<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredient_stok extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->security_model->loggedin_check();
	}

	public function index() {
		$data['judul'] = 'Ingredient Stok';
		$data['isi'] = 'Manajemen Data Ingredient Stok';

		$daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);

		$this->db->select('
			s.idstok, ingredient.nama_ingredient,s.awal,s.masuk,s.pake,s.total,s.tanggal'
		);
		$this->db->from('ingredient_stok s');
		$this->db->join('ingredient', 'ingredient.idingredient = s.idingredient', 'left');
		$this->db->where('ingredient.status_ingredient', 1);
		$this->db->order_by('s.tanggal', 'desc');
		$this->db->order_by('s.idstok', 'desc');
		$ingredient_stok =$this->db->get()->result();

		$data['ingredient_stok'] = $ingredient_stok;

		$tmp['content'] = $this->load->view('backoffice/ingredient_stok/stok', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function sql() {
        $tanggal_input = date('01/m/Y') . " - " . date('t/m/Y');
        $ingredient = $this->input->get('ingredient');

        if (!empty($this->input->get('tanggal'))) {
            $tanggal_input = $this->input->get('tanggal');
        }

        $tanggal_buffer = explode("-", $tanggal_input);

        // $idoutlet = $this->input->get('idoutlet');
        $tanggal_start = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[0]))->format('Y-m-d') . " 00:00";
        $tanggal_end = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[1]))->format('Y-m-d') . " 23:59";

        $sql = "
        select ingredient.nama_ingredient,s.awal,s.masuk,s.pake,s.total,s.tanggal
				from ingredient_stok s
				left join ingredient on ingredient.idingredient = s.idingredient
				WHERE ingredient.status_ingredient=1";

			if (!empty($this->input->get('ingredient'))) {
			   $sql .= " and ingredient.nama_ingredient like  '%" . $this->db->escape_str($this->input->get('ingredient')) . "%' ";
			}

			$sql.=' ORDER BY s.tanggal DESC, s.idstok DESC';

        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    private function callback_collumn($key, $col, $row) {
    	// if ($key == 'idstok') {
     //        $this->numbering_row = $this->numbering_row + 1;
     //        $col = $this->numbering_row;
     //    }
    	// $col='';
        // if ($key == 'tanggal') {
        //     if (strlen($col) > 10) {
        //         $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
        //     } else {
        //         $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
        //     }
        // }

    	 // if ($key == 'tanggal') {
      //       if (strlen($col) > 10) {
      //           $col = DateTime::createFromFormat('Y-m-d H:i:s', trim($col))->format('d/m/Y');
      //       } else {
      //           $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
      //       }
      //   }

        return $col;
    }

    public function datatables() {
        $result = $this->sql();

        $datatables_format = array(
            'data' => array(),
        );

        $i = 1;
        foreach ($result as $row) {
            $buffer = array();
            foreach ($row as $key => $col) {
                $col = $this->callback_collumn($key, $col, $row);
                array_push($buffer, $col);
            }
            array_push($datatables_format['data'], $buffer);

            $i++;
        }
        header('Content-Type: application/json');
        echo json_encode($datatables_format);
    }

	public function Tambah_stok() {
	  $data['judul'] = 'Ingredient Stok';
	  $data['isi'] = 'Manajemen Data Ingredient Stok';
	  $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
	  
	  $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);

	  // $data['ingredient'] = $this->data_model->Getsomething('ingredient',['idingredient' => 1]);

	  $this->db->where('idbusiness', $this->session->userdata('id_business'));

	  $tmp['js_files'] = array(
	      'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
	  );

	  $tmp['css_files'] = array(
	      'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
	  );

	  $tmp['content'] = $this->load->view('backoffice/ingredient_stok/tambah_stok', $data, true);
	  $this->load->view('backoffice/template', $tmp);
	}

	public function insert()
	{
		$ingredient = $this->input->post('ingredient');
		$qty = $this->input->post('qty');
		
		$this->db->where('idingredient', $ingredient);
		$this->db->where('status', 1);
		$ingStok = $this->db->get('ingredient_stok')->row();

		$stok_masuk = (int)$ingStok->masuk;

		$stok_total =(int)$ingStok->total;

		$data = array(
			'masuk' =>$qty + $stok_masuk,
			'total' => $qty + $stok_total ,
			'tanggal' => date('Y-m-d')
		);

		$this->db->update('ingredient_stok', $data, ['idingredient'=>$ingredient]);

		$this->session->set_flashdata('message',"modal-success");
		redirect("backoffice/ingredient_stok");
		
	}

}

/* End of file Ingredient_stok.php */
/* Location: ./application/controllers/Ingredient_stok.php */
