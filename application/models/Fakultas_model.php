<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Fakultas_model extends CI_Model{

    // Mendapatkan semua data Fakultas
    public function allFakultas(){
      return $this->db->get('fakultas')->result();
    }

    public function totalFakultas(){
      return $this->db->get('fakultas')->num_rows();
    }

    // Nilai bawaan form Fakultas
    public function fakultasDefaultValues(){
      return [
        'nama_fakultas' => ''
      ];
    }

    // Mendapatkan suatu Fakultas
    public function getFakultas($id){
      return $this->db->where('id_fakultas', $id)->get('fakultas')->row();
    }

    // Edit Fakultas
    public function updateFakultas($id, $data){
      return $this->db->where('id_fakultas', $id)->update('fakultas', $data);
    }

    // Hapus Fakultas
    public function deleteFakultas($id){
      return $this->db->where('id_fakultas', $id)->delete('fakultas');
    }

    // Validasi form fakultas
    public function validationFakultas(){
      $this->load->library('form_validation');
      $rules = [
        [
          'field' => 'nama_fakultas',
          'label' => 'Nama Fakultas',
          'rules' => 'trim|required'
        ]
      ];
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="text-center mb-3" style="color:red; border:1px solid red; padding:5px">', '</div>');
      return $this->form_validation->run();
    }

    // Menambahkan Fakultas
    public function insertFakultas($data){
      return $this->db->insert('fakultas', $data);
    }

  }
