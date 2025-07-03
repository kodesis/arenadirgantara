<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seeder extends CI_Controller
{
    public function index()
    {
        $this->load->database();

        $start = strtotime('06:00:00');
        $end = strtotime('23:00:00');
        $slot_id = 1;
        $slot_data = [];

        echo "Seeding slot_jam...\n";

        // 1. Insert slot_jam
        for ($i = $start; $i < $end; $i += 3600) {
            $jam_mulai = date('H:i:s', $i);
            $jam_selesai = date('H:i:s', $i + 3600);

            $is_prime_time = ($i >= strtotime('17:00:00') && $i < strtotime('21:00:00')) ? 1 : 0;

            $slot = [
                'id' => $slot_id,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'is_prime_time' => $is_prime_time,
                'is_active' => 1
            ];

            $this->db->insert('slot_jam', $slot);

            $slot_data[] = [
                'id' => $slot_id,
                'is_prime_time' => $is_prime_time
            ];

            $slot_id++;
        }

        echo "Seeding harga_slot...\n";

        // 2. Insert harga_slot
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            foreach ($slot_data as $slot) {
                $harga = $slot['is_prime_time'] ? 750000 : 500000;

                $this->db->insert('harga_slot', [
                    'slot_jam_id' => $slot['id'],
                    'hari' => $day,
                    'harga' => $harga
                ]);
            }
        }

        echo "Seeder selesai!\n";
    }
}
