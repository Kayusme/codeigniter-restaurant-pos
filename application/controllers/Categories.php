<?php

class Categories extends CI_Controller {

    public function index() {
        $data['title'] = "Categories";

        $data['categories'] = $this->category_model->get_categories();
        $data['category_name'] = $this->category_model->get_category(1)->category_name;
        $data['sub_categories'] = $this->category_model->get_sub_categories();
        $data['items'] = $this->item_model->get_items_by_category(1);

        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('menu/categories', $data);
        $this->load->view('templates/footer');
    }

    public function view($id) {
        $data['title'] = "Categories";
        $data['category_name'] = $this->category_model->get_category($id)->category_name;
        $data['items'] = $this->item_model->get_items_by_category($id);       
        $data['categories'] = $this->category_model->get_categories();

        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('menu/categories', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $res = $this->category_model->insert_category();
        if ($res) {
            echo 'New Category is Added Successfully';
        } else {
            echo 'Failed to Add Category';
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $res = $this->category_model->delete_category($id);
        if ($res) {
            echo 'Category is Deleted Successfully';
        } else {
            echo 'Failed to Delete Category';
        }
    }


}
