<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tariff extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination']);
        $this->load->model(['M_Auth', 'M_Tariff']);

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
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search_tariff')) ? $this->session->userdata('search_tariff') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search_tariff');
        else $this->session->set_userdata('search_tariff', $keyword);

        // Hitung total data dan halaman
        $total_rows = $this->M_Tariff->countTariff($keyword);
        $current_page = $this->uri->segment(3) ? (int) $this->uri->segment(3) : 1;
        $total_pages = ceil($total_rows / $per_page);

        // Cek halaman pertama dan terakhir
        $is_first_page = $current_page <= 1;
        $is_last_page = $current_page >= $total_pages;

        // Konfigurasi pagination
        $config = [
            'base_url' => site_url('tariff/index'),
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
            "title" => "Tarif",
            "page" => $page,
            "keyword" => $keyword,
            "segment" => "tariff",
            "pages" => "pages/dashboard/tariff/v_tariff",
            "tariffs" => $this->M_Tariff->listTariffPaginate($config["per_page"], $page, $keyword),
            "destinations" => $this->db->order_by('destination', 'ASC')->get('mt_destination')->result(),
            "total_rows" => $total_rows,
            "per_page" => $per_page,
        ];

        $this->load->view('pages/dashboard/index', $data);
    }

    public function store_tariff()
    {
        if (!$this->_validate()) {
            echo json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $origin = $this->input->post('origin');
        $destination = $this->input->post('destination');
        $airline = $this->input->post('airline');
        $price_per_kg = $this->input->post('price_per_kg');

        if ($this->M_Tariff->check_duplicate($origin, $destination, $airline)) {
            echo json_encode([
                'status' => 'error',
                'errors' => ['name' => 'Tarif dengan tujuan dan maskapai ini sudah terdaftar.']
            ]);
            return;
        }

        // Mulai transaksi
        $this->db->trans_start();

        $data = [
            'origin' => $origin,
            'destination' => $destination,
            'airline_code' => $airline,
            'price_per_kg' => $this->convertToNumberWithComma($price_per_kg),
        ];

        $nama = $origin . '-' . $destination . ' ' . $airline;

        $this->M_Tariff->add_tariff($data);

        // Selesaikan transaksi
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
                'message' => 'Tarif ' . $nama . ' berhasil ditambahkan.'
            ]);
        }
    }

    public function formEdit()
    {
        $id = $this->input->post('id');

        $data = $this->M_Tariff->get_by_id($id);

        $url_form = base_url('tariff/update/' . $id);

        $edit = [
            'url_form'      => $url_form,
            'origin'        => $data['origin'],
            'destination'   => $data['destination'],
            'airline_code'  => $data['airline_code'],
            'price_per_kg'  => $data['price_per_kg'],
            'destinations'  => $this->db->order_by('destination', 'ASC')->get('mt_destination')->result(),
        ];

        $this->load->view('pages/dashboard/tariff/v_modal', $edit);
    }

    public function update($id)
    {
        $this->_validate();

        $data = [
            'origin'        => $this->input->post('origin'),
            'destination'   => $this->input->post('destination'),
            'airline_code'  => $this->input->post('airline'),
            'price_per_kg'  => $this->convertToNumberWithComma($this->input->post('price_per_kg')),
        ];

        $this->db->trans_start();
        $this->M_Tariff->update($id, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Rollback terjadi
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data tarif.'
            ]);
        } else {
            // Commit berhasil
            echo json_encode([
                'status' => 'success',
                'message' => 'Tarif berhasil diperbarui.'
            ]);
        }
    }

    public function delete($id)
    {
        $this->db->trans_start();
        $this->M_Tariff->delete($id);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menghapus tariff.');
        } else {
            $this->session->set_flashdata('success', 'Tariff berhasil dihapus.');
        }

        redirect('admin/tariff');
    }

    private function _validate()
    {
        $this->form_validation->set_rules('origin', 'Origin', 'required');
        $this->form_validation->set_rules('destination', 'Destination', 'required');
        $this->form_validation->set_rules('airline', 'Airline', 'required');
        $this->form_validation->set_rules('price_per_kg', 'Tariff per Kg', 'required|callback_clean_number');


        return $this->form_validation->run();
    }


    function convertToNumberWithComma($formattedNumber)
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
}
