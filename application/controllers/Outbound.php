<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outbound extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['M_Auth', 'M_Outbound']);

        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_userdata('last_page', current_url());

            $this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');

            redirect('auth');
        }
    }

    public function indexs()
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
        $total_rows = $this->M_Outbound->countAWB($keyword);
        $current_page = $this->uri->segment(3) ? (int) $this->uri->segment(3) : 1;
        $total_pages = ceil($total_rows / $per_page);

        // Cek halaman pertama dan terakhir
        $is_first_page = $current_page <= 1;
        $is_last_page = $current_page >= $total_pages;

        // Konfigurasi pagination
        $config = [
            'base_url' => site_url('outbound/index'),
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
            "title" => "AWB",
            "page" => $page,
            "keyword" => $keyword,
            "segment" => "awb",
            "pages" => "pages/outbound/v_awb",
            "bookings" => $this->M_Outbound->listAwbPaginate($config["per_page"], $page, $keyword),
            // "partners" => $this->M_Partner->list_partner(),
            "total_rows" => $total_rows,
            "per_page" => $per_page,
        ];

        $this->load->view('pages/dashboard/index', $data);
    }

    public function awb()
    {
        $data = [
            'title' => 'AWB',
            'segment' => 'outbound',
            'pages' => 'pages/dashboard/outbound/v_awb',
        ];

        $this->load->view('pages/dashboard/index', $data);
    }
}
