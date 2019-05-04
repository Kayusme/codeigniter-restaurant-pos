<?php

class Login extends CI_Controller {

    public function index() {

        if (isset($_SESSION['id'])) {
            redirect('dashboard');
        }
        $this->load->library('form_validation');
        
        $this->load->view('templates/login');
    }


    public function submit() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('templates/login');
        } 
        else {   
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->login_user($username, $password)) {             
             
                $u = $this->user_model->get_user_by_username($username);
                $user = array(
                    'id' => $u->user_id,
                    'name' => $u->user_name,
                    'username' => $u->user_username,
                    'usertype' => $u->user_type
                );
                $this->session->set_userdata($user);

                if($u->user_type == 'admin') {
                    redirect('dashboard');
                }
                 redirect('counter');
            } else {   
                $this->session->set_flashdata('login_failed', 'You Entered Wrong Username or Password');
                redirect('');
            }
        }
    }

    public function terminate() {
        unset(
            $_SESSION['id'],
            $_SESSION['name'],
            $_SESSION['username'],
            $_SESSION['usertype']
        );

        redirect('');
    }
}