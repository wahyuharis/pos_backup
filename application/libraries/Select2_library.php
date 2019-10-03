<?php

class Select2_library {

    private $multiple = false;
    private $table = "";
    private $where = "";
    private $index = "";
    private $label = "";
    private $select_name = "";
    private $selected = "";
    private $extra = "";
    private $depends = "";
    private $depends_param = "q2";
    private $param = "q";
    private $placeholder = "";

    public function __construct() {
        
    }

    function set_depends_param($column_rel_depends) {
        $this->depends_param = $column_rel_depends;
        return $this;
    }

    function set_placeholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    function set_param($param) {
        $this->param = $param;
        return $this;
    }

    function set_depends($depends) {
        $this->depends = $depends;
        return $this;
    }

    function set_multiple($multiple) {
        $this->multiple = $multiple;
        return $this;
    }

    function set_table($table) {
        $this->table = $table;
        return $this;
    }

    function set_where($where) {
        $this->where = $where;
        return $this;
    }

    function set_index($index) {
        $this->index = $index;
        return $this;
    }

    function set_label($label) {
        $this->label = $label;
        return $this;
    }

    function set_select_name($select_name) {
        $this->select_name = $select_name;
        return $this;
    }

    function set_selected($selected) {
        $this->selected = $selected;
        return $this;
    }

    function set_extra($extra) {
        $this->extra = $extra;
        return $this;
    }

    private function last_uri_segment() {
        $ci = &get_instance();
        $uri = $ci->uri->segment_array();
        $last_uri = "";
        foreach ($uri as $row) {
            $last_uri = $row;
        }

        return $last_uri;
    }

    function view_load($view_name, $data = array()) {
        $buff = explode(".", $view_name);
        if ($buff[count($buff) - 1] == "php") {
            $view_name = str_replace(".php", "", $view_name);
        }

        extract($data);
        ob_start();
        include 'select2_library/' . $view_name . '.php';
        return ob_get_clean();
    }

    function gen1() {
        $ci = &get_instance();
        $ci->load->database('default');
        $ci->load->helper('form');
        $ci->load->helper('url');

        if (!empty($this->where)) {
            $ci->db->where($this->where);
        }

        $data = $ci->db->get($this->table)->result_array();
        $options = array();
        $options[''] = '';
        foreach ($data as $row) {
            if (is_array($this->selected)) {
                if (in_array($this->selected, $row[$this->index])) {
                    $options[$row[$this->index]] = $row[$this->label];
                }
            } else {
                if ($row[$this->index] == $this->selected) {
                    $options[$row[$this->index]] = $row[$this->label];
                }
            }
        }

        $class_data = array(
            'select_name' => $this->select_name,
            'url_ajax' => current_url() . "/select2_".$this->select_name,
            'placeholder' => $this->placeholder,
            'param' => $this->param,
            'depends_param' => $this->depends_param,
            'depends' => $this->depends,
        );
        $html="";
        $html .= form_dropdown($this->select_name, $options, $this->selected, $this->extra);
        $html .= $this->view_load('select2_script', $class_data);
//        $html .= $ci->load->view('select2_library/select2_script', $class_data, true);
        
        $this->ajax();
        return $html;
    }

    private function ajax() {
        $ci = &get_instance();
        $ci->load->database('default');
        $ci->load->helper('form');
        $ci->load->helper('url');

        if ($this->last_uri_segment() == 'select2_'.$this->select_name) {
            if (!empty($ci->input->get($this->param))) {
                $ci->db->like($this->label, $ci->input->get($this->param));
            }
            if (!empty($this->where)) {
                $ci->db->where($this->where);
            }
            if (!empty($this->depends)) {
                $ci->db->where($this->depends_param, $ci->input->get($this->depends_param));
            }

            $ofsite=intval($ci->input->get('page'));
            
            if(!empty($ofsite)){
                $ofsite=($ofsite-1)*10;
            }
            
            $ci->db->limit(10,$ofsite);
            $data = $ci->db->get($this->table)->result_array();
            $paging=true;
            if(count($data)<10){
                $paging=false;
            }
            
            $result = array();
            foreach ($data as $row) {
                $buff = array();
                $buff['id'] = $row[$this->index];
                $buff['text'] = $row[$this->label];
                array_push($result, $buff);
            }
            $select2 = array(
                'results' => $result,
                'pagination' => array(
                    "more" => $paging,
                )
            );
            header('Content-Type: application/json');
            echo json_encode($select2);
            exit();
        }
    }

}
