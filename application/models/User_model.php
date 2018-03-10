<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model
        extends CI_Model {

    public function getUsers($id = '') {
        $where = '';
        if (!empty($id)) {
            $where = ' WHERE u_id = ' . $id;
        }
        $sql = "SELECT * FROM users" . $where;
        $query = $this->db->query($sql);
        if (!is_null($id) && strlen($id) > 0) {
            return $query->row();
        } else {
            return $query->result_array();
        }
    }

    public function checkEmail($email, $id = '') {
        $whe = '';
        if (!empty($id) && strlen($id) > 0) {
            $whe = ' AND u_id <> ' . $id;
        }
        $sql = "SELECT * FROM users WHERE u_email = '" . $email . "' $whe";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function insertUser($data) {
        $dat['u_firstname'] = $data['u_firstname'];
        $dat['u_lastname'] = $data['u_lastname'];
        $dat['u_email'] = $data['u_email'];
        $dat['u_password'] = md5($data['u_password']);
        $dat['u_phone'] = $data['u_phone'];
        $dat['u_about'] = $data['u_about'];
        $dat['u_profile'] = $data['u_profile'];
        $this->db->insert('users', $dat);
        return $this->db->insert_id();
    }

    public function checkLogin($data) {
        $email = $data['u_email'];
        $password = md5($data['u_password']);
        $sql = "SELECT * FROM users WHERE u_email = '" . $email . "' AND u_password= '" . $password . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function deleteUser($id) {
        $this->db->where('u_id', $id);
        $this->db->delete('users');
    }

    public function updateData($data) {
        $dat['u_firstname'] = $data['u_firstname'];
        $dat['u_lastname'] = $data['u_lastname'];
        $dat['u_email'] = $data['u_email'];
        if (!empty($data['u_password'])) {
            $dat['u_password'] = md5($data['u_password']);
        }
        $dat['u_phone'] = $data['u_phone'];
        $dat['u_about'] = $data['u_about'];
        $dat['u_profile'] = $data['u_profile'];
        $id = $data['u_id'];
        $this->db->where('u_id', $id);
        $this->db->update('users', $dat);
    }
    
    public function insertProduct($data) {
        $this->db->insert('product', $data);
        return $this->db->insert_id();
    }
    
    public function getProduct($id = '') {
        $where = '';
        if (!empty($id)) {
            $where = ' WHERE prod_id = ' . $id;
        }
        $sql = "SELECT * FROM product" . $where;
        $query = $this->db->query($sql);
        if (!is_null($id) && strlen($id) > 0) {
            return $query->row();
        } else {
            return $query->result_array();
        }
    }
    public function deleteProduct($id) {
        $this->db->where('prod_id', $id);
        $this->db->delete('product');
    }
}
