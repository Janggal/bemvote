<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Pemilih_model extends CI_Model{

    // Semua data pemilih
    public function allPemilih($fakultas, $perPage = 25, $offset = 0){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('nama_fakultas', $fakultas)->limit($perPage, $offset)->order_by('nim_pemilih', 'ASC')->get()->result();
    }

    // Total pemilih
    public function jumlahPemilih($fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('nama_fakultas', $fakultas)->order_by('nim_pemilih', 'ASC')->get()->num_rows();
    }

    public function jumlahBelumPemilih($fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilih.telah_memilih', 'tidak')->where('nama_fakultas', $fakultas)->get()->num_rows();
    }

    // Semua data pemilih yang belum memilih
    public function allPemilihBelumMemilih($fakultas, $perPage = 25, $offset = 0){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilih.telah_memilih', 'tidak')->where('nama_fakultas', $fakultas)->limit($perPage, $offset)->get()->result();
    }

    // Semua data pemilih yg bisa diakses admin, dekan, rektor
    public function allPemilihAdmin($perPage = 25, $offset = 0){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->limit($perPage, $offset)->order_by('nim_pemilih', 'ASC')->get()->result();
    }

    public function totalPemilihAdmin(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->order_by('nim_pemilih', 'ASC')->get()->num_rows();
    }

    // Semua data pemilih yang belum memilih
    public function allPemilihBelumMemilihAdmin($perPage = 25, $offset = 0){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilih.telah_memilih', 'tidak')->limit($perPage, $offset)->get()->result();
    }

    public function totalPemilihBelumMemilihAdmin(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    // Data Semua Fakultas
    public function allFakultas(){
      return $this->db->get('fakultas')->result();
    }

    // Nilai bawaan form pemilih
    public function pemilihDefaultValues(){
      return [
        'nama_pemilih' => '',
        'nim_pemilih' => ''
      ];
    }

    // Mendapatkan Data suatu pemilih
    public function getPemilih($id){
      return $this->db->where('id_pemilih', $id)->get('pemilih')->row();
    }

    // Hapus Pemilih
    public function deletePemilih($id){
      return $this->db->where('id_pemilih', $id)->delete('pemilih');
    }

    // Validasi form pemilih
    public function validationPemilih(){
      $this->load->library('form_validation');
      $rules = [
        [
          'field' => 'nama_pemilih',
          'label' => 'Nama Pemilih',
          'rules' => 'trim|required'
        ],
        [
          'field' => 'nim_pemilih',
          'label' => 'NIM Pemilih',
          'rules' => 'trim|required'
        ]
      ];
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="text-center mb-3" style="color:red; border:1px solid red; padding:5px">', '</div>');
      return $this->form_validation->run();
    }

    // Tambah Pemilih
    public function insertPemilih($data){
      return $this->db->insert('pemilih', $data);
    }

    // Data Semua pemilih Berdasarkan Fakultas
    public function pemilihFakultas($id){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilih.id_fakultas', $id)->get()->result();
    }

    // Menggenerate Token Pemilih
    public function generateToken($id, $data){
      $sql = "update pemilih set token_pemilih = '$data' where id_pemilih = $id";
      return $this->db->query($sql);
    }

    // mencari pemilih berdasarkan nim
    public function searchPemilih($nim, $nama, $fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('nama_fakultas', $fakultas)->like('nim_pemilih', $nim)->like('nama_pemilih', $nama)->order_by('nim_pemilih', 'ASC')->get()->result();
    }

    public function jumlahSearchPemilih($nim, $nama, $fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('nama_fakultas', $fakultas)->like('nim_pemilih', $nim)->like('nama_pemilih', $nama)->order_by('nim_pemilih', 'ASC')->get()->num_rows();
    }

    // mencari pemilih berdasarkan nim
    public function searchPemilihByAdmin($nim, $nama){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->like('nim_pemilih', $nim)->like('nama_pemilih', $nama)->order_by('nim_pemilih', 'ASC')->get()->result();
    }

    public function jumlahsearchPemilihByAdmin($nim, $nama){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->like('nim_pemilih', $nim)->like('nama_pemilih', $nama)->order_by('nim_pemilih', 'ASC')->get()->num_rows();
    }

  }
