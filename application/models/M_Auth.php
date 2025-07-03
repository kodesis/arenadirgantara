<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{
    public function get_user_data($username)
    {
        return $this->db->get_where('v_user', ['username' => $username])->row_array();
    }

    public function get_user_data_by_id($id)
    {
        return $this->db->get_where('v_user', ['id' => $id])->row_array();
    }

    public function username_exists($username)
    {
        return $this->db->get_where('v_user', ['username' => $username])->num_rows() > 0;
    }

    public function create_customer_account($username, $password)
    {
        $data = [
            'username'   => $username,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'role'       => 'customer',
            'is_active'  => '0'
        ];
        $this->db->insert('users', $data);
        return $this->db->insert_id(); // return user_id
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }
}
