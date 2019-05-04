<?php

class Items extends CI_Controller {
    
    public function index() {
        if (!isset($_SESSION['id'])) {
            show_404();
        }
        $data['title'] = "Manage Items";
        $data['categories'] = $this->category_model->get_categories();
        $data['sub_categories'] = $this->category_model->get_sub_categories();
        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');
    }

    public function fetch_single() {
        $id = $this->input->post('item_id');
        $item = $this->item_model->get_item_by_id($id);
        $data = array(
            'id' =>  $item->item_id,
            'name' =>  $item->item_name,
            'price' =>  $item->item_price,
            'sub_category' =>  $item->id,
            'category' =>  $item->category_id,
        );

        echo json_encode($data);
    }

    public function fetch_all() {
        $fetch_data = $this->item_model->make_datatable();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->item_id;
            $sub_array[] = $row->item_name;
            $sub_array[] = '&#x20B1; ' . number_format((float)$row->item_price, 2);
            $sub_array[] = $row->name;
            $sub_array[] = $row->category_name;
            $sub_array[]  = "<div class='text-center'><button name='update' id='". $row->item_id."' class='update btn btn-info my-circle'><span class='glyphicon glyphicon-edit'></span></button>
            <button name='delete' id='". $row->item_id."' class='delete btn btn-danger my-circle'><span class='glyphicon glyphicon-trash'></span></button></div>
            " ;
            $data[] = $sub_array;
        }

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->item_model->get_all_data(),
            'recordsFiltered' => $this->item_model->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function add_item() {
        if ($this->item_model->insert_item()) {
            echo "New Item is Added Successfully!";
        } else {
            echo "Adding New Item Failed!";
        }
    }

    public function edit_item() {
        if ($this->item_model->update()) {
            echo "Item is Updated Successfully!";
        } else {
            echo "Failed to Update The Item";
        }
    }

    public function delete_item() {
        $item_id = $this->input->post('item_id');
        if ($this->item_model->delete($item_id)) {
            echo "An Item is Successfully Deleted!";
        } else {
            echo "Failed to Delete The Item";
        }
    }

}