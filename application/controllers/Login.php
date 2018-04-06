<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Login extends CI_Controller{

    public function __construct(){
      parent::__construct();
      $this->load->model('Login_model', 'login', TRUE);
    }

    // Login Mahasiswa
    public function index(){
      if(!$this->input->post(null, TRUE)){
        $input = (object) $this->login->loginDefaultValues();
        $this->load->view('bem/login', compact('input'));

        if($this->session->userdata('login')){
          redirect('');
          return;
        }
      }else{
        $nim = $this->input->post('nim', TRUE);
        $token = $this->input->post('token', TRUE);
        $pemilih = $this->login->checkPemilih($nim, $token);

        if(count($pemilih)){
          if ($pemilih->telah_memilih === 'tidak') {
            $data = [
              'login' => TRUE,
              'id_pemilih' => $pemilih->id_pemilih,
              'nim' => $pemilih->nim_pemilih,
              'nama' => $pemilih->nama_pemilih,
              'user' => 'Mahasiswa',
              'pemilih' => TRUE
            ];
          }else{
            $data = [
              'login' => TRUE,
              'id_pemilih' => $pemilih->id_pemilih,
              'nim' => $pemilih->nim_pemilih,
              'nama' => $pemilih->nama_pemilih,
              'user' => 'Mahasiswa'
            ];
          }

          $this->session->set_userdata($data);
          $this->login->aktifkanStatusPemilih($this->session->userdata('nim'));
          $this->login->loginTerakhirPemilih($this->session->userdata('nim'));
          if($this->session->userdata('login')){
            redirect('');
            return;
          }
        }else{
          $this->session->set_flashdata('error_msg', 'NIM dan/atau Token Anda Salah');
          $input = (object) $this->input->post(null, TRUE);
          $this->load->view('bem/login', compact('input'));
        }
      }
    }

    // Login Admin, Operator, Dekan, Rektor
    public function admin(){
      if(!$this->input->post(null, TRUE)){
        $input = (object) $this->login->loginDefaultValues();
        $this->load->view('bem/login-admin', compact('input'));

        if($this->session->userdata('login')){
          redirect('');
          return;
        }
      }else{
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $admin = $this->login->checkAdmin($username, $password);

        if(count($admin)){
          if ($admin->hak_akses === 'admin') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'Admin',
              'admin' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-teknik') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP Teknik',
              'fakultas' => 'Teknik',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fekon') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP Ekonomi',
              'fakultas' => 'Ekonomi',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fok') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP FOK',
              'fakultas' => 'Olahraga & Kesehatan',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fis') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP FIS',
              'fakultas' => 'Ilmu Sosial',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fip') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP FIP',
              'fakultas' => 'Ilmu Pendidikan',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-hukum') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP Hukum',
              'fakultas' => 'Hukum',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-pertanian') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP Faperta',
              'fakultas' => 'Pertanian',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fsb') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP FSB',
              'fakultas' => 'Sastra & Budaya',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-fik') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP FIK',
              'fakultas' => 'Ilmu Kelautan',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'operator-mipa') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'OP MIPA',
              'fakultas' => 'MIPA',
              'operator' => TRUE
            ];
          }elseif ($admin->hak_akses === 'dekan') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'Dekan',
              'dekan' => TRUE
            ];
          }elseif ($admin->hak_akses === 'rektor') {
            $data = [
              'login' => TRUE,
              'id_admin' => $admin->id_admin,
              'username' => $admin->username_admin,
              'hak_akses' => $admin->hak_akses,
              'user' => 'Rektor',
              'rektor' => TRUE
            ];
          }

          $this->session->set_userdata($data);
          $this->login->loginTerakhirAdmin($this->session->userdata('id_admin'));
          if($this->session->userdata('login')){
            redirect('');
            return;
          }
        }else{
          $this->session->set_flashdata('error_msg', 'Username dan/atau Password Salah');
          $input = (object) $this->input->post(null, TRUE);
          $this->load->view('bem/login-admin', compact('input'));
        }
      }
    }

    // Logout all user
    public function logout(){
      $this->session->sess_destroy();
      redirect('');
    }

  }
