<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom404 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // load base_url
        $this->load->helper('url');
    }

    public function index()
    {
        $this->output->set_status_header('404');
        $data = [
            'title' => "Not found"
        ];

        $this->load->view('errors/html/error_404', $data);
    }
}
