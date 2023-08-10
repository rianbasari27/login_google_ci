<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update_user_by_google_email($email, $data) {
        $this->db->where('email', $email);
        $this->db->update('users', $data);
    }


    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_by_google_id($google_id) {
        $this->db->where('google_id', $google_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_by_google_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
}
