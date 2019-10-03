<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resep extends CI_Controller {
	private $idbusiness;

	public function __construct()
	{
		parent::__construct();
		$this->idbusiness = $this->session->userdata('id_business');
		$this->security_model->loggedin_check();
	}

	public function index() {
		$data['judul'] = 'Ingredient Stock';
		$data['isi'] = 'Manajemen Data Ingredient Stock';

		$this->db->select('produk.idproduk,produk.nama_produk, variant.nama_variant');
		$this->db->from('recipes');
		$this->db->join('produk', 'produk.idproduk = recipes.idproduk', 'left');
		$this->db->join('variant', 'variant.idvariant = recipes.idvariant', 'left');
		$this->db->where('recipes.status', 1);
		$this->db->where('recipes.idbusiness', $this->idbusiness);
		$this->db->order_by('recipes.idrecipes', 'desc');
		$this->db->group_by('recipes.idproduk');
		$recipes = $this->db->get();

		$data['recipes'] = $recipes->result();
		$data['count'] = $recipes->num_rows();
		$tmp['content'] = $this->load->view('backoffice/resep/resep', $data, true);
		$this->load->view('backoffice/template', $tmp);
	}

	public function tambah_resep()
	{
		$data['judul'] = 'Resep';
	  $data['isi'] = 'Manajemen Data Resep';
	  $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
	  
	  $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);

	  // $data['ingredient'] = $this->data_model->Getsomething('ingredient',['idingredient' => 1]);

	  $this->db->where('idbusiness', $this->session->userdata('id_business'));

	  $tmp['js_files'] = array(
	      'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js',
	      'https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js',
	  );

	  $tmp['css_files'] = array(
	      'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
	  );

	  $tmp['content'] = $this->load->view('backoffice/resep/tambah_resep', $data, true);
	  $this->load->view('backoffice/template', $tmp);
	}

	public function insert()
	{
		$idproduk = $this->input->post('idproduk');
		$idvariant = $this->input->post('idvariant');

		$idingredient = $this->input->post('idingredient');
		$qty = $this->input->post('qty');

		$data = array();
		foreach ($idingredient as $key => $iding) {
			$d = array(
				'idbusiness' => $this->idbusiness,
				'idproduk' => $idproduk,
				'idvariant' => $idvariant,
				'idingredient' => $iding,
				'qty' => $qty[$key],
			);
			// foreach ($qty as $q) {
			// }

			array_push($data, $d);
			
		}
		$this->db->insert_batch('recipes', $data);

		$this->session->set_flashdata('message', "modal-success");
		redirect("backoffice/resep");

		// echo json_encode($data);

	}


	public function get_produk_toJSON()
	{
		$this->db->select('idproduk as id, nama_produk as text');
		$this->db->from('produk');
		$this->db->where('status_produk', 1);
		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$data = $this->db->get()->result();

		$select2 = array(
	      'results' => $data,
      );
      header('Content-Type: application/json');
      echo json_encode($select2);
	}

	public function get_variant_toJSON($idproduk)
	{
		$this->db->select('idvariant as id, nama_variant as text');
		$this->db->from('variant');
		$this->db->where('idproduk', $idproduk);
		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$this->db->where('status', 1);
		$data = $this->db->get()->result();

		$select2 = array(
	      'results' => $data,
      );
      header('Content-Type: application/json');
      echo json_encode($select2);
	}

	public function get_ingredient_toJSON()
	{
		$this->db->select('idingredient as id, nama_ingredient as text');
		$this->db->from('ingredient');
		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$this->db->where('status_ingredient', 1);
		$data = $this->db->get()->result();

		$select2 = array(
	      'results' => $data,
      );
      header('Content-Type: application/json');
      echo json_encode($select2);
	}

}

/* End of file Resep.php */
/* Location: ./application/controllers/Resep.php */
