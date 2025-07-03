<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_Auth');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        } else {
            if ($this->form_validation->run() ==  false) {
                $data = [
                    "title" => "Login",
                    "pages" => "pages/auth/v_login"
                ];
                $this->load->view('pages/auth/index', $data);
            } else {
                // validasinya sukses
                $this->_login();
            }
        }
    }

    private function _login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->M_Auth->get_user_data($username, $password);

        if (!$user) {
            return $this->_setFlashRedirect("Username has not been registered.");
        }

        if (!$user['is_active']) {
            return $this->_setFlashRedirect("Username has not been activated.");
        }

        if (!password_verify($password, $user['password'])) {
            return $this->_setFlashRedirect("Wrong password.");
        }

        // Login berhasil
        $this->session->set_userdata([
            'user_id'       => $user['id_user'],
            'username'      => $user['username'],
            'name'          => $user['name'],
            'role'       => $user['role'],
            'is_logged_in'  => true,
        ]);

        // Jika password sama dengan username, beri peringatan
        if ($password == strtolower($username)) {
            $this->session->set_flashdata('message_warning', '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Anda masih menggunakan password bawaan. Silahkan perbarui password!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }

        // Redirect ke halaman terakhir atau dashboard
        $redirect = $this->session->userdata('last_page') ?? 'dashboard';
        redirect($redirect);
    }

    private function _setFlashRedirect($message)
    {
        $this->session->set_flashdata('alert_info', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('auth');
    }


    public function registration()
    {
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'The email has already registered'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'The username has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() ==  false) {

            $data = [
                'title' => 'User Registration',
                'pages' => 'pages/auth/v_registration',
            ];

            $this->load->view('pages/auth/index', $data);
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'username' => $this->input->post('username'),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => '2',
                'is_active' => '1',
                'date_created' => time()
            ];

            $this->M_Auth->registration($data);
        }
    }

    public function change_password($id)
    {
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
        }
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'username',
            'name',
            'jabatan',
            'email',
            'role_id',
            'is_logged_in',
            'last_page',
        ]);

        $this->session->set_flashdata('alert_info', '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                You have been logout.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');

        redirect('auth');
    }


    public function forbidden()
    {
        $this->load->view('errors/html/error_403');
    }

    public function updateStatusUser()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (!in_array($status, ['0', '1'])) {
            $response = array('success' => false, 'message' => 'Status tidak valid.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $user = $this->M_Auth->get_user_data_by_id($id);

        if (empty($user)) {
            $response = array('success' => false, 'message' => 'Data customer tidak ditemukan.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $data = [
            'is_active' => $status
        ];

        $this->db->trans_begin();

        if ($this->M_Auth->update_user($id, $data)) {
            $this->db->trans_commit();

            if ($status == '1') {
                $message = "Akun telah diaktifkan.";
            } else {
                $message = "Akun telah dinonaktifkan.";
            }
        } else {

            $this->db->trans_rollback();
            $response = array('success' => false, 'message' => 'Gagal memperbarui status.');
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $response = array('success' => true, 'status' => $status, 'message' => $message);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
