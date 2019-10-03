<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    private $number_column = 0;
    private $type_business = "";
    private $id_business = "";

    public function __construct()
    {
        parent::__construct();
        $this->security_model->loggedin_check();

        $this->type_business = $this->session->userdata('type_bus');
        $this->id_business = $this->session->userdata('id_business');
    }

    public function index()
    {
        $data['judul'] = 'Transaksi';
        $data['isi'] = 'View Data Transaksi';

        $this->load->helper('haris_helper');
        $this->db->where('status_outlet', 1);
        $this->db->where('idbusiness', $this->session->userdata('id_business'));
        $res = $this->db->get('outlet')->result_array();
        $opt_outlet = create_dropdown_array($res, 'idoutlet', 'name_outlet');
        $opt_outlet[''] = "Pilih Outlet";
        $data['opt_outlet'] = $opt_outlet;

        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_transHD' => 1);
        $dag = array('idbusiness' => $this->session->userdata('id_business'), 'status_user' => 1);
        $data['karyawan'] = $this->data_model->getsomething('user', $dag);
        $data['jum_tot'] = $this->data_model->count_where('trans_header', $daa);

        $tmp['content'] = $this->load->view('backoffice/transaksi/transaksi', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function Detail($id = 0)
    {
        $data['judul'] = 'Transaksi';
        $data['isi'] = 'Detail Transaksi';
        $daa = array(
            'idtransHD' => $id,
            'idbusiness' => $this->id_business
        );

        $detail_transaksi = $this->sql_translist($id);

        $buff = array();
        foreach ($detail_transaksi as $key => $row) {
            $buff[$key] = $row;

            $buff[$key]['modifier'] = $this->sql_translist_modifier($id, $row['idtranslist']);
        }

        $data['detail_transaksi'] = $buff;

        $detail_promo = $this->sql_translist_promo($id);
        $data['detail_promo'] = $detail_promo;

        $this->db->where($daa);
        $exc = $this->db->get('trans_header');
        $data['transaksi'] = $exc->result();

        $tax_list = array();
        $tax_list = $this->sql_translist_tax($id);

        $data['tax_list'] = $tax_list;


        if ($exc->num_rows() < 1) {
            show_error("Maaf, Data Tersebut Tidak Ada");
            die();
        }

        $tmp['content'] = $this->load->view('backoffice/transaksi/detail_transaksi', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function sql()
    {
        $id_business = trim($this->session->userdata('id_business'));
        $kasir = trim($this->input->get('kasir'));
        $jumlah = trim($this->input->get('jumlah_data'));
        $tanggal = trim($this->input->get('tanggal'));
        $outlet = trim($this->input->get('outlet'));
        $kode_trans = trim($this->input->get('kode_trans'));


        if (empty($tanggal)) {
            $tanggal = date('01/m/Y H:i') . " - " . date('t/m/Y H:i');
        }

        $tanggal_buffer = explode("-", $tanggal);
        $tanggal_start = DateTime::createFromFormat('d/m/Y H:i', trim($tanggal_buffer[0]))->format('Y-m-d H:i');
        $tanggal_end = DateTime::createFromFormat('d/m/Y H:i', trim($tanggal_buffer[1]))->format('Y-m-d H:i');

        $sql = "SELECT 
                trans_header.idtransHD,
                trans_header.kode_transHD,
                outlet.name_outlet, 
                user.nama_user, 
                DATE_FORMAT(trans_header.tgl_transHD,'%Y-%m-%d %H:%i') as tanggal, 
                trans_header.total_transHD, 
                '' AS action 
                FROM trans_header 
                LEFT JOIN user ON user.iduser=trans_header.iduser 
                LEFT JOIN outlet ON outlet.idoutlet=trans_header.idoutlet 
                WHERE 
                trans_header.status_transHD=1 AND trans_header.idbusiness = " . $this->db->escape($id_business) . " 
                AND trans_header.tgl_transHD 
                BETWEEN 
                '" . $this->db->escape_str($tanggal_start) . "' and '" . $this->db->escape_str($tanggal_end) . "' ";

        if (!empty($outlet)) {
            $sql .= " and outlet.idoutlet = " . $this->db->escape($outlet) . " ";
        }

        if (!empty($kasir)) {
            $sql .= "AND trans_header.iduser= " . $this->db->escape($kasir) . " ";
        }

        if (!empty($kode_trans)) {
            $sql .= "AND trans_header.kode_transHD like '%" . $this->db->escape_str($kode_trans) . "%' ";
        }

        $sql .= " and trans_header.status_bill=0 ";

        $sql .= " order by  trans_header.idtransHD  desc ";

        return $sql;
    }

    private function callback_collumn($key, $col, $row)
    {

        if ($key == 'action') {
            $url = base_url() . "backoffice/transaksi/detail/" . $row['idtransHD'];
            $col = '<a href="' . $url . '" class="btn btn-default btn-xs">View Detail</a>';
        }

        if ($key == 'tanggal') {
            $col = DateTime::createFromFormat('Y-m-d H:i', trim($col))->format('d/m/Y H:i');
        }

        if ($key == 'total_transHD') {
            $col = number_format($col, 2);
        }

        if ($key == 'idtransHD') {
            $this->number_column = $this->number_column + 1;
            $col = $this->number_column;
        }

        return $col;
    }

    public function datatable()
    {
        $sql = $this->sql();

        $result = $this->db->query($sql)->result_array();


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

    public function Filter()
    {
        if (!$_POST) {
            redirect('backoffice/transaksi/');
        }

        $data['judul'] = 'Transaksi';
        $data['isi'] = 'View Data Transaksi';
        $daa = array('idbusiness' => $this->session->userdata('id_business'), 'status_transHD' => 1);
        $dag = array('idbusiness' => $this->session->userdata('id_business'), 'status_user' => 1);
        $data['karyawan'] = $this->data_model->getsomething('user', $dag);
        $data['jum_tot'] = $this->data_model->count_total('trans_header');

        $data['transaksi'] = $this->data_transaksi();

        $tmp['content'] = $this->load->view('backoffice/transaksi/transaksi', $data, true);

        $this->load->view('backoffice/template', $tmp);
    }

    private function sql_translist($id_trans_hd)
    {
        $sql = "select 
        produk.idproduk,
   	variant.idvariant,
        produk.nama_produk,
        variant.nama_variant,
        trans_list.qty,
        trans_list.harga_satuan,
        trans_list.idtranslist

        from trans_list
        left join produk on produk.idproduk=trans_list.idproduk
        left join variant on variant.idvariant=trans_list.idvariant
        left join tax on tax.idtax=trans_list.idtax

        where trans_list.idtransHD=" . $this->db->escape($id_trans_hd) . "  ";

        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    private function sql_translist_modifier($idtranshd, $idtranslist)
    {
        $sql = " select 
			trans_list_modifier.*,
			modifier.nama_modifier,
			sub_modifier.nama_sub
        from trans_list_modifier
			left join modifier
			on modifier.idmodifier=trans_list_modifier.idmodifier
			left join sub_modifier
			on sub_modifier.idsubmodifier=trans_list_modifier.idsubmodifier

        where 
		  trans_list_modifier.idtransHD=" . $this->db->escape($idtranshd) . "
		  and
		  trans_list_modifier.idtranslist=" . $this->db->escape($idtranslist) . "
		  
		   ";

        $exc = $this->db->query($sql);
        return $exc->result_array();
    }

    private function sql_translist_promo($id_trans_hd)
    {
        $sql = "select 
		  produk.idproduk,
		  variant.idvariant,
		  produk.nama_produk,
		  variant.nama_variant,
		  trans_list_promo.qty,
		  trans_list_promo.idpromo

        from trans_list_promo
        left join produk on produk.idproduk=trans_list_promo.idproduk
        left join variant on variant.idvariant=trans_list_promo.idvariant

        where trans_list_promo.idtransHD=" . $id_trans_hd . " ";
        $data = $this->db->query($sql)->result_array();

        $buff = array();
        foreach ($data as $row) {
            $row['detail_promo'] = $this->sql_translist_promo_detail($row['idpromo']);
            array_push($buff, $row);
        }

        return $buff;
    }

    private function sql_translist_promo_detail($idpromo)
    {
        $sql = "select 
		produk1.nama_produk,
		variant1.nama_variant,
		produk2.nama_produk as produk_get,
		variant2.nama_variant as variant_get,
                promo1.qty,
                promo1.qty_get,
                promo1.tanggal_mulai,
                promo1.tanggal_akhir,
                promo1.*
            from promo as promo1
            left join produk as produk1
            on produk1.idproduk=promo1.idproduk
            left JOIN variant as variant1
            on variant1.idvariant=promo1.idvariant
            
            left join produk as produk2
            on produk2.idproduk=promo1.idproduk
            left JOIN variant as variant2
            on variant2.idvariant=promo1.idvariant
            
            where
            promo1.idbusiness=5
            and
            promo1.status_promo=1
            and 
            promo1.idpromo=" . $idpromo . "";

        $data = $this->db->query($sql)->row_array();
        return $data;
    }

    private function sql_translist_tax($idtranshd)
    {
        $sql = "select 
        tax.nama_tax,
        trans_list_tax.besaran_tax
        from trans_list_tax

        left join tax
        on tax.idtax=trans_list_tax.idtax

        where
        trans_list_tax.idtransHD=" . $this->db->escape($idtranshd) . " ";
        $exc = $this->db->query($sql);
        $data = $exc->result_array();
        return $data;
    }

    public function export_excel2()
    {

        $dataArray = array(
            array(
                'No',
                'Outlet',
                'Kasir',
                'Tanggal',
                'Produk',
                'Variant',
                'Qty',
                'Harga Satuan',
                'Total',
            )
        );

        $sql = $this->sql();
        $transaksi = $this->db->query($sql)->result_array();
        foreach ($transaksi as $row) {
            $transaksi_list = $this->sql_translist($row['idtransHD']);
            foreach ($transaksi_list as $row2) {
                $buff = array(
                    $row['idtransHD'],
                    $row['name_outlet'],
                    $row['nama_user'],
                    $row['tanggal'],
                    //============================
                    $row2['nama_produk'],
                    $row2['nama_variant'],
                    $row2['qty'],
                    $row2['harga_satuan'],
                    //============================
                    $row['total_transHD'],
                );
                array_push($dataArray, $buff);
            }
        }
        $this->load->library('table');
        $table = new CI_Table();
        $template = array(
            'table_open' => '<table border="1">',
        );
        $table->set_template($template);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=export-" . date('Y-m-d-h-i-s') . ".xls");
        echo $table->generate($dataArray);
    }

    public function add()
    {
        $data['judul'] = 'Transaksi';
        $data['isi'] = 'Tambah Data Transaksi';
        $data['js_files'] = array(
            base_url() . '/assets/knockout/knockout-3.5.0.js',
            base_url() . '/assets/jquery-ui-1.11.4.custom/jquery-ui.js',
        );

        $data['css_files'] = array(
            base_url() . 'assets/jquery-ui-1.11.4.custom/jquery-ui.css',
        );

        $tmp['content'] = $this->load->view('backoffice/transaksi/transaksi_add', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    public function cari_product()
    {
        $q = $this->input->get('q');

        $q = $this->db->escape_str($q);

        $sql = "select 
        produk.idproduk,
        variant.idvariant as `variant`,
        produk.nama_produk,
        variant.nama_variant,
        produk.harga
        from produk

        left join variant on variant.idproduk=produk.idproduk

        where 
        produk.idbusiness=1
        and ( produk.status_produk=1 or variant.`status`=1 )
        and (produk.nama_produk like '%" . $q . "%' or variant.nama_variant like '%" . $q . "%' )
        limit 100
        ";

        $data = $this->db->query($sql)->result_array();

        $json_buffer = array();
        foreach ($data as $row) {
            $row_buffer = array();

            if ($row['harga'] < 1) {
                $row['harga'] = floatval($this->get_last_stock($row['idproduk'], $row['variant'])['harga']);
            }

            if (strlen($row['nama_variant']) > 0) {
                $row_buffer['label'] = $row['nama_produk'] . " - " . $row['nama_variant'];
            } else {
                $row_buffer['label'] = $row['nama_produk'];
            }

            $row_buffer['label'] = $row_buffer['label'];
            $row_buffer['value'] = $row_buffer['label'];
            $row_buffer['row'] = $row;


            array_push($json_buffer, $row_buffer);
        }
        header('Content-Type: application/json');
        echo json_encode($json_buffer);
    }

    private function get_last_stock($idproduck, $variant)
    {
        $where = "";
        if (empty($variant)) {
            $where = "stok.idproduk = " . $this->db->escape($idproduck) . " ";
        } else {
            $where = "stok.idvariant=" . $this->db->escape($variant) . " ";
        }

        $sql = "select * from (
        select max(stok.idstok) as id_stok from stok
        where 
        " . $where . "
        and stok.status=1
        ) as tb
        left join stok on stok.idstok=tb.id_stok";

        $hasil = $this->db->query($sql)->row_array();
        return $hasil;
    }
}
