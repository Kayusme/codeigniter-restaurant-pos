<?php 


class Order_model extends CI_Model {


    public function __construct() {
        $this->load->database();
    } 

    public function insert_order($total_price, $order_type, $discount_id, $partial_price, $discounted_price) {
        $data = array(
            'user_id' => $_SESSION['id'],
            'order_total_price' => $total_price, 
            'order_type' => $order_type,
            'discount_id' => $discount_id,
            'order_partial_price' => $partial_price,
            'discounted_price' => $discounted_price
        );

        $this->db->insert('orders', $data);
        $inserted_id =  $this->db->insert_id();
        return $inserted_id;
    }

    public function insert_order_log($order_id, $total_price, $order_type, $discount_id, $partial_price, $discounted_price) {
        
        $data = array(
            'order_id' => $order_id,
            'user_id' => $_SESSION['id'],
            'order_total_price' => $total_price, 
            'order_type' => $order_type,
            'discount_id' => $discount_id,
            'order_partial_price' => $partial_price,
            'discounted_price' => $discounted_price
        );

        $this->db->insert('orders_log', $data);
        $inserted_id =  $this->db->insert_id();
        return $inserted_id;
    }

    public function insert_order_item($order_id, $item_id, $qty) {
        $data = array(
            'order_id' => $order_id,
            'item_id' => $item_id,
            'qty' => $qty
        );

        return $this->db->insert('order_items', $data);
    }

    public function insert_batch_item($data) {
        return $this->db->insert_batch('order_items', $data);
    }

    public function get_orders() {
        $output = $this->db->get('orders');

        return $output->result();
    }

    public function get_items_order() {
        $this->db->join('items', 'items.item_id = order_items.item_id');
        $this->db->join('sub_categories', 'sub_categories.id = order_items.sub_category_id');
        $output = $this->db->get('order_items');

        return $output->result();
    }

    public function get_items_order_log($id) {
        $this->db->select('item_name, item_price, qty');
        $this->db->join('items', 'items.item_id = order_items_log.item_id');
        $output = $this->db->get_where('order_items_log', array('order_id' => $id));

        return $output->result();
    }

    public function get_items_order_by_id($id) {
        $this->db->where('order_id', $id);
        $this->db->join('items', 'items.item_id = order_items.item_id');
        $this->db->join('sub_categories', 'sub_categories.id = order_items.sub_category_id');
        $output = $this->db->get('order_items');

        return $output->result();
    }

    public function insert_batch_item_log($data) {
        return $this->db->insert_batch('order_items_log', $data);
    }
    
    public function delete_order($id) {
        $this->db->where('order_id', $id);
        return $this->db->delete('orders');
    }

    public function delete_order_items($id) {
        $this->db->where('order_id', $id);
        $this->db->delete('order_items');
    }
}