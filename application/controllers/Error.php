<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller
{
    public function csrf()
    {
        show_error("Akses tidak sah. Token CSRF tidak valid.", 403, "CSRF Verification Failed");
    }
}
