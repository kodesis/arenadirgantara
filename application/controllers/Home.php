<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library(['form_validation', 'Api_Whatsapp']);
		$this->load->database();
		$this->load->helper(['url', 'form', 'date', 'number']);
	}

	public function index()
	{
		$data = [
			'title' => 'Home',
			'segment' => 'home',
			'pages' => 'pages/home/v_home',
		];

		$this->load->view('pages/home/index', $data);
	}


	public function booking()
	{
		$data = [
			'title' => 'Booking',
			'segment' => 'booking',
			'pages' => 'pages/home/v_booking',
		];

		$this->load->view('pages/home/index', $data);
	}

	public function gallery()
	{
		$data = [
			'title' => 'Gallery',
			'segment' => 'gallery',
			'pages' => 'pages/home/v_gallery',
		];

		$this->load->view('pages/home/index', $data);
	}


	public function contact()
	{
		$data = [
			'title' => 'Contact',
			'segment' => 'contact',
			'pages' => 'pages/home/v_contact',
		];

		$this->load->view('pages/home/index', $data);
	}

	public function get_calendar_data()
	{
		$this->db->where_in('status', ['confirmed']); // tampilkan yg masih valid
		$bookings = $this->db->get('booking')->result();

		$events = [];
		foreach ($bookings as $b) {
			$color = $b->status === 'confirmed' ? '#52c41a' : '#f0ad4e'; // hijau / oranye

			$events[] = [
				'title' => date('H', strtotime($b->jam_mulai)) . ' - ' . date('H', strtotime($b->jam_selesai)),
				// 'title' => date('H', strtotime($b->jam_mulai)) . ' - ' . date('H', strtotime($b->jam_selesai)) . ' (' . $b->nama . ')',
				'start' => $b->tanggal . 'T' . $b->jam_mulai,
				'end' => $b->tanggal . 'T' . $b->jam_selesai,
				'color' => $color
			];
		}

		header('Content-Type: application/json');
		echo json_encode($events);
	}

	public function get_available_slots()
	{
		$tanggal = $this->input->post('tanggal');
		$dayName = date('l', strtotime($tanggal));
		$today = date('Y-m-d');
		$now_time = date('H:i:s');

		$this->db->where('is_active', 1);
		$slots = $this->db->order_by('jam_mulai')->get('slot_jam')->result();

		$booked = $this->db->where('tanggal', $tanggal)
			->where_not_in('status', ['batal', 'expired'])
			->get('booking')->result();

		// print_r($booked);
		$booked_times = array_map(function ($b) {
			return $b->jam_mulai . '-' . $b->jam_selesai;
		}, $booked);

		$available = [];

		foreach ($slots as $slot) {
			$start_slot = $slot->jam_mulai;
			$end_slot   = $slot->jam_selesai;

			// Skip slot yang sudah lewat jika booking hari ini
			if ($tanggal == $today && $start_slot <= $now_time) {
				continue;
			}

			// Cek apakah ada booking yang bentrok
			$is_booked = false;
			foreach ($booked as $b) {
				// booking dari jam 16:00 s/d 18:00
				// slot dari jam 17:00 s/d 18:00
				// → bentrok kalau: start < booked_selesai && end > booked_mulai
				if (
					$start_slot < $b->jam_selesai &&
					$end_slot > $b->jam_mulai
				) {
					$is_booked = true;
					break;
				}
			}

			if ($is_booked) continue;

			// Ambil harga
			$harga_row = $this->db->get_where('harga_slot', [
				'slot_jam_id' => $slot->id,
				'hari'        => $dayName
			])->row();

			$harga_asli = $harga_row ? $harga_row->harga : 0;
			$diskon = 0;

			// Cek diskon
			$this->db->where('tanggal', $tanggal);
			$this->db->where('jam_mulai', $start_slot);
			$this->db->where('jam_selesai', $end_slot);
			$diskon_spesifik = $this->db->get('diskon_spesifik')->row();

			if ($diskon_spesifik) {
				$diskon = $diskon_spesifik->persen;
			} else {
				$this->db->where('tanggal', $tanggal);
				$diskon_tanggal = $this->db->get('diskon_tanggal')->row();
				if ($diskon_tanggal) {
					$diskon = $diskon_tanggal->persen;
				}
			}

			$harga_diskon = $harga_asli - ($harga_asli * $diskon / 100);

			$available[] = [
				'value' => "$start_slot-$end_slot",
				'label' =>
				date('H:i', strtotime($start_slot)) . ' - ' . date('H:i', strtotime($end_slot)) .
					'<br><br><small>' .
					($diskon > 0
						? '<del style="color:red;">Rp ' . number_format($harga_asli, 0, ',', '.') . '</del><br>'
						: '') .
					'Rp ' . number_format($harga_diskon, 0, ',', '.') .
					'</small>',
				'disabled' => false
			];
		}

		echo json_encode(['slots' => $available, 'csrf_token' => $this->security->get_csrf_hash()]);
	}


	public function checkout()
	{
		$a = explode(',', $this->input->post('jam'));

		$data = [
			'title' => 'Checkout',
			'segment' => 'booking',
			'pages' => 'pages/home/v_checkout',
			'tanggal' => $this->input->post('tanggal'),
			'selected_jam' => $a,
			'slot' => $this->input->post('jam')
		];

		$this->load->view('pages/home/index', $data);
	}

	private function get_weekend_slots()
	{
		return [
			['start' => '06:00:00', 'end' => '08:00:00', 'harga' => 1450000],
			['start' => '08:00:00', 'end' => '10:00:00', 'harga' => 1450000],
			['start' => '10:00:00', 'end' => '12:00:00', 'harga' => 1450000],
			['start' => '12:00:00', 'end' => '14:00:00', 'harga' => 1450000],
			['start' => '14:00:00', 'end' => '16:00:00', 'harga' => 1450000],
			['start' => '16:00:00', 'end' => '18:00:00', 'harga' => 1450000],
			['start' => '18:00:00', 'end' => '20:00:00', 'harga' => 1450000],
			['start' => '20:00:00', 'end' => '22:00:00', 'harga' => 1450000],
			['start' => '22:00:00', 'end' => '24:00:00', 'harga' => 1450000],
		];
	}

	private function get_weekday_slots()
	{
		return [
			['start' => '06:00:00', 'end' => '08:00:00', 'harga' => 500000],
			['start' => '08:00:00', 'end' => '10:00:00', 'harga' => 500000],
			['start' => '10:00:00', 'end' => '12:00:00', 'harga' => 1450000],
			['start' => '12:00:00', 'end' => '14:00:00', 'harga' => 1450000],
			['start' => '14:00:00', 'end' => '16:00:00', 'harga' => 1450000],
			['start' => '16:00:00', 'end' => '18:00:00', 'harga' => 900000],
			['start' => '18:00:00', 'end' => '20:00:00', 'harga' => 1450000],
			['start' => '20:00:00', 'end' => '22:00:00', 'harga' => 1450000],
			['start' => '22:00:00', 'end' => '24:00:00', 'harga' => 1050000],
		];
	}

	public function getHargaSlot($tanggal, $jam_mulai)
	{
		$hari = date('l', strtotime($tanggal)); // misal: "Monday"

		// Cari slot_id berdasarkan jam_mulai
		$slot = $this->db->get_where('slot_jam', ['jam_mulai' => $jam_mulai])->row();

		// Cek apakah jam ini prime
		$is_prime = $slot->is_prime_time;

		// Cari harga default
		$harga = $this->db->get_where('harga_slot', [
			'slot_jam_id' => $slot->id,
			'hari' => $hari
		])->row()->harga ?? 0;

		// Cek diskon jika ada
		$diskon = $this->db->get_where('diskon_hari', [
			'hari' => $hari,
			'tipe' => $is_prime ? 'prime' : 'non-prime'
		])->row()->persen ?? 0;

		// Hitung harga akhir
		$harga_akhir = $harga - ($harga * $diskon / 100);

		return ['harga' => $harga, 'diskon' => $diskon, 'harga_akhir' => $harga_akhir];
	}


	public function submit_booking()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('no_hp', 'Nomor HP', 'required|regex_match[/^[0-9]{9,15}$/]');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('jam', 'Jam Booking', 'required');
		// $this->form_validation->set_rules('total_jam', 'Total Jam', 'required|numeric|greater_than[0]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message_error', validation_errors());
			redirect('home/booking');
			return;
		}

		// Ambil input
		$nama       = $this->input->post('nama', true);
		$no_hp      = $this->input->post('no_hp', true);
		$email      = $this->input->post('email', true);
		$tanggal    = $this->input->post('tanggal', true);
		$slot_raw   = explode(',', $this->input->post('jam', true)); // Array of slot strings
		$total_jam  = (int) $this->input->post('total_jam');

		$ip_address = $this->input->ip_address();
		$user_agent = $this->input->user_agent();

		// if (count($slot_raw) !== $total_jam) {
		// 	$this->session->set_flashdata('error', 'Total jam tidak sesuai dengan slot yang dipilih.');
		// 	redirect('home/booking');
		// 	return;
		// }

		// Validasi apakah semua slot berurutan dan belum dipakai
		$used_slots = $this->db
			->where('tanggal', $tanggal)
			->where_in('jam_mulai', array_map(fn ($s) => explode('-', $s)[0], $slot_raw))
			->where_not_in('status', ['batal', 'expired'])
			->get('booking')
			->result();

		// versi php 7.3 kebawah
		// $used_slots = $this->db
		// 	->where('tanggal', $tanggal)
		// 	->where_in('jam_mulai', array_map(function ($s) {
		// 		return explode('-', $s)[0];
		// 	}, $slot_raw))
		// 	->get('booking')
		// 	->result();

		// print_r($used_slots);
		// exit;

		if ($used_slots) {
			$this->session->set_flashdata('message_error', 'Ada jam yang sudah dibooking orang lain.');
			redirect('home/booking');
			return;
		}

		// Ambil slot dari helper
		$dayName = date('l', strtotime($tanggal));

		$slots = $this->db
			->select('sj.jam_mulai as start, sj.jam_selesai as end, hs.harga')
			->from('slot_jam sj')
			->join('harga_slot hs', "hs.slot_jam_id = sj.id AND hs.hari = '$dayName'", 'left')
			->where('sj.is_active', 1)
			->order_by('sj.jam_mulai')
			->get()
			->result_array();

		$harga_total = 0;
		$start_times = [];
		$end_times   = [];

		foreach ($slot_raw as $slot_str) {
			list($start, $end) = explode('-', $slot_str);
			$start = date('H:i:s', strtotime($start));
			$end   = date('H:i:s', strtotime($end));

			$start_times[] = $start;
			$end_times[] = $end;

			$match_found = false;

			foreach ($slots as $s) {
				if ($s['start'] === $start && $s['end'] === $end) {
					$harga_total += (int) $s['harga'];
					$match_found = true;
					break;
				}
			}

			if (!$match_found) {
				echo "Tidak ketemu untuk slot: $start - $end <br>";
			}
		}


		$jam_mulai   = min($start_times);
		$jam_selesai = max($end_times);

		$kode_booking = $this->generateKodeBooking($tanggal);
		$created_at   = date('Y-m-d H:i:s');
		$expired_at   = date('Y-m-d H:i:s', strtotime($created_at . ' +10 minutes'));

		$this->db->trans_start();

		$data = [
			'kode_booking'   => $kode_booking,
			'nama'           => $nama,
			'no_hp'          => $no_hp,
			'email'          => $email,
			'tanggal'        => $tanggal,
			'jam_mulai'      => $jam_mulai,
			'jam_selesai'    => $jam_selesai,
			'harga'          => $harga_total,
			'status'         => 'waiting_payment',
			'created_at'     => $created_at,
			'expired_at'     => $expired_at,
			'ip_address'     => $ip_address,
			'user_agent'     => $user_agent // optional
		];

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// exit;
		$this->db->insert('booking', $data);

		$this->db->trans_complete();

		if (!$this->db->trans_status()) {
			show_error('Gagal menyimpan booking. Coba ulangi.');
		}

		// Notifikasi WhatsApp
		$url = site_url('home/upload_bukti/' . $kode_booking);
		$pesan_wa = "*Booking Arena Dirgantara*%0A" .
			"Kode Booking: *$kode_booking*%0A" .
			"Nama: *$nama*%0A" .
			"Tanggal: *" . date('d-m-Y', strtotime($tanggal)) . "*%0A" .
			"Jam: *$jam_mulai - $jam_selesai*%0A" .
			"Total Jam: *$total_jam jam*%0A" .
			"Total Harga: *Rp " . number_format($harga_total, 0, ',', '.') . "*%0A%0A" .
			"Upload bukti transfer dalam 10 menit:%0A%0A$url";

		$this->api_whatsapp->wa_notif($pesan_wa, $no_hp);

		redirect('home/upload_bukti/' . $kode_booking);
	}


	private function generateKodeBooking($tanggal)
	{
		$prefix = 'BK' . date('Ymd', strtotime($tanggal));
		$last = $this->db->like('kode_booking', $prefix)
			->order_by('kode_booking', 'DESC')
			->limit(1)
			->get('booking')
			->row();

		if ($last) {
			$lastChar = substr($last->kode_booking, -1);
			$newChar = chr(ord($lastChar) + 1);
		} else {
			$newChar = 'A';
		}

		return $prefix . $newChar;
	}

	public function upload_bukti($kode_booking)
	{
		$booking = $this->db->get_where('booking', ['kode_booking' => $kode_booking])->row();
		if (!$booking || $booking->status !== 'waiting_payment') {
			show_404();
		}

		$data_bayar = [
			'nominal' => $booking->harga,
			'nomor_rekening' => '1148254122',
			'keterangan' => 'BNI a.n Adrian Pratama'
		];

		$data = [
			'title' => 'Upload bukti bayar',
			'booking' => $booking,
			'pages' => 'pages/home/v_upload_bukti',
			'data_bayar' => $data_bayar
		];

		$this->load->view('pages/auth/index', $data);
	}

	public function proses_upload_bukti($kode_booking)
	{
		$booking = $this->db->get_where('booking', ['kode_booking' => $kode_booking, 'status' => 'waiting_payment'])->row();
		if (!$booking) {
			show_404();
		}

		$now = date('Y-m-d H:i:s');
		if ($now > $booking->expired_at) {
			$this->session->set_flashdata('message_error', 'Waktu upload telah habis.');
			redirect('home');
		}

		$config['upload_path']   = './uploads/bukti_transfer/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;
		$config['overwrite'] = TRUE;

		$ext = pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION);
		$config['file_name'] = $kode_booking . '.' . $ext;


		$this->load->library('upload', $config);

		if ($this->upload->do_upload('bukti_transfer')) {
			$data = $this->upload->data();

			$this->db->update('booking', [
				'bukti_transfer' => $data['file_name'],
				'status' => 'pending'
			], ['kode_booking' => $kode_booking]);

			$this->session->set_flashdata('message_success', 'Bukti transfer berhasil diunggah.');
			redirect('home/booking');
		} else {
			$this->session->set_flashdata('message_error', $this->upload->display_errors());

			print_r($this->upload->display_errors());
		}
	}

	private function format_nomor_wa($no_hp)
	{
		// Hilangkan semua karakter non-digit
		$no_hp = preg_replace('/[^0-9]/', '', $no_hp);

		// Jika diawali 0, ganti jadi 62
		if (substr($no_hp, 0, 1) === '0') {
			return '62' . substr($no_hp, 1);
		}

		// Jika sudah 62, tetap
		if (substr($no_hp, 0, 2) === '62') {
			return $no_hp;
		}

		// Jika tidak valid, kembalikan kosong atau error
		return '';
	}
}
