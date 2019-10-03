<?php

class Translist_modifier extends CI_Model {

    public $total_row = 0;

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_row($idtranshd, $idproduk, $idvariant) {
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
		  trans_list_modifier.idproduk=" . $this->db->escape($idproduk) . "
		  and
		  trans_list_modifier.idvariant=" . $this->db->escape($idvariant) . "
		   ";

        $exc = $this->db->query($sql);
        $this->total_row = $exc->num_rows();

        return $exc->row_array();
    }

}
