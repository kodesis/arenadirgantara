<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Tariff extends CI_Model
{
    private $table = "routes_tariff";

    public function countTariff($keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('airline_code', $keyword);
            $this->db->or_like('destination', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('routes_tariff')->count_all_results();
    }

    public function listTariffPaginate($limit, $from, $keyword)
    {
        if ($keyword) {
            $this->db->group_start(); // Mulai grup kondisi
            $this->db->like('airline_code', $keyword);
            $this->db->or_like('destination', $keyword);
            $this->db->group_end(); // Akhiri grup kondisi
        }

        return $this->db->from('routes_tariff')->order_by('destination', 'ASC')->limit($limit, $from)->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function add_tariff($data)
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

    public function check_duplicate($origin, $destination, $airline)
    {
        return $this->db->get_where($this->table, [
            'origin' => $origin,
            'destination' => $destination,
            'airline_code' => $airline
        ])->row();
    }
}
