<?php

class Users extends CI_Controller {

    public function index() {
        $this->load_index();
    }

    public function load_index() {
        if (!isset($_SESSION['id'])) {
            show_404();
        }
        $this->load->library('form_validation');
        
        $data['title'] = "Manage Users";
        $data['users'] = $this->user_model->get_users();
        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_user() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.user_username]|alpha_dash');
        $this->form_validation->set_rules('password', 'Password', 'required|alpha_numeric');
        $this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'required|matches[password]|alpha_numeric');
        $this->form_validation->set_rules('name', 'Name', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('usertype', 'User Type', 'required|in_list[admin,manager,cashier]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load_index();
        }
        else
        {
            $this->user_model->insert_user();

            $this->session->set_flashdata('user_added', 'New User is Added Successfully!');
            redirect('users');
        }
    }

    public function update_user() {
        $id = $this->input->post('id');
        $usertype = $this->input->post('usertype');
        $result = $this->user_model->update_user($id);
        $this->session->set_flashdata('user_edited', 'User is Updated Successfully! ' . $usertype);
    }

    public function fetch_users() {    
        $users = $this->user_model->get_users();
        $output = array();
        foreach ($users as $user) {
            $output[] = $user->user_username;
        }

        echo json_encode($output);
    }

    public function fetch_user() {
        $id = $this->input->post('id');
        $user = $this->user_model->get_user($id);

        $data = array(
            'name' => $user->user_name,
            'username' => $user->user_username,
            'password' => $user->user_password,
            'user_type' => $user->user_type,
        );

        echo json_encode($data);
    }

    public function delete_user() {
        $id = $this->input->post('id');
        $result = $this->user_model->delete_user($id);

        if ($result) {
            $this->session->set_flashdata('user_deleted', 'User has been deleted successfully');
        }
    }


}