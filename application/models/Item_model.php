<?php

class Item_model extends CI_Model {

    
    var $table = "items";
    var $order_column = array('item_id', 'item_name', null, 'sub_categories.name','categories.category_name',null);

    public function __construct() {
        $this->load->database();
    }

    public function make_query() {
        $this->db->select(array('item_id','item_name','item_price','categories.category_name', 'sub_categories.name'));
        $this->db->from($this->table);
        $this->db->join("categories", "categories.category_id = items.category_id");
        $this->db->join("sub_categories", "items.sub_category_id = sub_categories.id");
        if (isset($_POST['search']['value'])) {
            $this->db->like('item_name', $_POST['search']['value']);
            $this->db->or_like('name', $_POST['search']['value']);
            $this->db->or_like('category_name', $_POST['search']['value']);
            $this->db->or_like('item_id', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('item_id', 'DESC');
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_filtered_data() {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_items() {
        $this->db->order_by('item_name');
        $this->db->limit(15);
        $this->db->join("sub_categories", "items.sub_category_id = sub_categories.id");
        $output  = $this->db->get($this->table);
        return $output->result();
    }

    public function get_item_by_id($item_id) {
        $this->db->join("categories", "categories.category_id = items.category_id");
        $this->db->join("sub_categories", "items.sub_category_id = sub_categories.id");
        $output = $this->db->get_where($this->table, array('item_id' => $item_id));
        return $output->row();  
    }

    public function get_items_by_category($category_id, $subcat_id = null) {
        $data = array(
                'items.category_id' => $category_id,
                'items.sub_category_id' => $subcat_id
        );
        $this->db->join("categories", "categories.category_id = items.category_id");
        $this->db->join("sub_categories", "items.sub_category_id = sub_categories.id");
        $this->db->order_by('items.item_name', 'ASC');
        $this->db->order_by('categories.category_name', 'DESC');
        
        if ($subcat_id == null || $subcat_id == '' || $subcat_id == '0') {
            $this->db->where('items.category_id', $category_id);
        } else {
            $this->db->where($data);
        }   
        $output = $this->db->get($this->table);
        return $output->result();  
    }

    public function get_items_by_name($name) {
        $this->db->join("sub_categories", "items.sub_category_id = sub_categories.id");
        $this->db->order_by('item_name');
        $this->db->like('item_name', $name);
        $output = $this->db->get($this->table);
        return $output->result();  
    }

    public function insert_item() {
        $data = array(
            'item_name' => $this->input->post("name"),
            'item_price' => $this->input->post("price"),
            'category_id' => $this->input->post("category"),
            'sub_category_id' => $this->input->post("subcategory")
        );
        return $this->db->insert($this->table, $data);
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'item_name' => $this->input->post("name"),
            'item_price' => $this->input->post("price"),
            'category_id' => $this->input->post("category"),
            'sub_category_id' => $this->input->post("subcategory")
        );
        $this->db->where('item_id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($item_id) {
        return $this->db->delete($this->table, array('item_id' => $item_id));
    }
}