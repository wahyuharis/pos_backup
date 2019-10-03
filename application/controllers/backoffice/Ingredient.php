<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredient extends CI_Controller {

	private $id_business = "";
	private $numbering_row = 0;
    
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('stok') == 2) {
            $this->pakai_stok = true;
        }

        $this->security_model->loggedin_check();
        $this->load->helper('haris_helper');

        $this->id_business = $this->session->userdata('id_business');
        $this->type_business = $this->session->userdata('type_bus');
	}

	public function json()
	{
		$this->db->select('idingredient as id, nama_ingredient as text');
		$this->db->from('ingredient');
		$this->db->where('status_ingredient', 1);
		$this->db->where('idbusiness', $this->session->userdata('id_business'));
		$data = $this->db->get()->result();

		$select2 = array(
	      'results' => $data,
      );
      header('Content-Type: application/json');
      echo json_encode($select2);


	}

	public function index()
	{
		$data['judul'] = 'Ingredient';
		$data['isi'] = 'Manajemen Data Ingredient';

		$this->db->where('idbusiness', $this->id_business);
		$kategori = $this->db->get('ingredient_kategori')->result_array();

		$this->db->where('idbusiness', $this->id_business);
		$outlet = $this->db->get('outlet')->result_array();

		$data['opt_kategori'] = array();
		$data['opt_kategori'] = create_dropdown_array($kategori, 'idkatingredient', 'nama_kategori');
		$data['opt_kategori'][''] = "Pilih Kategori"; //unselect option


		// $data['opt_outlet'] = array();
		// $data['opt_outlet'] = create_dropdown_array($outlet, 'idoutlet', 'name_outlet');
		// $data['opt_outlet'][''] = "Pilih Outlet"; 


		$table_header = array();

		$table_header = array(
		   // '<label><input type="checkbox" name="cb-all" > #</label>',
         'No',
         'kategori',
         // 'Outlet',
         'Nama ingredient',
         'unit',
         'Harga (per unit)',
         'Status',
         'Action',
		);

		$data['table_header'] = $table_header;


		$tmp['content'] = $this->load->view('backoffice/ingredient/ingredient', $data, true);
		$this->load->view('backoffice/template', $tmp);		
	}

	private function sql() {
		$result = array();

		$sql = "select 
		a.idingredient,
		b.nama_kategori,
		a.nama_ingredient,
		e.nama_unit,
		a.harga as harga, 
		a.status_ingredient,
		'' as `action`
		from ingredient a
		left join ingredient_kategori b on b.idkatingredient=a.idkatingredient
		left join rel_ingredient c on c.idingredient=a.idingredient
		left join outlet d on d.idoutlet=c.idoutlet
		left join unit e on e.idunit=a.idunit

		where 
		a.idbusiness=" . $this->id_business . "
		and a.status_ingredient=1 ";

		if (!empty($this->input->get('kategori'))) {
		   $sql .= " and a.idkatingredient = "
		           . "" . $this->db->escape($this->input->get('kategori')) . "  ";
		}

		if (!empty($this->input->get('ingredient'))) {
		   $sql .= " and a.nama_ingredient like  '%" . $this->db->escape_str($this->input->get('ingredient')) . "%' ";
		}

		// if (!empty($this->input->get('outlet'))) {
		//    $sql .= " and d.idoutlet = '" . $this->db->escape_str($this->input->get('outlet')) . "' ";
		// }

		$sql .= " group by a.idingredient ";

		$result = $this->db->query($sql)->result_array();

		return $result;
	}

	private function callback_column($key, $col, $row) {

        if ($key == 'idingredient') {
            $this->numbering_row = $this->numbering_row + 1;
            $col = $this->numbering_row;
        }

        if ($key == 'action') {
            $col = '';
            $col .= '<a href="' . base_url() . 'backoffice/ingredient/edit_ingredient/' . $row['idingredient'] . '" '
                    . ' class="btn btn-default btn-xs">Edit</a>';

            $col .= '<a href="#" '
                    . ' class="btn btn-danger btn-xs" '
                    . ' onclick="delete_validation(' . $row['idingredient'] . ')" >Hapus</a>';
        }
        if ($key == 'status_ingredient') {
            if ($col > 0) {
                $col = '<div class="label label-primary">ACTIVE</div>';
            } else {
                $col = '<div class="label label-default">NOT ACTIVE</div>';
            }
        }

        $this->db->where('idingredient', $row['idingredient']);
        $this->db->order_by('idingredient', 'desc');
        // $this->db->order_by('idvariant', 'asc');
        // $variant_data = $this->db->get('variant')->result_array();
        // if ($key == 'variant') {
        //     $col = "";

        //     foreach ($variant_data as $row_variant) {
        //         $col .= '<div class="multi-row" >';
        //         $col .= $row_variant['nama_variant'];
        //         $col .= '</div>';
        //     }
        // }


        // if ($key == 'sku') {
        //     $col = "";
        //     if (count($variant_data) > 0) {
        //         foreach ($variant_data as $row_sku) {
        //             $col .= '<div class="multi-row" >';
        //             $col .= $row_sku['sku'];
        //             $col .= '</div>';
        //         }
        //     } else {
        //         $col .= '<div class="multi-row" >';
        //         $col .= $row['sku'];
        //         $col .= '</div>';
        //     }
        // }

        // if ($key == 'harga') {
        //     $col = "";
        //     if (count($variant_data) > 0) {
        //         $col = "";
        //         foreach ($variant_data as $row_variant) {
        //             $col .= '<div  class="multi-row text-right" >';
        //             $harga = 0;
        //             if ($this->pakai_stok) {
        //                 $harga = $this->harga_variant_pakai_stok($row_variant['idproduk'], $row_variant['idvariant']);
        //             } else {
        //                 $harga = $row_variant['harga'];
        //             }
        //             $col .= number_format(intval($harga), 2);
        //             $col .= '</div>';
        //         }
        //     } else {
        //         $col .= '<div  class="multi-row text-right" >';
        //         $harga = 0;
        //         if ($this->pakai_stok) {
        //             $harga = $this->harga_barang_pakai_stok($row['idproduk']);
        //         } else {
        //             $harga = $row['harga'];
        //         }
        //         $col .= number_format(intval($harga), 2);
        //         $col .= '</div>';
        //     }
        // }

        if ($key == 'harga') {
        		$col= '';

        		$col .= nominal($row['harga'], 2);	
        }

        // if ($key == 'outlet') {
        //     $col = "";
        //     $sql = "select outlet.name_outlet from
        //     outlet join rel_ingredient
        //     on rel_ingredient.idoutlet=outlet.idoutlet
        //     where rel_ingredient.idingredient=" . $this->db->escape($row['idingredient']) . " ";
        //     $outlet_data = $this->db->query($sql)->result_array();
        //     foreach ($outlet_data as $row_outlet) {
        //         $col .= '<a href="#" class="btn btn-primary btn-xs">' . $row_outlet['name_outlet'] . '</a>';
        //     }
        // }

        // if ($key == 'checkbox') {
        //     $col = '<input type="checkbox" name="ingredient-cb" class="list-checkbox" value="' . $row['idingredient'] . '" >';
        // }

        return $col;
    }

    private function callback_column_excel($key, $col, $row) {
        if ($key == 'idingredient') {
            $this->numbering_row = $this->numbering_row + 1;
            $col = $this->numbering_row;
        }

        if ($key == 'action') {
            $col = '';
        }
        if ($key == 'status_produk') {
            if ($col > 0) {
                $col = 'ACTIVE';
            } else {
                $col = 'NOT ACTIVE';
            }
        }

        // if ($key == 'outlet') {
        //     $col = "";
        //     $sql = "select outlet.name_outlet from
        //     outlet join rel_ingredient
        //     on rel_ingredient.idoutlet=outlet.idoutlet
        //     where rel_ingredient.idingredient=" . $this->db->escape($row['idingredient']) . " ";
        //     $outlet_data = $this->db->query($sql)->result_array();
        //     foreach ($outlet_data as $row_outlet) {
        //         $col .= '' . $row_outlet['name_outlet'] . ',';
        //     }
        // }

        // if ($key == 'sku') {
        //     $col = "";
        // }

        // if ($key == 'harga') {
        //     $col = '';
        // }

        return $col;
    }

    public function datatables() {
        $result = $this->sql();

        $datatables_format = array(
            'data' => array(),
        );

        foreach ($result as $row) {
            $buffer = array();
            foreach ($row as $key => $col) {
                $col = $this->callback_column($key, $col, $row);
                array_push($buffer, $col);
            }
            array_push($datatables_format['data'], $buffer);
        }
        header('Content-Type: application/json');
        echo json_encode($datatables_format);
    }

	public function Tambah_ingredient() {
		$data['judul'] = 'Ingredient';
		$data['isi'] = 'Tambah Data Ingredient';

		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$wh2 = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);
		$wh3 = array('status'=> 1);
		$data['units'] = $this->data_model->getsomething('unit', $wh3);
		// $data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$data['units'] = $this->db->get('unit')->result();
		$data['comkat'] = $this->data_model->getsomething('ingredient_kategori', $wh2);
		$tmp['content'] = $this->load->view('backoffice/ingredient/tambah_ingredient', $data, true);
		$tmp['js_files'] = array(
		   'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
		   'https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js',
		);
		$this->load->view('backoffice/template', $tmp);
	}

	public function insert_ingredient()
	{

		$nama_ingredient = $this->input->post('nama_ingredient');
		$idkatingredient = $this->input->post('kategori');
		$idbusiness = $this->input->post('id_business');
		// $outlet = $this->input->post('outlet');
		$idunit = $this->input->post('unit');
		$stok = $this->input->post('stok');
		$harga = floatval2($this->input->post('harga'));

		$data_ingredient = array(
			'idbusiness' => $idbusiness, 
			'idkatingredient' => $idkatingredient, 
			'idunit' => $idunit, 
			'nama_ingredient' => $nama_ingredient,
			'harga' => $harga,
		);

		$nama = date('Y_m_d_h_i_s') . uniqid();
		$config['upload_path'] = "picture/ingredient"; // lokasi penyimpanan file
		$config['allowed_types'] = 'gif|jpg|png|JPEG'; // format foto yang diizinkan 
		$config['file_name'] = $nama;
		$this->upload->initialize($config);

		$nama_foto = "";
		if ($this->upload->do_upload('foto_ingredient')) {
		   $gbr = $this->upload->data();
		   $nama_foto = $gbr['file_name'];

		   $this->load->library("Image_moo");
		   $image_moo = new Image_moo();
		   $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
		   $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(100, 100, true)->save($gbr['full_path'], true);
		} 
		// else {
		//    $message .= "Peringatan Upload Gambar peringatan (Tidak Wajib Di isi)";
		//    $message .= $this->upload->display_errors() . "";
		// }

	   if (strlen($nama_foto) > 0) {
			$data_ingredient['foto_ingredient'] = $nama_foto;
		}
		$this->db->insert('ingredient', $data_ingredient);
	   $insert_id = $this->db->insert_id();

	 	// insert stok ke stok_ingredient
	  	$data_stok = array(
	  		'idingredient' => $insert_id,
	  		'awal' => $stok,
	  		'total' => $stok,
	  		'tanggal' => date('Y-m-d')
	  	);
	  	$this->db->insert('ingredient_stok', $data_stok);


      // echo json_encode($data_ingredient);die();


		// $rel_ingredient_db = array();
  //  	foreach ($outlet as $id_outlet) {
		// 	$rel_ing = array();

		// 	$rel_ing['idoutlet'] = $id_outlet;
		// 	$rel_ing['idingredient'] = $insert_id;


		// 	array_push($rel_ingredient_db, $rel_ing);

		// }

		// $this->db->insert_batch('rel_ingredient', $rel_ingredient_db);

		$this->session->set_flashdata('message', "modal-success");
     	redirect("backoffice/ingredient");
	}

	public function Edit_ingredient($id) {
		$data['judul'] = 'Ingredient';
		$data['isi'] = 'Edit Data Ingredient';

		$wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
		$wh2 = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);
		$wh3 = array('status'=> 1);
		$whIng = array('idingredient' => $id);
		// $data['comout'] = $this->data_model->getsomething('outlet', $wh);
		$data['ingredient']=$this->data_model->getsomething('ingredient',$whIng);
		$data['units'] = $this->data_model->getsomething('unit', $wh3);
		$data['comkat'] = $this->data_model->getsomething('ingredient_kategori', $wh2);
		$data['stok'] = $this->db->get_where('ingredient_stok', $whIng, 1)->result();
		$tmp['content'] = $this->load->view('backoffice/ingredient/edit_ingredient', $data, true);
		$tmp['js_files'] = array(
		   'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
		   'https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js',
		);
		$this->load->view('backoffice/template', $tmp);
	}

	public function update_ingredient()
	{
		$idingredient = $this->input->post('idingredient');
		$nama_ingredient = $this->input->post('nama_ingredient');
		$idkatingredient = $this->input->post('kategori');
		$idbusiness = $this->input->post('id_business');
		$outlet = $this->input->post('outlet');
		$idunit = $this->input->post('unit');
		$stok = $this->input->post('stok');
		$harga = floatval2($this->input->post('harga'));

		$data_ingredient = array(
			'idbusiness' => $idbusiness, 
			'idkatingredient' => $idkatingredient, 
			'idunit' => $idunit, 
			'nama_ingredient' => $nama_ingredient, 
			'harga' => $harga, 
		);

		$nama = date('Y_m_d_h_i_s') . uniqid();
		$config['upload_path'] = "picture/ingredient"; // lokasi penyimpanan file
		$config['allowed_types'] = 'gif|jpg|png|JPEG'; // format foto yang diizinkan 
		$config['file_name'] = $nama;
		$this->upload->initialize($config);

		// delete gambar lama sebelum diupdate
		$ings = $this->db->get_where('ingredient', ['idingredient' =>$idingredient ]);
		if (empty($ings->row()->foto_ingredient)) {
			$old = 'picture/ingredient/'.$ings->row()->foto_ingredient;
			if (file_exists($old)) {
				unlink($old);
			}
		}

		$nama_foto = "";
		if ($this->upload->do_upload('foto_ingredient')) {
		   $gbr = $this->upload->data();
		   $nama_foto = $gbr['file_name'];

		   $this->load->library("Image_moo");
		   $image_moo = new Image_moo();
		   $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
		   $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(100, 100, true)->save($gbr['full_path'], true);
		} 
		// else {
		//    $message .= "Peringatan Upload Gambar peringatan (Tidak Wajib Di isi)";
		//    $message .= $this->upload->display_errors() . "";
		// }

	   if (strlen($nama_foto) > 0) {
			$data_ingredient['foto_ingredient'] = $nama_foto;
		}

		$this->db->update('ingredient', $data_ingredient, ['idingredient' => $idingredient]);

		$getstoking= $this->db->get_where('ingredient_stok', ['idingredient' => $idingredient]);

		$stokakhir = $getstoking->row()->total - $getstoking->row()->awal; 

	   // insert stok ke stok_ingredient
	  	$data_stok = array(
	  		'idingredient' => $idingredient,
	  		'awal' => $stok,
	  		'total' => $stokakhir + $stok,
	  	);
	  	$this->db->update('ingredient_stok', $data_stok, ['idingredient' =>$idingredient]);

      // echo json_encode($data_ingredient);die();


	 //  	$hapus = array('idingredient' => $idingredient);
		// $this->data_model->delete_something('rel_ingredient', $hapus);
		// $this->data_model->delete_something('ingredient_stok', $hapus);

		// $rel_ingredient_db = array();
  //     	foreach ($outlet as $id_outlet) {
		// 	$rel_ing = array();

		// 	$rel_ing['idoutlet'] = $id_outlet;
		// 	$rel_ing['idingredient'] = $idingredient;


		// 	// insert stok ke stok_ingredient
		//   	$data_stok = array(
		//   		'idingredient' => $idingredient,
		//   		'awal' => $stok,
		//   		'total' => $stok,
		//   		'harga' =>$harga,
		//   		'idoutlet' => $id_outlet,
		//   		'tanggal' => date('Y-m-d')
		//   	);
		//   	$this->db->insert('ingredient_stok', $data_stok);

		// 	array_push($rel_ingredient_db, $rel_ing);
		// }
		// $this->db->insert_batch('rel_ingredient', $rel_ingredient_db);

		$this->session->set_flashdata('message', "modal-success");
     	redirect("backoffice/ingredient");
	}

	public function delete()
	{
		$id = $this->input->post('idingredient');
		$data = array('status_ingredient' => 0);
		$data2 = array('status' => 0);

		$this->data_model->Update_something('ingredient',$data,$id,'idingredient');
		$this->data_model->Update_something('rel_ingredient',$data2,$id,'idingredient');
		$this->data_model->Update_something('ingredient_stok',$data2,$id,'idingredient');
		$this->session->set_flashdata('message', "modal-success");
     	redirect("backoffice/ingredient");
	}

	public function export_excel() {
     include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
     $excel = new PHPExcel();

     $excel->getProperties()->setCreator('AIO Pos')
             ->setLastModifiedBy('AIO Pos')
             ->setTitle("Data Ingredient")
             ->setSubject("Ingredient")
             ->setDescription("Laporan Data Ingredient")
             ->setKeywords("Data Ingredient");

     $style_col = array(
         'font' => array('bold' => true),
         'alignment' => array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
         'borders' => array(
             'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

     $style_row = array(
         'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
         'borders' => array(
             'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
             'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

     $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA INGREDIENT");
     $excel->getActiveSheet()->mergeCells('A1:E1');
     $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
     $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
     $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

     $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
     $excel->setActiveSheetIndex(0)->setCellValue('B3', "Kategori");
     $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Ingredient");
     $excel->setActiveSheetIndex(0)->setCellValue('D3', "Unit");
     $excel->setActiveSheetIndex(0)->setCellValue('E3', "Harga (per unit)");

     $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
     $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
     $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
     $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
     $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

     $register = $this->sql();

     $no = 1;
     $numrow = 4;
     foreach ($register as $data):

         $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
         $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['nama_kategori']);
         $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama_ingredient']);
         $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['nama_unit']);
         $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['harga']);

         

         $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
         $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
         $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
         $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
         $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
         

         $no++;
         $numrow++;
     endforeach;

     foreach (range('A', 'E') as $columnID):
         $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
     endforeach;

     $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

     $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

     $excel->getActiveSheet(0)->setTitle("Laporan Data Ingredient");
     $excel->setActiveSheetIndex(0);

     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     header('Content-Disposition: attachment; filename="Laporan Data Ingredient.xlsx"');
     header('Cache-Control: max-age=0');

     $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
     $write->save('php://output');
	}


}
