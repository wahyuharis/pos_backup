<?php
function create_dropdown_array($result_array, $index, $label) {
    $output = array();
    
    foreach ($result_array as $row) {
        $output[$row[$index]] = $row[$label];
    }
    return $output;
}


function intval2($str) {
    $int = str_replace(',', '', $str);
    $int = intval($int);
    return $int;
}

function floatval2($str) {
    $int = str_replace(',', '', $str);
    $int = floatval($int);
    return $int;
}


function gen_sku($table_produk,$primary,$suffix){
    $sku="";
    $ci=&get_instance();
    $ci->db->limit(1);
    $ci->db->order_by('idproduk','desc');
    $data=$ci->db->get($table_produk)->row_array();
    $sku=$suffix."". sprintf('%08d',($data[$primary]+1));
    
    return $sku;
}