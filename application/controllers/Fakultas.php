<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Fakultas extends MY_Controller{

    public function __construct(){
      parent::__construct();
      $this->load->model('Fakultas_model', 'fakultas', TRUE);

      // Hanya bisa diakses Admin
      if (!$this->cekLoginAdmin()) {
        redirect('');
      }

    }

    // Halaman Utama Fakultas
    public function index(){
      $fakultass = $this->fakultas->allFakultas();
      $main_view = 'bem/fakultas';
      $totalFakultas = $this->fakultas->totalFakultas();
      $input = (object) $this->fakultas->fakultasDefaultValues();
      $this->load->view('template', compact('main_view', 'fakultass', 'input', 'totalFakultas'));
    }

    // Tambah Fakultas
    public function store(){
      if(!$this->input->post(null, TRUE)) redirect('');
      $input = (object) $this->input->post(null, TRUE);
      if(!$this->fakultas->validationFakultas()){
        $fakultass = $this->fakultas->allFakultas();
        $main_view = "bem/fakultas";
        $this->load->view('template', compact('main_view', 'fakultass', 'input'));
        return;
      }
      $this->fakultas->insertFakultas($input);
      $this->session->set_flashdata('msg', 'Fakultas Berhasil Di Tambahkan!');
      redirect('fakultas');
    }

    // Halaman Edit Fakultas
    public function edit($id){
      $fakultas = $this->fakultas->getFakultas($id);
      if(!$fakultas) redirect('fakultas');
      $main_view = 'bem/edit-fakultas';
      $this->load->view('template', compact('main_view', 'fakultas'));
    }

    // Edit Fakultas
    public function update(){
      if(!$this->input->post(null, TRUE)) redirect('fakultas');
      $id_fakultas = $this->input->post('id_fakultas', TRUE);
      $fakultas['nama_fakultas'] = $this->input->post('nama_fakultas', TRUE);
      $fakultas['id_fakultas'] = $this->input->post('id_fakultas', TRUE);
      if(!$this->fakultas->validationFakultas()){
        $fakultas = (object) $fakultas;
        $main_view = "bem/edit-fakultas";
        $this->load->view('template', compact('main_view', 'fakultas'));
        return;
      }
      $this->fakultas->updateFakultas($id_fakultas, $fakultas);
      $this->session->set_flashdata('msg', 'Fakultas Berhasil Di Edit!');
      redirect('fakultas');
    }

    // Hapus Fakultas
    public function destroy(){
      if(!$this->input->post('id_fakultas', TRUE)) redirect('fakultas');
      $id = $this->input->post('id_fakultas', TRUE);
      if($this->fakultas->deleteFakultas($id)){
        $this->session->set_flashdata('msg', 'Fakultas Berhasil Di Hapus!');
        redirect('fakultas');
      }
    }

  }
