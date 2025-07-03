<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Optional: load model booking
        $this->load->database();
    }

    public function auto_expire()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->where('status', 'waiting_payment')
            ->where('expired_at <', $now)
            ->update('booking', ['status' => 'expired']);

        echo "Expired check done at " . $now;
    }
}
