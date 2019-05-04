<?php

class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function insert_user() {
        $data = array(
            'user_name' => $this->input->post('name'),
            'user_username' => $this->input->post('username'),
            'user_password' => $this->input->post('password'),
            'user_type' => $this->input->post('usertype')
        );

        $this->db->insert('users', $data);
    }   
    
    public function update_user($id) {

        $data = array(
            'user_name' => $this->input->post('name'),
            'user_username' => $this->input->post('username'),
            'user_password' => $this->input->post('password'),
            'user_type' => $this->input->post('usertype')
        );

        $this->db->where('user_id', $id);
        return $this->db->update('users', $data);
    }    

    public function get_users() {
        $output = $this->db->get('users');

        return $output->result();
    }

    public function delete_user($id) {
        $this->db->where('user_id', $id);
        
        return $this->db->delete('users');
    }

    public function get_user($id) {
        $this->db->where('user_id', $id); 
        $output =  $this->db->get('users');

        return $output->row();
    }

    public function login_user($username, $password) {

        $result = $this->db->get_where('users', array('user_username' => $username));

        if ($result->num_rows() == 1) {
            if ($result->row()->user_password == $password) {
                return true;
            }
            return false;
        }

        return false;
    }

    public function get_user_by_username($username) {
        $this->db->where('user_username', $username);
        $output = $this->db->get('users');

        return $output->row();
    }
}