<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Customer extends CI_Model
{
    public function nama_exists($nama)
    {
        $this->db->where('LOWER(name)', strtolower($nama));
        return $this->db->get('user_profiles')->num_rows() > 0;
    }

    public function create_profile($data)
    {
        return $this->db->insert('user_profiles', $data);
    }

    public function countCustomer($keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('name', $keyword);
            $this->db->or_like('address', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('users u')->join('user_profiles up', 'u.id = up.user_id', 'left')->where('role', 'customer')->count_all_results();
    }

    public function listCustomerPaginate($limit, $from, $keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('name', $keyword);
            $this->db->or_like('address', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->select('*, u.id as id_user')->from('users u')->join('user_profiles up', 'u.id = up.user_id', 'left')->where('role', 'customer')->order_by('name', 'ASC')->limit($limit, $from)->get()->result();
    }
}
