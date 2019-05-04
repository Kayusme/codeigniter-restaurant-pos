<?php


class Discount_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_discounts() {
        $this->db->order_by('discount_id');
        $output = $this->db->get('discounts');
        return $output->result();
    }

    public function get_discount($id) {
        $output = $this->db->get_where('discounts', array('discount_id' => $id));
        $rate =  $output->row()->discount_rate;
        
        return $rate;
    }
}