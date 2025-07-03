<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Deposit extends CI_Model
{
    public function addRequest($data)
    {
        return $this->db->insert('deposit_requests', $data);
    }

    private function depositRequest()
    {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $this->db->select('*, dr.id as id_request');
        $this->db->from('deposit_requests dr');
        $this->db->join('user_profiles up', 'dr.agent_id = up.user_id', 'left');

        if ($role === 'customer') {
            $this->db->where('agent_id', $user_id);
        }
    }

    public function countDepositRequest()
    {
        $this->depositRequest();

        return $this->db->count_all_results();
    }

    public function listDepositRequestPaginate($limit, $from, $keyword)
    {
        $this->depositRequest();

        return $this->db->order_by('request_date', 'DESC')->limit($limit, $from)->get()->result();
    }

    public function get_request_by_id($id)
    {
        return $this->db->get_where('deposit_requests', ['id' => $id])->row_array();
    }

    public function addDeposit($data)
    {
        return $this->db->insert('deposit', $data);
    }

    public function updateRequestDeposit($id, $data)
    {
        return $this->db->where('id', $id)->update('deposit_requests', $data);
    }

    public function getSaldoAkhirCustomer($id)
    {
        return $this->db->select('(SUM(amount) - SUM(usage_saldo)) as saldo_akhir')
            ->where('agent_id', $id)
            ->get('deposit')
            ->row_array();
    }

    public function countDepositHistory($id_agent, $from, $to)
    {
        $this->queryDeposit($id_agent);

        if ($from && $to) {
            $this->db->where('DATE(t.created_at) >=', $from);
            $this->db->where('DATE(t.created_at) <=', $to);
        }

        return $this->db->count_all_results();
    }

    public function listDepositHistoryPaginate($id_agent, $from = null, $to = null, $limit = 10, $offset = 0)
    {
        $this->queryDeposit($id_agent);

        if ($from && $to) {
            $this->db->where('DATE(t.created_at) >=', $from);
            $this->db->where('DATE(t.created_at) <=', $to);
        }

        return $this->db->order_by('t.id', 'ASC')->limit($limit, $offset)->get()->result();
    }


    private function queryDeposit($id_agent)
    {
        $this->db->select('t.id, 
                   t.topup_date, 
                   t.amount,
                   t.usage_saldo, 
                   t.booking_id, 
                   t.agent_id, 
                   r.booking_code, 
                   r.created_at AS tanggal_booking, 
                   r.weight,
                   r.chargeable_weight, 
                   r.koli, 
                   r.total_price AS nominal_booking,
                   r.origin,
                   r.destination,
                   r.commodity,
                   r.volume');

        // Subquery untuk menghitung sisa saldo
        $subquery = "(SELECT SUM(d.amount) - SUM(d.usage_saldo) 
              FROM deposit d 
              WHERE d.agent_id = t.agent_id AND d.id <= t.id)";

        // Menambahkan subquery ke dalam select
        $this->db->select("($subquery) AS sisa_saldo");

        // Join tabel resi
        $this->db->from('deposit t');
        $this->db->join('bookings r', 't.booking_id = r.id', 'left');

        // Menambahkan kondisi WHERE
        $this->db->where('t.agent_id', $id_agent);
    }
}
