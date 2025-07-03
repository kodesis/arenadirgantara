<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination']);
        $this->load->model(['M_Auth', 'M_Customer', 'M_Deposit']);

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
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_customer')) ? $this->session->userdata('search_customer') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_customer');
        else $this->session->set_userdata('search_customer', $keyword);

        // Hitung total data dan halaman
        $total_rows = $this->M_Customer->countCustomer($keyword);
        $current_page = $this->uri->segment(3) ? (int) $this->uri->segment(3) : 1;
        $total_pages = ceil($total_rows / $per_page);

        // Cek halaman pertama dan terakhir
        $is_first_page = $current_page <= 1;
        $is_last_page = $current_page >= $total_pages;

        // Konfigurasi pagination
        $config = [
            'base_url' => site_url('customer/index'),
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
            "title" => "Customer",
            "page" => $page,
            "keyword" => $keyword,
            "segment" => "customer",
            "pages" => "pages/dashboard/customer/v_customer",
            "customers" => $this->M_Customer->listCustomerPaginate($config["per_page"], $page, $keyword),
            "total_rows" => $total_rows,
            "per_page" => $per_page,
        ];

        $this->load->view('pages/dashboard/index', $data);
    }

    public function create_customer()
    {
        $this->form_validation->set_rules('name', 'Customer Name', 'required');
        $this->form_validation->set_rules('whatsapp_number', 'WhatsApp Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $nama    = $this->input->post('name');
        $wa      = $this->input->post('whatsapp_number');
        $alamat  = $this->input->post('address');

        $username = preg_replace('/[^a-z0-9]+/', '_', strtolower($nama));
        $password = $username;

        // Cek duplikat username dan nama
        if ($this->M_Auth->username_exists($username) || $this->M_Customer->nama_exists($nama)) {
            echo json_encode([
                'status' => 'error',
                'errors' => ['name' => 'Customer dengan nama ini sudah terdaftar.']
            ]);
            return;
        }

        // Mulai transaksi
        $this->db->trans_start();

        $user_id = $this->M_Auth->create_customer_account($username, $password);

        $data_customer = [
            'user_id'           => $user_id,
            'name'     => $nama,
            'whatsapp_number'   => $wa,
            'address'           => $alamat,
        ];

        $this->M_Customer->create_profile($data_customer);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Rollback terjadi
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data customer.'
            ]);
        } else {
            // Commit berhasil
            echo json_encode([
                'status' => 'success',
                'message' => 'Customer berhasil ditambahkan.'
            ]);
        }
    }
}
