<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stok extends CI_Controller
{

    //backoffice/promo/ajax_pilih_produk
    private $column_number = 0;
    private $tanggal_start = "";
    private $tanggal_end = "";

    public function __construct()
    {
        parent::__construct();
        $this->security_model->loggedin_check();
    }

    public function index()
    {
        $data['judul'] = 'Stok';
        $data['isi'] = 'Manajemen Data Stok';

        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $this->db->where('status_outlet', 1);
        $result = $this->db->get('outlet')->result_array();
        $data['opt_outlet'] = create_dropdown_array($result, 'idoutlet', 'name_outlet');
        $data['outlet_selected'] = '';

        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
        $tmp['content'] = $this->load->view('backoffice/stok/stok_datatable', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function sql()
    {
        $tanggal_input = date('01/m/Y') . " - " . date('t/m/Y');
        $produk = $this->input->get('produk');
        $variant = $this->input->get('variant');

        if (!empty($this->input->get('tanggal'))) {
            $tanggal_input = $this->input->get('tanggal');
        }

        $tanggal_buffer = explode("-", $tanggal_input);

        $idoutlet = $this->input->get('idoutlet');
        $tanggal_start = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[0]))->format('Y-m-d') . " 00:00";
        $tanggal_end = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[1]))->format('Y-m-d') . " 23:59";

        $this->tanggal_start = $tanggal_start;
        $this->tanggal_end = $tanggal_end;

        $sql = "select 
        tb.id_stok_terbaru,
        produk.nama_produk,
        variant.nama_variant,
        stok.awal,
        stok.masuk,
        stok.jual,
        stok.penyesuaian,
        stok.transfer,
        stok.akhir,
        stok.tanggal,
        stok.harga,
        '' as detil,
        stok.idproduk,
        stok.idvariant,
        stok.idoutlet
        
        from (
            select 
                max(stok.idstok) as id_stok_terbaru,
                stok.idproduk,
                stok.idvariant
           from  produk
           left join stok on produk.idproduk=stok.idproduk
           left join variant on variant.idvariant=stok.idvariant

            where 
            stok.`status`=1
            and stok.idoutlet=" . $this->db->escape($idoutlet) . "
            and produk.idbusiness=" . $this->session->userdata('id_business') . "
            and stok.tanggal between '" . $tanggal_start . "' and '" . $tanggal_end . "'
            and (
                produk.nama_produk like '%" . $this->db->escape_str(trim($produk)) . "%' 
                or
                variant.nama_variant like '%" . $this->db->escape_str(trim($variant)) . "%' 
                )

            group by stok.idproduk,stok.idvariant
        ) as tb

        left join stok on stok.idstok=tb.id_stok_terbaru
        left join produk on produk.idproduk = tb.idproduk
        left join variant on variant.idvariant= tb.idvariant
        
        where 
        produk.status_produk=1
         and
        (
		   	case WHEN variant.idvariant  is null
					then '1'
		   	else
					variant.`status`
		   	end
			) = 1
        
        order by produk.idproduk
        ";

        return $sql;
    }

    private function callback_collumn($key, $col, $row)
    {
        // if ($key == 'id_stok_terbaru') {
        // 	$this->column_number=$this->column_number+1;
        // 	$col=$this->column_number;
        // }

        if ($key == 'nama_variant') {
            if (empty($col)) {
                $col = ' <i class="fa fa-minus"></i> ';
            }
        }

        if ($key == 'harga') {
            $col = number_format($col, 2);
        }

        if ($key == 'tanggal') {
            if (strlen($col) > 10) {
                $col = DateTime::createFromFormat('Y-m-d H:i:s', trim($col))->format('d/m/Y');
            } else {
                $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
            }
        }

        if ($key == 'detil') {
            $param = array(
                'idproduk' => $row['idproduk'],
                'idvariant' => $row['idvariant'],
                'tanggal_start' => $this->tanggal_start,
                'tanggal_end' => $this->tanggal_end,
                'idoutlet' => $row['idoutlet'],
            );
            $param_str = json_encode($param);
            $detil = "'" . urlencode($param_str) . "'";
            $col = '<a href="#" onclick="detil_modal(' . $detil . ')" class="btn btn-default btn-xs" >'
                . '<i class="fa fa-file-text-o"></i> '
                . 'detail</a>';
        }

        return $col;
    }

    private function callback_column_excel($key, $col, $row)
    {

        if ($key == 'id_stok_terbaru') {
            $this->column_number = $this->column_number + 1;
            $col = $this->column_number;
        }
        if ($key == 'nama_variant') {
            if (empty($col)) {
                $col = ' <i class="fa fa-minus"></i> ';
            }
        }

        if ($key == 'harga') {
            $col = number_format($col, 2);
        }

        if ($key == 'tanggal') {
            if (strlen($col) > 10) {
                $col = DateTime::createFromFormat('Y-m-d H:i:s', trim($col))->format('d/m/Y');
            } else {
                $col = DateTime::createFromFormat('Y-m-d', trim($col))->format('d/m/Y');
            }
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

        $i = 1;
        foreach ($result as $row) {
            $buffer = array();
            $row['id_stok_terbaru'] = $i;

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

    public function export_excel2()
    {

        $this->load->library('table');

        $table_header = array(
            'No',
            'Nama Produk',
            'Variant Produk',
            'Awal',
            'Masuk',
            'Jual',
            'Penyesuaian',
            'Transfer',
            'Akhir',
            'Tanggal',
            'Harga',
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

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=export-" . date('Y-m-d-h-i-s') . ".xls");
        echo $table->generate($data);
    }

    public function Tambah_stok()
    {
        $data['judul'] = 'Stok';
        $data['isi'] = 'Manajemen Data Stok';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
        $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);


        $data['qty_add'] = '';
        $data['selected_item'] = '';
        $data['outlet'] = array();

        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $this->db->where('status_outlet', 1);
        $opt_outlet = $this->db->get('outlet')->result_array();

        $data['outlet'] = create_dropdown_array($opt_outlet, 'idoutlet', 'name_outlet');

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/stok/tambah_stok', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_stok()
    {
        $tgl_pinjam = time();
        $waktu = "Y-m-d";
        $sekarang = date($waktu, $tgl_pinjam);

        $jenis = $this->input->post('jenis');


        if ($jenis == 1) {
            $tambahan_stok = intval($this->input->post('tambah_stok_produk'));
            $produk = $this->input->post('produk');

            $daat = array('idproduk' => $produk, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {

                $sql = "UPDATE stok SET masuk = masuk + '$tambahan_stok', akhir = akhir + '$tambahan_stok' WHERE tanggal = '$sekarang' AND idproduk = '$produk'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idproduk='$produk') AND status='1' AND idproduk='$produk'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir + $tambah_stok;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'masuk' => $tambah_stok,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        } else {
            $tambahan_stok = intval($this->input->post('tambah_stok_variant'));
            $variant = $this->input->post('variant');

            $daat = array('idvariant' => $variant, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {

                $sql = "UPDATE stok SET masuk = masuk + '$tambahan_stok', akhir = akhir + '$tambahan_stok' WHERE tanggal = '$sekarang' AND idvariant = '$variant'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idvariant='$variant') AND status='1' AND idvariant='$variant'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir + $tambah_stok;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'masuk' => $tambah_stok,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        }
    }

    public function _Create_adjustment()
    {
        //        $data['judul'] = 'Stock';
        //        $data['isi'] = 'Manajemen Data Stock';
        //        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1, 'variant' => 1);
        //        $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);
        //        $data['produk'] = $this->data_model->getsomething('produk', $daa);
        //        $data['variant'] = $this->data_model->getsomething('variant', $dab);
        //        $tmp['content'] = $this->load->view('backoffice/stok/create_adjustment', $data, true);
        //        $this->load->view('backoffice/template', $tmp);
    }

    public function Create_adjustment()
    {
        $data['judul'] = 'Stok';
        $data['isi'] = 'Manajemen Data Stok';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
        $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);


        $data['qty_add'] = '';
        $data['selected_item'] = '';
        $data['outlet'] = array();

        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $this->db->where('status_outlet', 1);
        $opt_outlet = $this->db->get('outlet')->result_array();

        $data['outlet'] = create_dropdown_array($opt_outlet, 'idoutlet', 'name_outlet');

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/stok/create_adjustment', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_adjustment()
    {
        $tgl_pinjam = time();
        $waktu = "Y-m-d";
        $sekarang = date($waktu, $tgl_pinjam);

        $jenis = $this->input->post('jenis');

        if ($jenis == 1) {

            $adjustment = floatval($this->input->post('adjustment_produk'));
            $produk = $this->input->post('produk');

            $daat = array('idproduk' => $produk, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {
                $sql = "UPDATE stok SET penyesuaian = penyesuaian + '$adjustment', akhir = akhir - '$adjustment' WHERE tanggal = '$sekarang' AND idproduk = '$produk'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idproduk='$produk') AND status='1' AND idproduk='$produk'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir - $adjustment;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'penyesuaian' => $adjustment,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        } else {
            $adjustment = $this->input->post('adjustment_variant');
            $variant = $this->input->post('variant');

            $daat = array('idvariant' => $variant, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {
                $sql = "UPDATE stok SET penyesuaian = penyesuaian + '$adjustment', akhir = akhir - '$adjustment' WHERE tanggal = '$sekarang' AND idvariant = '$variant'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idvariant='$variant') AND status='1' AND idvariant='$variant'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir - $adjustment;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'penyesuaian' => $adjustment,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        }
    }

    public function _Create_transfer2()
    {
        $data['judul'] = 'Stok';
        $data['isi'] = 'Manajemen Data Stok';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1, 'variant' => 1);
        $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);
        $data['produk'] = $this->data_model->getsomething('produk', $daa);
        $data['variant'] = $this->data_model->getsomething('variant', $dab);
        $tmp['content'] = $this->load->view('backoffice/stok/create_transfer', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Create_transfer()
    {
        $data['judul'] = 'Stok';
        $data['isi'] = 'Manajemen Data Stok';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_produk' => 1);
        $dab = array('idbusiness' => $this->session->userdata('id_business'), 'status' => 1);


        $data['qty_add'] = '';
        $data['selected_item'] = '';
        $data['outlet'] = array();

        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $this->db->where('status_outlet', 1);
        $opt_outlet = $this->db->get('outlet')->result_array();

        $data['outlet'] = create_dropdown_array($opt_outlet, 'idoutlet', 'name_outlet');

        $tmp['js_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'
        );

        $tmp['css_files'] = array(
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css'
        );

        $tmp['content'] = $this->load->view('backoffice/stok/create_transfer', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Insert_transfer()
    {
        $tgl_pinjam = time();
        $waktu = "Y-m-d";
        $sekarang = date($waktu, $tgl_pinjam);

        $jenis = $this->input->post('jenis');

        if ($jenis == 1) {
            $transfer = $this->input->post('transfer_produk');
            $produk = $this->input->post('produk');

            $daat = array('idproduk' => $produk, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {
                $sql = "UPDATE stok SET transfer = transfer + '$transfer', akhir = akhir - '$transfer' WHERE tanggal = '$sekarang' AND idproduk = '$produk'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idproduk='$produk') AND status='1' AND idproduk='$produk'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir - $transfer;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'transfer' => $transfer,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        } else {
            $transfer = $this->input->post('transfer_variant');
            $variant = $this->input->post('variant');

            $daat = array('idvariant' => $variant, 'tanggal' => $sekarang, 'status' => 1,);
            $juml = $this->data_model->count_where('stok', $daat);

            if ($juml > 0) {
                $sql = "UPDATE stok SET transfer = transfer + '$transfer', akhir = akhir - '$transfer' WHERE tanggal = '$sekarang' AND idvariant = '$variant'";
                if ($this->db->query($sql)) {
                    $this->session->set_flashdata('message', "modal-success");
                    redirect("backoffice/stok");
                } else {
                    echo "error";
                }
            } else {
                $whr = $this->db->query("SELECT * FROM stok WHERE tanggal IN (SELECT MAX(tanggal) FROM stok WHERE idvariant='$variant') AND status='1' AND idvariant='$variant'")->result();
                foreach ($whr as $rw) :
                    $akhir = $rw->akhir;
                    $harga = $rw->harga;
                    $idvariant = $rw->idvariant;
                    $ahh = $akhir - $transfer;
                    $data = array(
                        'idproduk' => $produk,
                        'idvariant' => $idvariant,
                        'awal' => $akhir,
                        'transfer' => $transfer,
                        'akhir' => $ahh,
                        'status' => 1,
                        'harga' => $harga,
                        'tanggal' => $sekarang
                    );
                    $this->data_model->insert_something('stok', $data);
                endforeach;
                $this->session->set_flashdata('message', "modal-success");
                redirect("backoffice/stok");
            }
        }
    }

    public function submit_add_stok()
    {
        $status = true;
        $message = "";
        $data = array();

        $form['produk_add'] = $this->input->post('produk_add');
        $form['qty_add'] = $this->input->post('qty_add');
        $form['outlet'] = $this->input->post('outlet');

        $this->load->library('form_validation');
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules('produk_add', "Produk-Variant", 'trim|required');
        $this->form_validation->set_rules('qty_add', "Qty", 'trim|required');
        $this->form_validation->set_rules('outlet', "Outlet", 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }



        if ($status) {
            $buff1 = explode('-', $this->input->post('produk_add'));

            $this->db->where('idproduk', $buff1[0]);
            if (!empty($buff1[0])) {
                $this->db->where('idvariant', $buff1[1]);
            }
            $this->db->where('idoutlet', $this->input->post('outlet'));
            $this->db->order_by('idstok', 'desc');
            $last_stok = array();

            $last_stok['akhir'] = 0;
            $last_stok['harga'] = 0;
            $exc = $this->db->get('stok');
            if ($exc->num_rows() > 0) {
                $last_stok = $exc->row_array();
            }

            $insert_stok = array();
            $insert_stok['idproduk'] = $buff1[0];
            $insert_stok['idvariant'] = $buff1[1];
            $insert_stok['idoutlet'] = intval($this->input->post('outlet'));
            $insert_stok['awal'] = $last_stok['akhir'];
            $insert_stok['masuk'] = $form['qty_add'];
            $insert_stok['akhir'] = $last_stok['akhir'] + $form['qty_add'];
            $insert_stok['tanggal'] = date('Y-m-d');
            $insert_stok['harga'] = $last_stok['harga'];
            $insert_stok['status'] = 1;
            $this->db->insert('stok', $insert_stok);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    public function submit_adjusment_stok()
    {
        $status = true;
        $message = "";
        $data = array();

        $form['produk_add'] = $this->input->post('produk_add');
        $form['qty_add'] = $this->input->post('qty_add');
        $form['outlet'] = $this->input->post('outlet');

        $this->load->library('form_validation');
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules('produk_add', "Produk-Variant", 'trim|required');
        $this->form_validation->set_rules('qty_add', "Qty", 'trim|required');
        $this->form_validation->set_rules('outlet', "Outlet", 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }

        if ($status) {
            $buff1 = explode('-', $this->input->post('produk_add'));

            $this->db->where('idproduk', $buff1[0]);
            if (!empty($buff1[0])) {
                $this->db->where('idvariant', $buff1[1]);
            }
            $this->db->where('idoutlet', $this->input->post('outlet'));
            $this->db->order_by('idstok', 'desc');
            $last_stok = array();

            $last_stok['akhir'] = 0;
            $last_stok['harga'] = 0;
            $exc = $this->db->get('stok');
            if ($exc->num_rows() > 0) {
                $last_stok = $exc->row_array();
            }

            $penyesuaian = intval($this->input->post('qty_add'));

            $insert_stok = array();
            $insert_stok['idproduk'] = $buff1[0];
            $insert_stok['idvariant'] = $buff1[1];
            $insert_stok['idoutlet'] = intval($this->input->post('outlet'));
            $insert_stok['awal'] = $last_stok['akhir'];
            $insert_stok['penyesuaian'] = $penyesuaian - $last_stok['akhir'];
            $insert_stok['akhir'] = $penyesuaian;
            $insert_stok['tanggal'] = date('Y-m-d');
            $insert_stok['harga'] = $last_stok['harga'];
            $insert_stok['status'] = 1;
            $this->db->insert('stok', $insert_stok);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    public function submit_transfer_order()
    {
        $status = true;
        $message = "";
        $data = array();

        $form['produk_out'] = $this->input->post('produk_out');
        $form['qty_out'] = $this->input->post('qty_out');
        $form['outlet_out'] = $this->input->post('outlet_out');
        $form['outlet_in'] = $this->input->post('outlet_in');

        $this->load->library('form_validation');
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules('produk_out', "Produk-Variant", 'trim|required');
        $this->form_validation->set_rules('qty_out', "Qty", 'trim|required');
        $this->form_validation->set_rules('outlet_out', "Outlet", 'trim|required');
        $this->form_validation->set_rules('outlet_in', "Outlet Tujuan", 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        }

        if ($status) {
            $buff1 = explode('-', $this->input->post('produk_out'));

            $this->db->where('idproduk', $buff1[0]);
            if (!empty($buff1[0])) {
                $this->db->where('idvariant', $buff1[1]);
            }
            $this->db->where('idoutlet', $this->input->post('outlet_out'));
            $this->db->order_by('idstok', 'desc');
            $last_stok = array();

            $last_stok['akhir'] = 0;
            $last_stok['harga'] = 0;
            $exc = $this->db->get('stok');
            if ($exc->num_rows() > 0) {
                $last_stok = $exc->row_array();
            }
            $insert_stok = array();
            $insert_stok['idproduk'] = $buff1[0];
            $insert_stok['idvariant'] = $buff1[1];
            $insert_stok['idoutlet'] = intval($this->input->post('outlet_out'));
            $insert_stok['awal'] = $last_stok['akhir'];
            $insert_stok['transfer'] = intval($this->input->post('qty_out'));
            $insert_stok['akhir'] = $last_stok['akhir'] - intval($this->input->post('qty_out'));
            $insert_stok['tanggal'] = date('Y-m-d');
            $insert_stok['harga'] = $last_stok['harga'];
            $insert_stok['status'] = 1;
            $this->db->insert('stok', $insert_stok);

            $this->db->where('idproduk', $buff1[0]);
            if (!empty($buff1[0])) {
                $this->db->where('idvariant', $buff1[1]);
            }
            $this->db->where('idoutlet', $this->input->post('outlet_in'));
            $this->db->order_by('idstok', 'desc');
            $last_stok_in = array();
            $last_stok_in['akhir'] = 0;
            $last_stok_in['harga'] = 0;
            $exc = $this->db->get('stok');
            if ($exc->num_rows() > 0) {
                $last_stok_in = $exc->row_array();
            }

            $insert_stok = array();
            $insert_stok['idproduk'] = $buff1[0];
            $insert_stok['idvariant'] = $buff1[1];
            $insert_stok['idoutlet'] = intval($this->input->post('outlet_in'));
            $insert_stok['awal'] = $last_stok_in['akhir'];
            $insert_stok['masuk'] = intval($this->input->post('qty_out'));
            $insert_stok['akhir'] = $last_stok_in['akhir'] + intval($this->input->post('qty_out'));
            $insert_stok['tanggal'] = date('Y-m-d');
            $insert_stok['harga'] = $last_stok['harga'];
            $insert_stok['status'] = 1;
            $this->db->insert('stok', $insert_stok);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ));
    }

    public function ajax_detil_stok()
    {
        $get = $this->input->get('param');
        $json = urldecode($get);
        $arr = json_decode($json, true);

        $sql = "select stok.*,
        produk.nama_produk,
        variant.nama_variant 
        from stok
        left join produk on produk.idproduk=stok.idproduk
        left join variant on variant.idvariant=stok.idvariant
        where 
        stok.idproduk=" . $this->db->escape($arr['idproduk']) . "
        ";

        if (!empty($arr['idvariant'])) {
            $sql .= " and
            stok.idvariant= " . $this->db->escape($arr['idvariant']) . " ";
        }

        $sql .= "and
        stok.tanggal BETWEEN " . $this->db->escape($arr['tanggal_start']) . " and " . $this->db->escape($arr['tanggal_end']) . "
        and
        stok.idoutlet=" . $arr['idoutlet'] . "
        and
        stok.`status`=1";

        $sql .= " order by stok.idstok desc";

        $detil = $this->db->query($sql)->result_array();

        $name_outlet = $this->db->where('idoutlet', $arr['idoutlet'])->get('outlet')->row_array()['name_outlet'];

        $data = array(
            'detil' => $detil,
            'tanggal_start' => $arr['tanggal_start'],
            'tanggal_end' => $arr['tanggal_end'],
            'name_outlet' => $name_outlet,
        );

        echo $this->load->view('backoffice/stok/stok_ajax_detil', $data, true);
    }
}
