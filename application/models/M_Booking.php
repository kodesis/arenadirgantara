<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Booking extends CI_Model
{
    private $table = "booking";

    public function countBooking($keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('airline', $keyword);
            // $this->db->or_like('destination', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('booking')->count_all_results();
    }

    public function listBookingPaginate($limit, $from, $keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('airline', $keyword);
            // $this->db->or_like('destination', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('booking')->order_by('created_at', 'DESC')->limit($limit, $from)->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function add_booking($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function selectMaxBooking()
    {
        return $this->db->select('max(no_urut) as max')->where('DATE(created_at)', date('Y-m-d'))->get('booking')->row_array();
    }

    public function insert_dimensi($data)
    {
        return $this->db->insert_batch('dimensi', $data);
    }
}
