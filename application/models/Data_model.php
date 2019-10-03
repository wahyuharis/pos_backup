<?php
class Data_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
    
    function Get_all($table)
    {
        return $this->db->get($table)->result();
    }

    function Get_limit($number,$table)
    {
        return $this->db->get($table,$number)->result();
    }

    function Get_limit_offset($number,$offset,$table)
    {
        return $this->db->get($table,$number,$offset)->result();
    }

    function Pagination_all($number,$offset,$table)
    {
        return $this->db->get($table,$number,$offset)->result();
    }

    function kabupaten($provId)
    {
        $kabupaten="<option value='0'>--pilih--</pilih>";
        $this->db->order_by('name','ASC');
        $kab= $this->db->get_where('tb_regencies',array('province_id'=>$provId));
        foreach ($kab->result_array() as $data )
        {
            $kabupaten.= "<option value='$data[id]'>$data[name]</option>";
        }
        return $kabupaten;
    }

    function kecamatan($kabId)
    {
        $kecamatan="<option value='0'>--pilih--</pilih>";
        $this->db->order_by('name','ASC');
        $kec= $this->db->get_where('tb_districts',array('regency_id'=>$kabId));
        foreach ($kec->result_array() as $data )
        {
            $kecamatan.= "<option value='$data[id]'>$data[name]</option>";
        }
        return $kecamatan;
    }

    function Pagination_where($number,$offset,$table,$data)
    {
        return $this->db->get_where($table,$data,$number,$offset)->result();
    }
    
    function Insert_something($table,$data)
    {
        $action = $this->db->insert($table, $data);	 
		return $action;
    }

    function Insert_siswa($table,$data)
    {
        $action = $this->db->insert($table, $data);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        return $report;
    }
    
    function Update_something($table,$data,$key,$column)
    {
        $this->db->set($data);
        $this->db->where($column, $key);
        $action=$this->db->update($table);
        return $action;
    }

    function Update_double($table,$data,$wher1,$wher2)
    {
        $this->db->set($data);
        $this->db->where($wher1);
        $this->db->where($wher2);
        $action=$this->db->update($table);
        return $action;
    }

    function Search($keyword,$column,$table)
    {
        $this->db->like($column,$keyword);
        $query=$this->db->get($table);
        return $query->result();
    }

    function Count_where($table,$data)
    {
        $this->db->where($data);
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function Count_total($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    public function Getsomething_order($table,$data, $key, $order)
	{
		$this->db->order_by($key, $order);
		return $this->db->get_where($table,$data)->result();
	}

    function Getsomething($table,$data)
    {
        return $this->db->get_where($table,$data)->result();
    }

    function Delete_something($table,$data)
    {
        $this->db->delete($table,$data);
    }

    function Search_order($keyword)
    {
        $this->db->like('id',$keyword);
        $this->db->or_like('atas_nama',$keyword);
        $this->db->or_like('kode',$keyword);
        $this->db->or_like('jenis',$keyword);
        $query=$this->db->get('order');
        return $query->result();
    }

    function Search_user($keyword)
    {
        $this->db->like('id',$keyword);
        $this->db->or_like('nama',$keyword);
        $this->db->or_like('email',$keyword);
        $this->db->or_like('alamat',$keyword);
        $this->db->or_like('nama_brand',$keyword);
        $query=$this->db->get('user_course');
        return $query->result();
    }

    function Auto_id($column,$part,$table)
    {
        $query = $this->db->query("select MAX(RIGHT($column,3)) as sta from $table");
        $id = "";
        if($query->num_rows()>0)
        {
            foreach($query->result() as $cd)
            {
                $tmp = ((int)$cd->sta)+1;
                $id = sprintf("%03s", $tmp);
            }
        }
        else
        {
            $id = "001";
        }
        return $part.$id;
    }
}
