<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Login_model extends CI_Model{

    // Pengecekan nim & token pemilih
    public function checkPemilih($nim, $token){
      return $this->db->where('nim_pemilih', $nim)->where('token_pemilih', $token)->get('pemilih')->row();
    }

    // Pengecekan username & password admin
    public function checkAdmin($username, $password){
      return $this->db->where('username_admin', $username)->where('password_admin', $password)->get('admin')->row();
    }

    // Fitur Mengaktifkan Status Pemilih
    public function aktifkanStatusPemilih($nim){
      $sql = "update pemilih set status_pemilih = 'ya' where nim_pemilih = '$nim'";
      return $this->db->query($sql);
    }

    // Nilai bawaan form login
    public function loginDefaultValues(){
      return [
        'token' => '',
        'nim' => '',
        'username' => '',
        'password' => ''
      ];
    }

    // Set Login terakhir pemilih
    public function loginTerakhirPemilih($nim){
      $sql = "update pemilih set terakhir_login = NOW() where nim_pemilih = '$nim'";
      return $this->db->query($sql);
    }

    // Set login terakhir admin
    public function loginTerakhirAdmin($id){
      $sql = "update admin set login_terakhir = NOW() where id_admin = '$id'";
      return $this->db->query($sql);
    }

  }
