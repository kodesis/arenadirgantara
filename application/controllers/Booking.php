<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination', 'Api_Whatsapp']);
        $this->load->model(['M_Auth', 'M_Booking']);

        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_userdata('last_page', current_url());

            $this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');

            redirect('auth');
        }
    }

    public function index()
    {
        // Ambil nilai per_page dari input POST atau session
        $per_page = ($this->input->post('show_per_page')) ? trim($this->input->post('show_per_page')) : (($this->session->userdata('show_per_page')) ? $this->session->userdata('show_per_page') : '10');
        if ($per_page === null) $per_page = $this->session->userdata('show_per_page');
        else $this->session->set_userdata('show_per_page', $per_page);

        // Ambil keyword pencarian dari POST atau session
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_booking')) ? $this->session->userdata('search_booking') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_booking');
        else $this->session->set_userdata('search_booking', $keyword);

        // Hitung total data dan halaman
        $total_rows = $this->M_Booking->countbooking($keyword);
        $current_page = $this->uri->segment(3) ? (int) $this->uri->segment(3) : 1;
        $total_pages = ceil($total_rows / $per_page);

        // Cek halaman pertama dan terakhir
        $is_first_page = $current_page <= 1;
        $is_last_page = $current_page >= $total_pages;

        // Konfigurasi pagination
        $config = [
            'base_url' => site_url('booking/index'),
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'uri_segment' => 3,
            'num_links' => 1,
            'use_page_numbers' => TRUE,

            'full_tag_open' => '<ul class="pagination pagination-flat">',
            'full_tag_close' => '</ul>',

            // Prev
            'prev_link' => '<span aria-hidden="true" class="mdi mdi-chevron-left"></span><span class="sr-only">Previous</span>',
            'prev_tag_open' => $is_first_page ? '<li class="page-item disabled">' : '<li class="page-item">',
            'prev_tag_close' => '</li>',

            // Next
            'next_link' => '<span aria-hidden="true" class="mdi mdi-chevron-right"></span><span class="sr-only">Next</span>',
            'next_tag_open' => $is_last_page ? '<li class="page-item disabled">' : '<li class="page-item">',
            'next_tag_close' => '</li>',

            // Tidak tampilkan tombol First dan Last
            'first_link' => false,
            'last_link' => false,

            // Halaman aktif
            'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',

            // Nomor biasa
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',

            // Class untuk semua link
            'attributes' => ['class' => 'page-link'],
        ];

        $this->pagination->initialize($config);

        // Hitung offset data
        $page = $this->uri->segment(3) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;

        // Data untuk dikirim ke view
        $data = [
            "title" => "Booking",
            "page" => $page,
            "keyword" => $keyword,
            "segment" => "booking",
            "pages" => "pages/dashboard/booking/v_booking",
            "bookings" => $this->M_Booking->listBookingPaginate($config["per_page"], $page, $keyword),
            // "destinations" => $this->db->order_by('destination', 'ASC')->get('mt_destination')->result(),
            "total_rows" => $total_rows,
            "per_page" => $per_page,
        ];

        // echo '<pre>';
        // print_r($data['bookings']);
        // echo '</pre>';
        // exit;

        $this->load->view('pages/dashboard/index', $data);
    }

    public function form_booking()
    {
        $data = [
            'title' => 'Create new booking',
            'segment' => 'booking',
            'pages' => 'pages/dashboard/booking/v_create_booking',
            'services' => $this->db->get('mt_service')->result(),
            'airlines' => $this->db->get('mt_airline')->result(),
            'payment_methods' => $this->db->get('mt_payment_method')->result(),
            'destinations' => $this->db->where('destination !=', 'CGK')->get('mt_destination')->result(),
        ];

        $this->load->view('pages/dashboard/index', $data);
    }

    public function detail()
    {
        $id = $this->input->post('id');

        $data = $this->M_Booking->get_by_id($id);

        $url_form = base_url('booking/process_booking/' . $id);

        $edit = [
            'url_form' => $url_form,
            'detail' => $data,
        ];

        $this->load->view('pages/dashboard/booking/v_modal', $edit);
    }

    public function process_booking()
    {
        $id = $this->input->post('id_booking');
        $status = $this->input->post('status');
        $alasan = $this->input->post('alasan_reject');

        $data_update = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($status === 'rejected') {
            $data_update['keterangan'] = $alasan;
        }

        $this->db->where('id', $id)->update('booking', $data_update);

        // Kirim notifikasi ke user
        $user = $this->db->get_where('booking', ['id' => $id])->row();
        $text_status = strtoupper($status);
        // $this->_send_notif(($status === 'rejected')
        // ? "Booking kamu ditolak. Alasan: $alasan"
        // : "Booking kamu telah dikonfirmasi.", $user);
        $pesan_wa = "*Booking Arena Dirgantara*%0A" .
            "Kode Booking: *$user->kode_booking*%0A" .
            "Nama: *$user->nama*%0A" .
            "Tanggal: *" . date('d-m-Y', strtotime($user->tanggal)) . "*%0A" .
            "Jam: *$user->jam_mulai - $user->jam_selesai*%0A" .
            "Harga: *Rp " . number_format($user->harga, 0, ',', '.') . "*%0A%0A" .
            "Status Booking: *$text_status*";

        // $no_hp_wa = format_nomor_wa($no_hp);
        $this->api_whatsapp->wa_notif($pesan_wa, $user->no_hp);

        redirect('booking');
    }



    function convertToNumber($formattedNumber)
    {
        // Mengganti titik sebagai pemisah ribuan dengan string kosong
        $numberWithoutThousandsSeparator = str_replace(',', '', $formattedNumber);

        $standardNumber = $numberWithoutThousandsSeparator;

        // Mengonversi string ke float
        return (float) $standardNumber;
    }

    public function clean_number($str)
    {
        // Hapus koma ribuan
        $number = str_replace(',', '', $str);

        // Cek apakah hasilnya numerik
        if (!is_numeric($number)) {
            $this->form_validation->set_message('clean_number', 'Field {field} harus berupa angka.');
            return FALSE;
        }

        return TRUE;
    }

    public function getPrice()
    {
        $origin = $this->input->post('origin');
        $destination = $this->input->post('destination');
        $jenis = $this->input->post('jenis_pengiriman');
        $airline = $this->input->post('airline');
        $chargeable = (float) $this->input->post('chargeable');

        // print_r($jenis);

        $this->db->where('jenis_rute', $jenis);
        $this->db->where('airline_code', $airline);
        $this->db->where('origin', $origin);
        $this->db->where('destination', $destination);
        $this->db->where('is_active', '1');

        $price = $this->db->get('routes_tariff')->row_array();

        $harga_jual = 0;
        $per_kg = 0;

        if ($price) {

            $per_kg = $price['price_per_kg'];
            $harga_jual = (float) $per_kg * $chargeable;
        }

        $data = [
            'chargeable' => $chargeable,
            'per_kg' => $per_kg,
            'harga_jual' => round($harga_jual)
        ];

        echo json_encode($data);
    }
}
