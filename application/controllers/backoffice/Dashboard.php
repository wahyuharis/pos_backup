<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    private $tanggal_start = "";
    private $tanggal_end = "";
    private $id_business = "";

    public function __construct() {
        parent::__construct();
        $this->security_model->loggedin_check();

        $this->tanggal_start = date('Y-m-01');
        $this->tanggal_end = date('Y-m-t');

        if ($_POST) {
            $tanggal_input = $this->input->post('tanggal');
            $tanggal_buffer = explode("-", $tanggal_input);
            $this->tanggal_start = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[0]))->format('Y-m-d');
            $this->tanggal_end = DateTime::createFromFormat('d/m/Y', trim($tanggal_buffer[1]))->format('Y-m-d');
        }

        $this->id_business = $this->session->userdata('id_business');
    }

    public function index() {
        $data['judul'] = 'Dashboard';
        $data['isi'] = 'Kelola Dashboard';

        $data['total_pendapatan'] = $this->total_pendapatan();
        $data['total_transaksi'] = $this->total_transaksi();
        $data['total_outlet'] = $this->total_outlet();

        $data['transaksi_perhari'] = $this->transaksi_harian();

        $data['transaksi_per_kategori'] = $this->transaksi_per_kategori();

        $data['transaksi_perjam'] = $this->transaksi_perjam();

        $data['transaksi_day_of_week'] = $this->transaksi_day_of_week();
        
        $data['transaksi_top_10']=$this->transaksi_top_10();
        

        if (!empty($this->input->post('tanggal'))) {
            $tanggal = $this->input->post('tanggal');
        } else {
            $tanggal_start = DateTime::createFromFormat('Y-m-d', trim($this->tanggal_start))->format('d/m/Y');
            $tanggal_end = DateTime::createFromFormat('Y-m-d', trim($this->tanggal_end))->format('d/m/Y');
            $tanggal = $tanggal_start . " - " . $tanggal_end;
        }

        $data['tanggal'] = $tanggal;
        

        $js = array(
            '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
        );

        $css = array(
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css',
        );

        $tmp['css_files'] = $css;
        $tmp['js_files'] = $js;

        $tmp['content'] = $this->load->view('backoffice/dashboard', $data, true);
        $this->load->view('backoffice/template', $tmp);
    }

    private function total_pendapatan() {
        $sql = "select  
		sum( trans_list.`harga_satuan` * trans_list.qty ) as total_pendapatan
        from trans_header
	join trans_list on trans_list.idtransHD=trans_header.idtransHD
	
	where 
	
	trans_header.idbusiness = " . $this->session->userdata('id_business') . " "
                . " and  trans_header.tgl_transHD "
                . " between '" . $this->tanggal_start . "' and '" . $this->tanggal_end . "' "
                . " and trans_header.status_transHD=1 ";


        $res = $this->db->query($sql)->row_array();

        if ($res['total_pendapatan'] < 1) {
            $res['total_pendapatan'] = 0;
        }
        $total_pendapatan = "IDR " . number_format($res['total_pendapatan'], 2);

        return $total_pendapatan;
    }

    private function total_transaksi() {
        $sql = "select 
        count(trans_header.idtransHD) as total_transaksi    
        from trans_header
        where trans_header.tgl_transHD
        between '" . $this->tanggal_start . "' and '" . $this->tanggal_end . "' "
                . " and trans_header.status_transHD=1 and trans_header.idbusiness = " . $this->session->userdata('id_business') . "";
        $data = $this->db->query($sql)->row_array();

        return intval($data['total_transaksi']);
    }

    private function total_outlet() {
        $sql = "select 
        count( outlet.idoutlet ) as total_outlet
        from outlet
        where outlet.idbusiness= " . $this->session->userdata('id_business') . " "
                . "     and outlet.status_outlet=1 ";

        $res = $this->db->query($sql)->row_array();

        return intval($res['total_outlet']);
    }

    private function transaksi_harian() {
        $sql = "select 
         DATE_FORMAT(trans_header.tgl_transHD,'%Y-%m-%d') as tanggal,
        DATE_FORMAT(trans_header.tgl_transHD,'%Y') as tahun,
        DATE_FORMAT(trans_header.tgl_transHD,'%m') as bulan,
        DATE_FORMAT(trans_header.tgl_transHD,'%d') as hari,
        sum( trans_list.`harga_satuan` * trans_list.qty ) as total_jual
        from trans_header

        left join trans_list on trans_list.idtransHD=trans_header.idtransHD
        
        where trans_header.tgl_transHD between '" . $this->tanggal_start . "' and '" . $this->tanggal_end . "'
        and trans_header.idbusiness = " . $this->session->userdata('id_business') . "
         and trans_header.status_transHD=1

        group by DATE_FORMAT(trans_header.tgl_transHD,'%Y-%m-%d')
       
        ";

        $res = $this->db->query($sql)->result_array();

        $period = new DatePeriod(
                new DateTime($this->tanggal_start), new DateInterval('P1D'), new DateTime($this->tanggal_end)
        );

        $canvas = "";
        $canvas .= "[";
        $canvas .= "\n";
        foreach ($period as $key => $value) {

            $canvas .= "{";
//            $canvas .= "x:" . "new Date(" . $value->format('Y') . "," . $value->format('m') . "," . $value->format('d') . "),";
            $canvas .= "x:'" . $value->format('Y') . "-" . $value->format('m') . "-" . $value->format('d') . "',";

            $value_y = "y:" . "0" . "";
            if (count($res) > 0) {
                foreach ($res as $row) {
                    if (trim($row['tanggal']) == trim($value->format('Y-m-d'))) {
                        $value_y = "y:" . number_format((float) $row['total_jual'], 2, '.', '') . "";
                    }
                }
            }

            $canvas .= $value_y;

            $canvas .= "},";
            $canvas .= "\n";
        }
        $canvas .= "]";

        return $canvas;
    }

    private function transaksi_per_kategori() {
        $sql = "select 
		  kategori.nama_kategori,
        sum( trans_list.`harga_satuan` * trans_list.qty ) as total_jual
        from trans_header

        join trans_list on trans_list.idtransHD=trans_header.idtransHD
		  join produk on produk.idproduk=trans_list.idproduk        
		  join kategori on kategori.idkategori=produk.idkategori       

        where trans_header.tgl_transHD between '" . $this->tanggal_start . "' and '" . $this->tanggal_end . "'
        and trans_header.idbusiness = " . $this->session->userdata('id_business') . "
        and trans_header.status_transHD=1

        group by kategori.idkategori ";

        $res = $this->db->query($sql)->result_array();

        $canvas = "";
        $canvas .= "[";
        foreach ($res as $row) {
            $canvas .= "{";

            $canvas .= "label:" . "'" . $row['nama_kategori'] . "'";
            $canvas .= ",";
            $canvas .= "value:" . number_format((float) $row['total_jual'], 2, '.', '') . "";

            $canvas .= "},";
        }
        $canvas .= "]";

        return $canvas;
    }

    private function transaksi_perjam() {
        $sql = "SELECT 
        date_format(tgl_transHD,'%H') as jam, 
        count(*) total_trans
        FROM 
        trans_header 
        WHERE idbusiness = " . $this->id_business . "
        AND tgl_transHD 
        BETWEEN '" . $this->tanggal_start . "' AND '" . $this->tanggal_end . "' 
        GROUP BY date_format(tgl_transHD,'%H')";

        $res = $this->db->query($sql)->result_array();

        $jams = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');

        $canvas = "";
        $canvas .= "[";
        foreach ($jams as $rjams) {
            $canvas .= "{";
            $canvas .= "x:" . "'" . $rjams . "'";
            $canvas .= ",";
            //$canvas_buff = "";
		$canvas_buff = "y: 0.00,";
            foreach ($res as $row) {
                if ($rjams == $row['jam']) {
                    $canvas_buff = "y: " . number_format((float) $row['total_trans'], 2, '.', '') . ",";
                }
            }
            $canvas .= $canvas_buff;
            $canvas .= "},";
            $canvas .= "\n";
        }
        $canvas .= "]";


        return $canvas;
    }

    private function transaksi_day_of_week() {
        $sql = "SELECT 
        weekday(tgl_transHD) as weekday_no, 
        count(*) as total
        FROM trans_header 
        WHERE 
        idbusiness = '" . $this->id_business . "' 
        AND 
        tgl_transHD 
        BETWEEN '" . $this->tanggal_start . "' AND '" . $this->tanggal_end . "' 
        GROUP BY weekday( tgl_transHD )";

        $res = $this->db->query($sql)->result_array();

        $weeks = array('00', '01', '02', '03', '04', '05', '06');

        $canvas = "";
        $canvas .= "[";
        foreach ($weeks as $rday) {
            $canvas .= "{";
            $canvas .= "x:" . "'" . $this->no_ke_hari($rday) . "'";
            $canvas .= ",";
            //$canvas_buff = "";
		$canvas_buff = "y: 0.00,";
            foreach ($res as $row) {
                if ($rday == $row['weekday_no']) {
                    $canvas_buff = "y: " . number_format((float) $row['total'], 2, '.', '') . ",";
                }
            }

            $canvas .= $canvas_buff;
            $canvas .= "},";
            $canvas .= "\n";
        }
        $canvas .= "]";

        return $canvas;
    }

    private function no_ke_hari($no) {
        $weeks = array(
            '00' => 'Senin',
            '01' => 'Selasa',
            '02' => 'Rabu',
            '03' => 'Kamis',
            '04' => 'Jumat',
            '05' => 'Sabtu',
            '06' => 'Minggu');

        return $weeks[$no];
    }

    private function transaksi_top_10() {
        $sql = "select 
        trans_list.idproduk, 
        produk.nama_produk, 
        kategori.nama_kategori, 
        sum(trans_list.qty) as total_qty, 
        sum( trans_list.`harga_satuan` * trans_list.qty ) as total_jual_int, 
        outlet.name_outlet
        -- tax.besaran_tax 
        from trans_header 
        join trans_list on trans_list.idtransHD=trans_header.idtransHD 
        left join produk on produk.idproduk=trans_list.idproduk 
        left join kategori on kategori.idkategori = produk.idkategori 
        left join outlet on outlet.idoutlet = trans_header.idoutlet 
        -- left join tax on tax.idtax=trans_header.idtax 
        where trans_header.status_transHD = 1 
        and trans_header.tgl_transHD BETWEEN '" . $this->db->escape_str($this->tanggal_start) . "' AND '" . $this->db->escape_str($this->tanggal_end) . "' 
        AND trans_header.idbusiness= $this->id_business 
        group by trans_list.idproduk 
        ORDER BY `total_jual_int` 
        DESC LIMIT 10";

        $res = $this->db->query($sql)->result_array();

        return $res;
    }

}
