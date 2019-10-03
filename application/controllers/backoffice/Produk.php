<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk extends CI_Controller
{
    private $id_business = "";
    private $type_business = "";
    private $numbering_row = 0;
    private $pakai_stok = false;

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

    private function orderby()
    {
        $array = array(
            1 => 'produk.idproduk',
            2 => 'kategori.nama_kategori',
            3 => 'outlet.name_outlet',
            4 => 'produk.nama_produk',
        );

        return $array;
    }

    private function sql()
    {
        $result = array();

        $sql = "select
		'' as checkbox,
		produk.idproduk,
		kategori.nama_kategori,
		'' as outlet,
		produk.nama_produk,
		'' as variant,
		produk.sku as sku,
		'' as `mod`,
		produk.harga as harga,
		produk.status_produk,
		'' as `action`
		from produk
		left join kategori on kategori.idkategori=produk.idkategori
		left join variant on variant.idproduk=produk.idproduk
		left join rel_produk on rel_produk.idproduk=produk.idproduk
		left join outlet on outlet.idoutlet=rel_produk.idoutlet

		where
		produk.idbusiness=" . $this->id_business . "
		and produk.status_produk=1 ";

        if (!empty($this->input->get('kategori'))) {
            $sql .= " and produk.idkategori = "
                . "" . $this->db->escape($this->input->get('kategori')) . "  ";
        }

        if (!empty($this->input->get('produk'))) {
            $sql .= " and produk.nama_produk like  '%" . $this->db->escape_str(trim($this->input->get('produk'))) . "%' ";
        }

        if (!empty($this->input->get('variant'))) {
            $sql .= " and variant.nama_variant like '%" . $this->db->escape_str(trim($this->input->get('variant'))) . "%' ";
        }

        if (!empty($this->input->get('outlet'))) {
            $sql .= "\n" . " and outlet.idoutlet = '" . $this->db->escape_str($this->input->get('outlet')) . "' ";
        }

        $sql .= "\n group by produk.idproduk ";
        foreach ($this->orderby() as $order_key => $order) {
            $order_get = $this->input->get('order');
            if (is_array($order_get) && count($order_get)) {
                if ($order_get[0]['column'] == $order_key) {
                    $sql .= "\n" . " order by " . $order . " " . $order_get[0]['dir'] . " ";
                }
            }
        }

        return $sql;
    }

    public function index()
    {
        $data['judul'] = 'Produk';
        $data['isi'] = 'Manajemen Data Produk';

        $this->db->where('idbusiness', $this->id_business);
        $this->db->where('status_kategori', 1);
        $kategori = $this->db->get('kategori')->result_array();

        $this->db->where('idbusiness', $this->id_business);
        $this->db->where('status_outlet', 1);
        $outlet = $this->db->get('outlet')->result_array();

        $data['opt_kategori'] = array();
        $data['opt_kategori'] = create_dropdown_array($kategori, 'idkategori', 'nama_kategori');
        $data['opt_kategori'][''] = "Pilih Kategori"; //unselect option

        $data['opt_outlet'] = array();
        $data['opt_outlet'] = create_dropdown_array($outlet, 'idoutlet', 'name_outlet');
        $data['opt_outlet'][''] = "Pilih Outlet"; //unselect option

        $table_header = array();

        $table_header = array(
            '<label><input type="checkbox" name="cb-all" > #</label>',
            'No',
            'kategori',
            'Outlet',
            'Nama Produk',
            'Varian',
            'SKU',
            'Modifier',
            'Harga',
            'Status',
            'Action',
        );

        $data['table_header'] = $table_header;

        $tmp['content'] = $this->load->view('backoffice/produk/produk_datatables', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    private function callback_column($key, $col, $row)
    {

        if ($key == 'idproduk') {
            $this->numbering_row = $this->numbering_row + 1;
            $col = $this->numbering_row;
        }

        if ($key == 'action') {
            $col = '';
            $col .= '<a href="' . base_url() . 'backoffice/produk/edit_produk/' . urlencode(base64_encode($row['idproduk'])) . '" '
                . ' class="btn btn-default btn-xs">Edit</a>';

            $col .= '<a href="#" '
                . ' class="btn btn-danger btn-xs" '
                . ' onclick="delete_validation(' . "'" . urlencode(base64_encode($row['idproduk'])) . "'" . ')" >Hapus</a>';
        }
        if ($key == 'status_produk') {
            if ($col > 0) {
                $col = '<div class="label label-primary">ACTIVE</div>';
            } else {
                $col = '<div class="label label-default">NOT ACTIVE</div>';
            }
        }

        $this->db->where('idproduk', $row['idproduk']);
        $this->db->where('status', '1');
        $this->db->order_by('idvariant', 'asc');
        $variant_data = $this->db->get('variant')->result_array();
        if ($key == 'variant') {
            $col = "";

            foreach ($variant_data as $row_variant) {
                $col .= '<div class="multi-row" >';
                $col .= $row_variant['nama_variant'];
                $col .= '</div>';
            }
        }

        if ($key == 'sku') {
            $col = "";
            if (count($variant_data) > 0) {
                foreach ($variant_data as $row_sku) {
                    $col .= '<div class="multi-row" >';
                    $col .= $row_sku['sku'];
                    $col .= '</div>';
                }
            } else {
                $col .= '<div class="multi-row" >';
                $col .= $row['sku'];
                $col .= '</div>';
            }
        }

        if ($key == 'harga') {
            $col = "";
            if (count($variant_data) > 0) {
                $col = "";
                foreach ($variant_data as $row_variant) {
                    $col .= '<div  class="multi-row text-right" >';
                    $harga = 0;
                    if ($this->pakai_stok) {
                        $harga = $this->harga_variant_pakai_stok($row_variant['idproduk'], $row_variant['idvariant']);
                    } else {
                        $harga = $row_variant['harga'];
                    }
                    $col .= number_format(intval($harga), 2);
                    $col .= '</div>';
                }
            } else {
                $col .= '<div  class="multi-row text-right" >';
                $harga = 0;
                if ($this->pakai_stok) {
                    $harga = $this->harga_barang_pakai_stok($row['idproduk']);
                } else {
                    $harga = $row['harga'];
                }
                $col .= number_format(intval($harga), 2);
                $col .= '</div>';
            }
        }

        if ($key == 'outlet') {
            $col = '<div style="width:200px">';
            $sql = "select outlet.name_outlet from
			outlet join rel_produk
			on rel_produk.idoutlet=outlet.idoutlet
			where rel_produk.idproduk=" . $this->db->escape($row['idproduk']) . " ";
            $outlet_data = $this->db->query($sql)->result_array();
            foreach ($outlet_data as $row_outlet) {
                $col .= '<a href="#" style="margin-top: 5px;" class="btn btn-primary btn-xs">' . $row_outlet['name_outlet'] . '</a>  ';
            }
            $col .= '</div>';
        }

        if ($key == 'mod') {
            $this->db->select('*');
            $this->db->from('rel_modifier');
            $this->db->where('idproduk', $row['idproduk']);
            $count_modifier = $this->db->get()->num_rows();

            $col .= '<div style="text-align:center;margin-top:10px;">';
            $col .= $count_modifier;
            $col .= '</div>';
        }

        if ($key == 'checkbox') {
            $col = '<input type="checkbox" name="produk-cb" class="list-checkbox" value="' . $row['idproduk'] . '" >';
        }

        return $col;
    }

    private function callback_column_excel($key, $col, $row)
    {

        if ($key == 'idproduk') {
            $this->numbering_row = $this->numbering_row + 1;
            $col = $this->numbering_row;
        }

        if ($key == 'action') {
            $col = '';
            $col .= '<a href="' . base_url() . 'backoffice/produk/edit_produk/' . $row['idproduk'] . '" '
                . ' class="btn btn-default btn-xs">Edit</a>';

            $col .= '<a href="#" '
                . ' class="btn btn-danger btn-xs" '
                . ' onclick="delete_validation(' . $row['idproduk'] . ')" >Hapus</a>';
        }
        if ($key == 'status_produk') {
            if ($col > 0) {
                $col = '<div class="label label-primary">ACTIVE</div>';
            } else {
                $col = '<div class="label label-default">NOT ACTIVE</div>';
            }
        }

        $this->db->where('idproduk', $row['idproduk']);
        $this->db->order_by('idvariant', 'asc');
        $variant_data = $this->db->get('variant')->result_array();
        if ($key == 'variant') {
            $col = "";

            foreach ($variant_data as $row_variant) {
                $col .= '<div class="multi-row" >';
                $col .= $row_variant['nama_variant'];
                $col .= '</div>';
                $col .= '<br>';
            }
        }

        if ($key == 'sku') {
            $col = "";
            if (count($variant_data) > 0) {
                foreach ($variant_data as $row_sku) {
                    $col .= '<div class="multi-row" >';
                    $col .= $row_sku['sku'];
                    $col .= '</div>';
                    $col .= '<br>';
                }
            } else {
                $col .= '<div class="multi-row" >';
                $col .= $row['sku'];
                $col .= '</div>';
            }
        }

        if ($key == 'harga') {
            $col = "";
            if (count($variant_data) > 0) {
                $col = "";
                foreach ($variant_data as $row_variant) {
                    $col .= '<div  class="multi-row text-right" >';
                    $harga = 0;
                    if ($this->pakai_stok) {
                        $harga = $this->harga_variant_pakai_stok($row_variant['idproduk'], $row_variant['idvariant']);
                    } else {
                        $harga = $row_variant['harga'];
                    }
                    $col .= number_format(intval($harga), 2);
                    $col .= '</div>';
                    $col .= '<br>';
                }
            } else {
                $col .= '<div  class="multi-row text-right" >';
                $harga = 0;
                if ($this->pakai_stok) {
                    $harga = $this->harga_barang_pakai_stok($row['idproduk']);
                } else {
                    $harga = $row['harga'];
                }
                $col .= number_format(intval($harga), 2);
                $col .= '</div>';
            }
        }

        if ($key == 'outlet') {
            $col = '<div style="width:200px">';
            $sql = "select outlet.name_outlet from
			outlet join rel_produk
			on rel_produk.idoutlet=outlet.idoutlet
			where rel_produk.idproduk=" . $this->db->escape($row['idproduk']) . " ";
            $outlet_data = $this->db->query($sql)->result_array();
            foreach ($outlet_data as $row_outlet) {
                $col .= '<a href="#" style="margin-top: 5px;" class="btn btn-primary btn-xs">' . $row_outlet['name_outlet'] . '</a>  ';
            }
            $col .= '</div>';
        }

        if ($key == 'mod') {
            $this->db->select('*');
            $this->db->from('rel_modifier');
            $this->db->where('idproduk', $row['idproduk']);
            $col = $this->db->get()->num_rows();
        }

        if ($key == 'checkbox') {
            $col = '<input type="checkbox" name="produk-cb" class="list-checkbox" value="' . $row['idproduk'] . '" >';
        }

        return $col;
    }

    public function datatables()
    {
        $sql = $this->sql();
        $total_row = $this->db->query("select count(*) as total from (" . $sql . ") as tb ")->row_array()['total'];

        $sql .= " limit " . intval($this->input->get('start')) . "," . intval($this->input->get('length')) . " ";
        $result = $this->db->query($sql)->result_array();

        $datatables_format = array(
            'data' => array(),
            'recordsTotal' => $total_row,
            'recordsFiltered' => $total_row,
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

    private function export_excel_hasvariant_callback($row)
    { }

    public function export_excel()
    {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=nama_filenya.xls");

        $this->load->library('table');

        $table_header = array(
            '<label><input type="checkbox" name="cb-all" > #</label>',
            'No',
            'kategori',
            'Outlet',
            'Nama Produk',
            'Varian',
            'SKU',
            'Harga',
            'Status',
            'Action',
        );

        $data = array();
        array_push($data, $table_header);

        $result = $this->db->query($this->sql())->result_array();

        foreach ($result as $row) {
            $buffer = array();
            foreach ($row as $key => $col) {
                $col = $this->callback_column_excel($key, $col, $row);
                array_push($buffer, $col);
            }
            array_push($data, $buffer);
        }

        $table = new CI_Table();
        $template = array(
            'table_open' => '<table border="1">',
        );
        $table->set_template($template);
        echo $table->generate($data);
    }

    public function Tambah_produk()
    {
        $data['judul'] = 'Produk';
        $data['isi'] = 'Tambah Data Produk';
        $data['pakai_stok'] = $this->pakai_stok;
        $data['harga_produk'] = "";
        $data['sku'] = "";
        $data['selected_item'] = "";

        $wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
        $wh2 = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);
        $wh3 = array('idbusiness' => $this->session->userdata('id_business'), 'status_modifier' => 1);
        $data['comout'] = $this->data_model->getsomething('outlet', $wh);
        $data['comkat'] = $this->data_model->getsomething('kategori', $wh2);
        $data['modifier'] = $this->data_model->getsomething('modifier', $wh3);
        $tmp['content'] = $this->load->view('backoffice/produk/add_produk_mvvm', $data, true);
        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js',
            base_url() . 'assets/jquery-ui/jquery-ui.min.js',
            base_url() . 'assets/jquery-ui/jquery-ui.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js',
        );
        $tmp['css_files'] = array(
            base_url() . '/assets/jquery-ui/jquery-ui.min.css',
            base_url() . '/assets/jquery-ui/jquery-ui.theme.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css',
        );
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_produk()
    {
        $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nama = str_shuffle($alphanum);
        $config['upload_path'] = "picture/produk"; // lokasi penyimpanan file
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|PNG|JPEG'; // format foto yang diizinkan
        $config['file_name'] = $nama;
        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_produk')) {
            $name_fot = $this->upload->file_name;

            $gbr = $this->upload->data();

            $this->load->library("Image_moo");
            $image_moo = new Image_moo();
            $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
            $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(50, 50, true)->save($gbr['full_path'], true);
        } else {
            $name_fot = "noimage.png";
        }

        $tb = $this->session->userdata('type_bus');
        if ($tb > 2) {
            $var = $this->input->post('variant');

            if ($var == "Ya") {
                $data = array(
                    'idbusiness' => $this->input->post('id_business'),
                    'nama_produk' => $this->input->post('nama_produk'),
                    'variant' => 2,
                    'idkategori' => $this->input->post('kategori'),
                    'foto_produk' => $name_fot,
                    'status_produk' => 1,
                );
                $this->data_model->insert_something('produk', $data);

                $idbis = $this->input->post('id_business');
                $napd = $this->input->post('nama_produk');
                $sel = $this->db->query("SELECT idproduk FROM produk WHERE idbusiness='$idbis' AND nama_produk='$napd'")->result();

                foreach ($sel as $rw) :
                    $id_pd = $rw->idproduk;
                endforeach;

                $out = $this->input->post('outlet');
                foreach ($out as $color) {
                    $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                    $this->data_model->insert_something('rel_produk', $dat);
                }
            } else {
                $data = array(
                    'idbusiness' => $this->input->post('id_business'),
                    'nama_produk' => $this->input->post('nama_produk'),
                    'variant' => 1,
                    'idkategori' => $this->input->post('kategori'),
                    'foto_produk' => $name_fot,
                    'status_produk' => 1,
                );
                $this->data_model->insert_something('produk', $data);

                $idbis = $this->input->post('id_business');
                $napd = $this->input->post('nama_produk');
                $sel = $this->db->query("SELECT idproduk FROM produk WHERE idbusiness='$idbis' AND nama_produk='$napd'")->result();

                foreach ($sel as $rw) :
                    $id_pd = $rw->idproduk;
                endforeach;

                $out = $this->input->post('outlet');
                foreach ($out as $color) {
                    $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                    $this->data_model->insert_something('rel_produk', $dat);
                }

                $tanggal = time();
                $waktu = "Y-m-d";
                $sekarang = date($waktu, $tanggal);
                $md = array(
                    'idproduk' => $id_pd,
                    'awal' => floatval2($this->input->post('stock_awal')),
                    'akhir' => floatval2($this->input->post('stock_awal')),
                    'harga' => floatval2($this->input->post('harga_produk')),
                    'tanggal' => $sekarang,
                    'status' => 1
                );
                $this->data_model->insert_something('stok', $md);
            }
        } else {
            $data = array(
                'idbusiness' => $this->input->post('id_business'),
                'nama_produk' => $this->input->post('nama_produk'),
                'variant' => 1,
                'harga' => floatval2($this->input->post('harga_produk')),
                'idkategori' => $this->input->post('kategori'),
                'foto_produk' => $name_fot,
                'status_produk' => 1
            );
            $this->data_model->insert_something('produk', $data);

            $idbis = $this->input->post('id_business');
            $napd = $this->input->post('nama_produk');
            $sel = $this->db->query("SELECT idproduk FROM produk WHERE idbusiness='$idbis' AND nama_produk='$napd'")->result();

            foreach ($sel as $rw) :
                $id_pd = $rw->idproduk;
            endforeach;

            $out = $this->input->post('outlet');
            foreach ($out as $color) {
                $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                $this->data_model->insert_something('rel_produk', $dat);
            }
        }

        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/produk");
    }

    public function Edit_produk($id)
    {
        $id = base64_decode(urldecode($id));

        $data['judul'] = 'Produk';
        $data['isi'] = 'Edit Data Produk';
        $wh = array('idbusiness' => $this->session->userdata('id_business'), 'status_outlet' => 1);
        $wh2 = array('idproduk' => $id);
        $wh3 = array('idbusiness' => $this->session->userdata('id_business'), 'status_kategori' => 1);

        $wh33 = array('idbusiness' => $this->session->userdata('id_business'), 'status_modifier' => 1);

        $data['produk'] = $this->data_model->getsomething('produk', $wh2);

        $this->db->where('idproduk', $id);
        $db = $this->db->get('produk');
        if ($db->num_rows() < 1) {
            redirect('backoffice/produk/');
        }
        $result = $db->row_array();

        $nama_kategori = $this->db->get_where('kategori', array('idkategori' => $result['idkategori']))->row_array()['nama_kategori'];
        $selected_item = '<option selected="true" value="' . $result['idkategori'] . '">' . $nama_kategori . '</option>';
        $data['selected_item'] = $selected_item;


        $data['produk_id'] = $id;
        $data['harga_produk'] = "";
        $data['sku'] = $data['produk'][0]->sku;

        if ($this->pakai_stok) {
            $this->db->where('idproduk', $id);
            $this->db->order_by('idstok', 'desc');
            $this->db->limit(1);
            $data_stok = $this->db->get('stok')->row_array();
            $data['harga_produk'] = $data_stok['harga'];
        } else {
            $data['harga_produk'] = $data['produk'][0]->harga;
        }

        $data['pakai_stok'] = $this->pakai_stok;

        $rel_outlet = array();
        $this->db->where('idproduk', $id);
        $this->db->where('status', 1);
        $rel_outlet = $this->db->get('rel_produk')->result();
        $data['rel_outlet'] = $rel_outlet;
        $outlet_selected = array();
        foreach ($rel_outlet as $row_outlet) {
            array_push($outlet_selected, $row_outlet->idoutlet);
        }
        $data['outlet_checked'] = $outlet_selected;

        $rel_modifier = array();
        $this->db->where('idproduk', $id);
        $rel_modifier = $this->db->get('rel_modifier')->result();
        $data['rel_modifier'] = $rel_modifier;
        $modifier_selected = array();
        foreach ($rel_modifier as $row_modifier) {
            array_push($modifier_selected, $row_modifier->idmodifier);
        }
        $data['modifier_checked'] = $modifier_selected;

        $variant_list = array();
        $this->db->where('idproduk', $id);
        $this->db->where('status', 1);
        $variant_list = $this->db->get('variant')->result_array();

        $variant_list2 = array();
        if ($this->pakai_stok) {
            foreach ($variant_list as $row) {
                $this->db->where('idproduk', $row['idproduk']);
                $this->db->where('idvariant', $row['idvariant']);
                $this->db->order_by('idstok', 'desc');
                $this->db->limit(1);
                $harga_from_stok = $this->db->get('stok')->row_array()['harga'];
                $row['harga'] = $harga_from_stok;
                array_push($variant_list2, $row);
            }
            $data['variant_list'] = $variant_list2;
        } else {
            $data['variant_list'] = $variant_list;
        }
        $data['modifier'] = $this->data_model->getsomething('modifier', $wh33);
        $data['comout'] = $this->data_model->getsomething('outlet', $wh);
        $data['comkat'] = $this->data_model->getsomething('kategori', $wh3);
        $tmp['content'] = $this->load->view('backoffice/produk/add_produk_mvvm', $data, true);
        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.0/cleave.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js',
            base_url() . 'assets/jquery-ui/jquery-ui.min.js',
            base_url() . 'assets/jquery-ui/jquery-ui.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js',
        );
        $tmp['css_files'] = array(
            base_url() . '/assets/jquery-ui/jquery-ui.min.css',
            base_url() . '/assets/jquery-ui/jquery-ui.theme.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css',
        );
        $this->load->view('backoffice/template', $tmp);
    }

    public function Update_produk()
    {
        $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nama = str_shuffle($alphanum);
        $config['upload_path'] = "picture/produk"; // lokasi penyimpanan file
        $config['allowed_types'] = 'gif|jpg|png|JPEG'; // format foto yang diizinkan
        $config['file_name'] = $nama;
        $this->upload->initialize($config);

        if ($this->session->userdata('type_bus') > 2) {
            $vari = $this->input->post('variant');

            if ($vari == 1) {
                if ($this->upload->do_upload('foto_produk')) {
                    $data = array(
                        'nama_produk' => $this->input->post('nama_produk'),
                        'idkategori' => $this->input->post('kategori'),
                        'foto_produk' => $this->upload->file_name,
                        'status_produk' => 1
                    );
                } else {
                    $data = array(
                        'nama_produk' => $this->input->post('nama_produk'),
                        'idkategori' => $this->input->post('kategori'),
                        'status_produk' => 1
                    );
                }

                $this->data_model->update_something('produk', $data, $this->input->post('id_produk'), 'idproduk');
                $id_pd = $this->input->post('id_produk');

                $Hapus1 = array('idproduk' => $id_pd);
                $this->data_model->delete_something('rel_produk', $Hapus1);

                $out = $this->input->post('outlet');
                foreach ($out as $color) {
                    $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                    $this->data_model->insert_something('rel_produk', $dat);
                }

                $tanggal = time();
                $waktu = "Y-m-d";
                $sekarang = date($waktu, $tanggal);
                $hg = floatval2($this->input->post('harga_produk'));
                $this->db->query("UPDATE stok SET harga = '$hg' WHERE idproduk = '$id_pd' AND tanggal = '$sekarang'");
            } else {
                if ($this->upload->do_upload('foto_produk')) {
                    $data = array(
                        'nama_produk' => $this->input->post('nama_produk'),
                        'idkategori' => $this->input->post('kategori'),
                        'foto_produk' => $this->upload->file_name,
                        'status_produk' => 1
                    );
                } else {
                    $data = array(
                        'nama_produk' => $this->input->post('nama_produk'),
                        'idkategori' => $this->input->post('kategori'),
                        'status_produk' => 1
                    );
                }

                $this->data_model->update_something('produk', $data, $this->input->post('id_produk'), 'idproduk');
                $id_pd = $this->input->post('id_produk');

                $Hapus1 = array('idproduk' => $id_pd);
                $this->data_model->delete_something('rel_produk', $Hapus1);

                $out = $this->input->post('outlet');
                foreach ($out as $color) {
                    $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                    $this->data_model->insert_something('rel_produk', $dat);
                }
            }
        } else {
            if ($this->upload->do_upload('foto_produk')) {
                $data = array(
                    'nama_produk' => $this->input->post('nama_produk'),
                    'idkategori' => $this->input->post('kategori'),
                    'status_produk' => 1,
                    'foto_produk' => $this->upload->file_name,
                    'harga' => floatval2($this->input->post('harga_prod')),
                );
            } else {
                $data = array(
                    'nama_produk' => $this->input->post('nama_produk'),
                    'idkategori' => $this->input->post('kategori'),
                    'status_produk' => 1,
                    'harga' => floatval2($this->input->post('harga_prod')),
                );
            }

            $this->data_model->update_something('produk', $data, $this->input->post('id_produk'), 'idproduk');
            $id_pd = $this->input->post('id_produk');

            $Hapus1 = array('idproduk' => $id_pd);
            $this->data_model->delete_something('rel_produk', $Hapus1);

            $out = $this->input->post('outlet');
            foreach ($out as $color) {
                $dat = array('idproduk' => $id_pd, 'idoutlet' => $color, 'status' => 1);
                $this->data_model->insert_something('rel_produk', $dat);
            }
        }

        $gbr = $this->upload->data();

        $this->load->library("Image_moo");
        $image_moo = new Image_moo();
        $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
        $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(50, 50, true)->save($gbr['full_path'], true);

        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/produk");
    }

    public function Delete()
    {
        $id = $this->input->post('id_produk');
        $id = base64_decode(urldecode($id));


        $data = array('status_produk' => 0);
        $data2 = array('status' => 0);
        $Hapus1 = array('idproduk' => $id);
        $this->data_model->delete_something('rel_produk', $Hapus1);
        $this->data_model->delete_something('rel_modifier', $Hapus1);
        $this->data_model->update_something('stok', $data2, $id, 'idproduk');
        $this->data_model->update_something('variant', $data2, $id, 'idproduk');
        $this->data_model->update_something('produk', $data, $id, 'idproduk');

        $this->db->where('idproduk', $this->input->post('id_produk'));
        $this->db->delete('rel_modifier');

        $this->session->set_flashdata('message', "modal-success");
        redirect("backoffice/produk");
    }

    public function delete_batch()
    {
        $json = $this->input->post('id_produks');
        $id_produks = array();

        if (strlen($json) > 0) {
            $id_produks = json_decode($json);
        }

        if (count($id_produks) > 0) {
            $id_produks_str = "";
            $id_produks_str = implode(',', $id_produks);

            $sql = "delete FROM rel_produk where rel_produk.idproduk in (" . $id_produks_str . ")";
            $this->db->query($sql);

            $sql = "UPDATE stok SET stok.`status` = 0 where stok.idproduk in (" . $id_produks_str . ") ";
            $this->db->query($sql);

            $sql = "UPDATE variant SET variant.`status` =0 where variant.idproduk in  (" . $id_produks_str . ") ";
            $this->db->query($sql);

            $sql = "UPDATE produk SET produk.status_produk=0 where produk.idproduk in (" . $id_produks_str . ") ";
            $this->db->query($sql);

            $this->session->set_flashdata('message', "modal-success");
            redirect("backoffice/produk");
        }
    }

    public function submit()
    {
        $message = "";
        $status = true;
        $data = array();
        $error_arr = array();

        $produk_id = $this->input->post('produk_id');

        $nama = date('Y_m_d_h_i_s') . uniqid();
        $config['upload_path'] = "picture/produk"; // lokasi penyimpanan file
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; // format foto yang diizinkan
        $config['file_name'] = $nama;
        $this->upload->initialize($config);

        $nama_foto = "";
        if ($this->upload->do_upload('foto_produk')) {
            $gbr = $this->upload->data();
            $nama_foto = $gbr['file_name'];

            $this->load->library("Image_moo");
            $image_moo = new Image_moo();
            $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(350, 350, true)->save($gbr['file_path'] . "/150/" . $gbr['file_name'], true);
            $image_moo->load($gbr['full_path'])->set_background_colour('#fff')->resize(100, 100, true)->save($gbr['full_path'], true);
        } else {
            //            $message .= "Peringatan Upload Gambar peringatan (Tidak Wajib Di isi)";
            //            $message .= $this->upload->display_errors() . "";
        }

        $data_produk = array(
            'idbusiness' => $this->id_business,
            'nama_produk' => $this->input->post('nama_produk'),
            'idkategori' => $this->input->post('kategori'),
            'status_produk' => 1,
        );

        if (strlen($nama_foto) > 0) {
            $data_produk['foto_produk'] = $nama_foto;
        }

        $this->load->helper('haris_helper');
        if ($this->pakai_stok) {
            $data_produk['harga'] = 0;
        } else {
            $data_produk['harga'] = floatval2($this->input->post('harga_produk'));
        }

        $stock_awal = $this->input->post('stock_awal');
        $variant_list_json = json_decode($this->input->post('variant_list_json'), true);
        $outlet = array();
        $modifier = array();

        $outlet = $this->input->post('outlet');
        if (!is_array($outlet)) {
            $outlet = array();
        }

        $modifier = $this->input->post('modifier');
        if (!is_array($modifier)) {
            $modifier = array();
        }

        if (count($outlet) < 1) {
            $status = false;
            $message .= "*Outlet Belum Dicentang<br>";
            $error_arr['outlet'] = "*Outlet Belum Dicentang<br>";
        }

        if (empty(trim($data_produk['nama_produk']))) {
            $status = false;
            $message .= "*Nama Produk Kosong<br>";
            $error_arr['nama_produk'] = "*Nama Produk Kosong<br>";
        }

        if (empty(trim($data_produk['idkategori']))) {
            $status = false;
            $message .= "*Kategori Produk Belum Dipilih<br>";
            $error_arr['idkategori'] = "*Kategori Produk Belum Dipilih<br>";
        }

        if ($this->input->post('variant') != 'Ya') {
            if (empty(trim($this->input->post('harga_produk')))) {
                $status = false;
                $message .= "*Harga Produk Kosong<br>";
                $error_arr['harga_produk'] = "*Harga Produk Kosong<br>";
            }
            if ($this->pakai_stok) {
                if (strlen(trim($produk_id)) < 1) {
                    if (empty(trim($this->input->post('stock_awal')))) {
                        $status = false;
                        $message .= "*Stok Produk Kosong<br>";
                        $error_arr['stock_awal'] = "*Stok Produk Kosong<br>";
                    }
                }
            }
        }

        if ($this->input->post('variant') == 'Ya') {
            if (count($variant_list_json) < 1) {
                $status = false;
                $message .= "*Variant Masih Kosong<br>";
                $error_arr['variant'] = "*Variant Masih Kosong, coba klik tomboh tambah dibawah<br>";
            }
        }

        //############## Validasi Variant List & Buffering #####################
        $variant_list = array();
        if ($this->input->post('variant') == 'Ya') {
            foreach ($variant_list_json as $vlist) {
                if (empty(trim($vlist['nama_variant']))) {
                    $status = false;
                    $message .= "*Nama Variant Ada Yang Kosong<br>";
                    $error_arr['variant'] = "*Nama Variant Ada Yang Kosong<br>";
                }
                if (empty(trim($vlist['harga']))) {
                    $status = false;
                    $message .= "*Harga Variant Ada Yang Kosong<br>";
                    $error_arr['variant'] = "*Harga Variant Ada Yang Kosong<br>";
                }
                if ($this->pakai_stok) {
                    if (empty(trim($vlist['id_variant']))) {
                        if (empty(trim($vlist['stok']))) {
                            $status = false;
                            $message .= "*Stok Variant Ada Yang Kosong<br>";
                            $error_arr['variant'] = "*Stok Variant Ada Yang Kosong<br>";
                        }
                    }
                }
            }
        }
        //############## Validasi Variant List & Buffering ####################

        if ($status == true && strlen(trim($produk_id)) < 1) {
            /* -------------------DATABASE--------------------------- */
            $this->load->helper('haris_helper');

            if (empty($this->input->post('sku'))) {
                $data_produk['sku'] = gen_sku('produk', 'idproduk', 'PRD');
            } else {
                $data_produk['sku'] = $this->input->post('sku');
            }

            $this->db->insert('produk', $data_produk);
            $insert_id = $this->db->insert_id();

            $variant_list_db = array();
            if ($this->input->post('variant') == 'Ya') {
                foreach ($variant_list_json as $vlist2) {
                    $buff = array(
                        'idbusiness' => $this->id_business,
                        'idproduk' => $insert_id,
                        'nama_variant' => $vlist2['nama_variant'],
                        'sku' => $vlist2['sku'],
                        'status' => 1,
                    );
                    if (!$this->pakai_stok) {
                        $buff['harga'] = floatval2($vlist2['harga']);
                    } else {
                        $buff['harga'] = 0;
                    }

                    if (empty($buff['sku'])) {
                        $buff['sku'] = gen_sku('variant', 'idvariant', 'VAR');
                    }

                    $this->db->insert('variant', $buff);
                    $inset_id_variant = $this->db->insert_id();

                    /* =================insert stok========================= */
                    if ($this->pakai_stok) {
                        foreach ($outlet as $id_outlet) {
                            $buff_stok = array(
                                'idproduk' => $insert_id,
                                'idvariant' => $inset_id_variant,
                                'idoutlet' => $id_outlet,
                                'tanggal' => date('Y-m-d H:i:s'),
                                'awal' => floatval2($vlist2['stok']),
                                'akhir' => floatval2($vlist2['stok']),
                                'harga' => floatval2($vlist2['harga']),
                                'status' => 1,
                            );
                            $this->db->insert('stok', $buff_stok);
                        }
                    }
                    /* =================insert stok========================= */
                }
            } else {
                if ($this->pakai_stok) {
                    foreach ($outlet as $id_outlet) {
                        $buff_stok = array(
                            'idproduk' => $insert_id,
                            'idvariant' => 0,
                            'idoutlet' => $id_outlet,
                            'awal' => floatval2($this->input->post('stock_awal')),
                            'akhir' => floatval2($this->input->post('stock_awal')),
                            'harga' => floatval2($this->input->post('harga_produk')),
                            'status' => 1,
                            'tanggal' => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('stok', $buff_stok);
                    }
                }
            }

            $rel_produk_db = array();
            foreach ($outlet as $id_outlet) {
                $buff_rel_produk = array();

                $buff_rel_produk['idoutlet'] = $id_outlet;
                $buff_rel_produk['idproduk'] = $insert_id;
                $buff_rel_produk['status'] = 1;

                array_push($rel_produk_db, $buff_rel_produk);
            }
            $this->db->insert_batch('rel_produk', $rel_produk_db);

            $rel_modifier_db = array();
            foreach ($modifier as $id_modifier) {
                $buff_rel_modifier = array();

                $buff_rel_modifier['idmodifier'] = $id_modifier;
                $buff_rel_modifier['idproduk'] = $insert_id;
                // $buff_rel_produk['status'] = 1;

                array_push($rel_modifier_db, $buff_rel_modifier);
            }
            if (count($rel_modifier_db) > 0) {
                $this->db->insert_batch('rel_modifier', $rel_modifier_db);
            }

            /* -------------------DATABASE---------------------- */
        }

        if ($status == true && strlen(trim($produk_id)) > 0) {
            //            $this->db->trans_start(TRUE);

            $this->load->helper('haris_helper');
            if (empty($this->input->post('sku'))) {
                $data_produk['sku'] = gen_sku('produk', 'idproduk', 'PRD');
            } else {
                $data_produk['sku'] = $this->input->post('sku');
            }

            $this->db->update('produk', $data_produk, array('idproduk' => $produk_id));

            if ($this->input->post('variant') == 'Ya') {

                $id_variants_buff = array();
                foreach ($variant_list_json as $vlist2) {
                    if (!empty(trim($vlist2['id_variant']))) {
                        array_push($id_variants_buff, $this->db->escape($vlist2['id_variant']));
                    }
                }

                if (count($id_variants_buff) > 0) {
                    $id_variant_implode = implode(',', $id_variants_buff);
                    $sql = "UPDATE `variant` SET `status`='0'
				WHERE
				variant.idproduk = " . $this->db->escape($produk_id) . "
				and
				variant.idvariant not in (" . $id_variant_implode . ")";
                    $this->db->query($sql);
                } else {
                    $this->db->where('idproduk', $produk_id);
                    $this->db->set('status', '0');
                    $this->db->update('variant');
                }

                foreach ($variant_list_json as $vlist2) {
                    $buff = array(
                        'idbusiness' => $this->id_business,
                        'idproduk' => $produk_id,
                        'nama_variant' => $vlist2['nama_variant'],
                        'sku' => $vlist2['sku'],
                        'status' => 1,
                    );
                    if (!$this->pakai_stok) {
                        $buff['harga'] = floatval2($vlist2['harga']);
                    } else {
                        $buff['harga'] = 0;
                    }

                    if (empty($buff['sku'])) {
                        $buff['sku'] = gen_sku('variant', 'idvariant', 'VAR');
                    }

                    if (empty(trim($vlist2['id_variant']))) {
                        $this->db->insert('variant', $buff);
                        $inset_id_variant = $this->db->insert_id();

                        if ($this->pakai_stok) {
                            foreach ($outlet as $id_outlet) {
                                $buff_stok = array(
                                    'idproduk' => $produk_id,
                                    'idvariant' => $inset_id_variant,
                                    'idoutlet' => $id_outlet,
                                    'tanggal' => date('Y-m-d H:i:s'),
                                    'awal' => floatval2($vlist2['stok']),
                                    'akhir' => floatval2($vlist2['stok']),
                                    'harga' => floatval2($vlist2['harga']),
                                    'status' => 1,
                                );
                                $this->db->insert('stok', $buff_stok);
                            }
                        }
                    } else {
                        $this->db->where('idproduk', $produk_id);
                        $this->db->where('idvariant', $vlist2['id_variant']);
                        $this->db->update('variant', $buff);

                        $this->db->where('idproduk', $produk_id);
                        $this->db->where('idvariant', $vlist2['id_variant']);
                        $this->db->order_by('idstok', 'desc');
                        $last_stok = $this->db->get('stok')->row_array();

                        foreach ($outlet as $id_outlet) {
                            $buff_stok = array(
                                'idproduk' => $produk_id,
                                'idvariant' => $vlist2['id_variant'],
                                'idoutlet' => $id_outlet,
                                'tanggal' => date('Y-m-d H:i:s'),
                                'awal' => $last_stok['akhir'],
                                'akhir' => $last_stok['akhir'],
                                'harga' => floatval2($vlist2['harga']),
                                'status' => 1,
                            );
                            $this->db->insert('stok', $buff_stok);
                        }
                    }
                }
            } else {
                if ($this->pakai_stok) {

                    $this->db->where('idproduk', $this->input->post('produk_id'));
                    $this->db->limit(1);
                    $this->db->order_by('idstok', 'desc');
                    $produk_row = $this->db->get('stok')->row_array();

                    foreach ($outlet as $id_outlet) {
                        $buff_stok = array(
                            'idproduk' => $produk_id,
                            'idvariant' => 0,
                            'idoutlet' => $id_outlet,
                            'awal' => floatval2($produk_row['awal']),
                            'akhir' => floatval2($produk_row['akhir']),
                            'harga' => floatval2($this->input->post('harga_produk')),
                            'status' => 1,
                            'tanggal' => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('stok', $buff_stok);
                    }
                }
            }

            // outlet
            $this->db->where('idproduk', $produk_id);
            $this->db->delete('rel_produk');
            $rel_produk_db = array();
            foreach ($outlet as $id_outlet) {
                $buff_rel_produk = array();

                $buff_rel_produk['idoutlet'] = $id_outlet;
                $buff_rel_produk['idproduk'] = $produk_id;
                $buff_rel_produk['status'] = 1;

                array_push($rel_produk_db, $buff_rel_produk);
            }
            $this->db->insert_batch('rel_produk', $rel_produk_db);
            // modifier
            $this->db->where('idproduk', $produk_id);
            $this->db->delete('rel_modifier');
            $rel_modifier_db = array();
            foreach ($modifier as $id_modifier) {
                $buff_rel_modifier = array();

                $buff_rel_modifier['idmodifier'] = $id_modifier;
                $buff_rel_modifier['idproduk'] = $produk_id;
                // $buff_rel_produk['status'] = 1;

                array_push($rel_modifier_db, $buff_rel_modifier);
            }
            if (count($rel_modifier_db) > 0) {
                $this->db->insert_batch('rel_modifier', $rel_modifier_db);
            }
            //                        $this->db->trans_complete();
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
            'error_arr' => $error_arr,
        ));
    }

    private function harga_barang_pakai_stok($idproduk)
    {
        $this->db->where('idproduk', $idproduk);
        $this->db->order_by('idstok', 'desc');
        $this->db->limit(1);
        $row = $this->db->get('stok')->row_array();
        return $row['harga'];
    }

    private function harga_variant_pakai_stok($idproduk, $idvariant)
    {
        $this->db->where('idproduk', $idproduk);
        $this->db->where('idvariant', $idvariant);
        $this->db->order_by('idstok', 'desc');
        $this->db->limit(1);
        $row = $this->db->get('stok')->row_array();
        return $row['harga'];
    }

    public function ajax_kategori()
    {
        $data = array();

        // $this->db->limit(10);
        $this->db->where('idbusiness', $this->id_business);
        $this->db->where('status_kategori', 1);
        $this->db->like('nama_kategori', $this->input->get('q'));
        $result = $this->db->get('kategori')->result_array();

        $output = array();
        foreach ($result as $row) {
            $buff = array();
            $buff['id'] = $row['idkategori'];
            $buff['text'] = $row['nama_kategori'];
            array_push($output, $buff);
        }
        $select2 = array(
            'results' => $output,
            'pagination' => array(
                "more" => false,
            )
        );
        header('Content-Type: application/json');
        echo json_encode($select2);
    }

    public function kategori_submit()
    {
        $message = "";
        $status = true;
        $data = array();

        $submit_data = $this->input->post();

        $this->load->library('form_validation');
        $this->form_validation->set_data($submit_data);
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');

        if ($this->form_validation->run() == false) {
            $status = false;
            $message .= validation_errors();
        } else {
            $insert_data = array(
                'nama_kategori' => $submit_data['kategori'],
                'status_kategori' => 1,
                'idbusiness' => $this->id_business,
            );
            $this->db->insert('kategori', $insert_data);
        }

        if (!empty($this->db->insert_id())) {
            $insert_data['idkategori'] = $this->db->insert_id();
            $data = $insert_data;
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }
}
