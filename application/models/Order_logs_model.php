<?php 


class Order_logs_model extends CI_Model {

    var $order_column = array('id',null,null,null,null,null, 'order_date');


    public function __construct() {
        $this->load->database();
    }

    public function make_query() {
        $this->db->select('*');

        $this->db->join('users', "orders_log.user_id = users.user_id");
        $this->db->join('discounts', "orders_log.discount_id = discounts.discount_id");
        $this->db->from('orders_log');

        if (isset($_POST['search']['value'])) {
            $this->db->like('user_name', $_POST['search']['value']);
            $this->db->or_like('description', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function make_datatable() {
        $this->make_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'],$_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_data() {
        $this->db->select('*');
        $this->db->from('orders_log');
        return $this->db->count_all_results();
    }

    public function get_filtered_data() {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_order_log_id($id){
        $this->db->select('*');
        $this->db->join('users', 'orders_log.user_id = users.user_id');
        $this->db->join('discounts', 'orders_log.discount_id = discounts.discount_id');
        $output = $this->db->get_where('orders_log', array('order_id' => $id));

        return $output->row();
    }
}