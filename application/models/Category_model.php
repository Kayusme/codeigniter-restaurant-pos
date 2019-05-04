<?php

class Category_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }

    public function get_category($id) {
        $output = $this->db->get_where('categories', array('category_id' => $id));
        return $output->row();
    }

    public function get_categories() {
        $this->db->order_by('category_name');
        $output = $this->db->get('categories');
        return $output->result();
    }

    public function get_sub_categories() {
        $this->db->order_by('name');
        $output = $this->db->get('sub_categories');
        return $output->result();
    }

    public function insert_category() {
        $data = array(
            'category_name' => $this->input->post('category')
        );
        return $this->db->insert('categories', $data);
    }

    public function delete_category($id) {
        $this->db->where('category_id', $id);
        return $this->db->delete('categories');
    }
}
