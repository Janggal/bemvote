<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Pemilih extends MY_Controller{

    public function __construct(){
      parent::__construct();
      $this->load->model('Pemilih_model', 'pemilih', TRUE);

      // Hanya bisa diakses Operator, Dekan, Rektor
      if($this->session->has_userdata('nim')) redirect('');

    }

    // Halaman Utama Pemilih
    public function index(){
      if($this->session->has_userdata('admin')) redirect('');
      if($this->session->has_userdata('dekan')) redirect('');
      if($this->session->has_userdata('rektor')) redirect('');

      if($this->session->userdata('hak_akses') === 'operator-teknik') $fakultas = 'Teknik';
      elseif($this->session->userdata('hak_akses') === 'operator-fekon') $fakultas = 'Ekonomi';
      elseif($this->session->userdata('hak_akses') === 'operator-fok') $fakultas = 'Olahraga & Kesehatan';
      elseif($this->session->userdata('hak_akses') === 'operator-fis') $fakultas = 'Ilmu Sosial';
      elseif($this->session->userdata('hak_akses') === 'operator-fip') $fakultas = 'Ilmu Pendidikan';
      elseif($this->session->userdata('hak_akses') === 'operator-pertanian') $fakultas = 'Pertanian';
      elseif($this->session->userdata('hak_akses') === 'operator-fsb') $fakultas = 'Sastra & Budaya';
      elseif($this->session->userdata('hak_akses') === 'operator-fik') $fakultas = 'Ilmu Kelautan';
      elseif($this->session->userdata('hak_akses') === 'operator-mipa') $fakultas = 'MIPA';

      $pemilihs = $this->pemilih->allPemilih($fakultas);
      $jumlahPemilih = $this->pemilih->jumlahPemilih($fakultas);
      $belumMemilihs = $this->pemilih->allPemilihBelumMemilih($fakultas);
      $jumlahBelumPemilih = $this->pemilih->jumlahBelumPemilih($fakultas);
      $fakultass = $this->pemilih->allFakultas();
      $input = (object) $this->pemilih->pemilihDefaultValues();
      $main_view = 'bem/pemilih';
      $this->load->view('template', compact('main_view', 'pemilihs', 'input', 'fakultass', 'belumMemilihs', 'pemilihFakultass', 'jumlahPemilih', 'jumlahBelumPemilih'));
    }

    // Halaman Pemilih untuk Admin, Dekan, Rektor
    public function pemilihadmin(){
      if($this->session->has_userdata('operator')) redirect('');

      $pemilihs = $this->pemilih->allPemilihAdmin();
      $totalPemilihAdmin = $this->pemilih->totalPemilihAdmin();
      $belumMemilihs = $this->pemilih->allPemilihBelumMemilihAdmin();
      $totalPemilihBelumMemilihAdmin = $this->pemilih->totalPemilihBelumMemilihAdmin();
      $fakultass = $this->pemilih->allFakultas();
      $input = (object) $this->pemilih->pemilihDefaultValues();
      $main_view = 'bem/pemilih-admin';
      $this->load->view('template', compact('main_view', 'pemilihs', 'input', 'fakultass', 'belumMemilihs', 'pemilihFakultass', 'totalPemilihAdmin', 'totalPemilihBelumMemilihAdmin'));
    }

    // Tambah Pemilih
    public function store(){
      if (!$this->cekLoginAdmin()) redirect('');
      if(!$this->input->post(null, TRUE)) redirect('');
      $input = (object) $this->input->post(null, TRUE);
      if(!$this->pemilih->validationPemilih()){
        $belumMemilihs = $this->pemilih->allPemilih();
        $pemilihFakultass = $this->pemilih->pemilihFakultas(1);
        $pemilihs = $this->pemilih->allPemilih();
        $fakultass = $this->pemilih->allFakultas();
        $main_view = "bem/pemilih";
        $this->load->view('template', compact('main_view', 'fakultass', 'input', 'pemilihs', 'pemilihFakultass', 'belumMemilihs'));
        return;
      }
      $this->pemilih->insertPemilih($input);
      $this->session->set_flashdata('msg', 'Pemilih Berhasil Di Tambahkan!');
      redirect('pemilih');
    }

    // Hapus Pemilih
    public function destroy(){
      if(!$this->cekLoginAdmin()) redirect('');
      if(!$this->input->post('id_pemilih', TRUE)) redirect('pemilih');
      $id = $this->input->post('id_pemilih', TRUE);
      if($this->pemilih->deletePemilih($id)){
        $this->session->set_flashdata('msg', 'Pemilih Berhasil Di Hapus!');
        redirect('pemilih');
      }
    }

    // Generate Token Pemilih
    public function gentoken(){
      if(!$this->session->has_userdata('operator')) redirect('');
      $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
      $token = '';
      for($i = 0; $i < 5; $i++){
        $pos = rand(0, strlen($karakter)-1);
        $token .= $karakter{$pos};
      }
      $id_pemilih = $this->input->post('id_pemilih', TRUE);
      $this->pemilih->generateToken($id_pemilih, $token);
      $this->session->set_flashdata('token', $token);
      redirect('pemilih');
    }

    // Melihat Token Pemilih
    public function looktoken(){
      if(!$this->session->has_userdata('operator')) redirect('');

      $token = $this->input->post('token_pemilih', TRUE);
      $this->session->set_flashdata('token', $token);
      redirect('pemilih');
    }

    public function search(){
      if($this->session->has_userdata('admin')) redirect('');
      if($this->session->has_userdata('dekan')) redirect('');
      if($this->session->has_userdata('rektor')) redirect('');

      if($this->session->userdata('hak_akses') === 'operator-teknik') $fakultas = 'Teknik';
      elseif($this->session->userdata('hak_akses') === 'operator-fekon') $fakultas = 'Ekonomi';
      elseif($this->session->userdata('hak_akses') === 'operator-fok') $fakultas = 'Olahraga & Kesehatan';
      elseif($this->session->userdata('hak_akses') === 'operator-fis') $fakultas = 'Ilmu Sosial';
      elseif($this->session->userdata('hak_akses') === 'operator-fip') $fakultas = 'Ilmu Pendidikan';
      elseif($this->session->userdata('hak_akses') === 'operator-pertanian') $fakultas = 'Pertanian';
      elseif($this->session->userdata('hak_akses') === 'operator-fsb') $fakultas = 'Sastra & Budaya';
      elseif($this->session->userdata('hak_akses') === 'operator-fik') $fakultas = 'Ilmu Kelautan';
      elseif($this->session->userdata('hak_akses') === 'operator-mipa') $fakultas = 'MIPA';

      $nim = $this->input->get('nim', true);
      $nama = $this->input->get('nama', true);

      $pemilihs = $this->pemilih->searchPemilih($nim, $nama, $fakultas);
      $jumlahSearchPemilih = $this->pemilih->jumlahSearchPemilih($nim, $nama, $fakultas);

      $main_view = 'bem/search-pemilih';
      $this->load->view('template', compact('main_view', 'pemilihs', 'nim', 'nama', 'jumlahSearchPemilih'));
    }

    public function searchajax(){
      if($this->session->has_userdata('admin')) redirect('');
      if($this->session->has_userdata('dekan')) redirect('');
      if($this->session->has_userdata('rektor')) redirect('');

      if($this->session->userdata('hak_akses') === 'operator-teknik') $fakultas = 'Teknik';
      elseif($this->session->userdata('hak_akses') === 'operator-fekon') $fakultas = 'Ekonomi';
      elseif($this->session->userdata('hak_akses') === 'operator-fok') $fakultas = 'Olahraga & Kesehatan';
      elseif($this->session->userdata('hak_akses') === 'operator-fis') $fakultas = 'Ilmu Sosial';
      elseif($this->session->userdata('hak_akses') === 'operator-fip') $fakultas = 'Ilmu Pendidikan';
      elseif($this->session->userdata('hak_akses') === 'operator-pertanian') $fakultas = 'Pertanian';
      elseif($this->session->userdata('hak_akses') === 'operator-fsb') $fakultas = 'Sastra & Budaya';
      elseif($this->session->userdata('hak_akses') === 'operator-fik') $fakultas = 'Ilmu Kelautan';
      elseif($this->session->userdata('hak_akses') === 'operator-mipa') $fakultas = 'MIPA';

      $nim = $this->input->get('nim', true);
      $nama = $this->input->get('nama', true);

      $pemilihs = $this->pemilih->searchPemilih($nim, $nama, $fakultas);
      $jumlahSearchPemilih = $this->pemilih->jumlahSearchPemilih($nim, $nama, $fakultas);

      $main_view = 'bem/search-pemilih-ajax';
      $this->load->view('template', compact('main_view', 'pemilihs', 'nim', 'nama', 'jumlahSearchPemilih'));
    }

    public function searchpemilihadmin(){
      if($this->session->has_userdata('operator')) redirect('');

      $nim = $this->input->get('nim', true);
      $nama = $this->input->get('nama', true);
      $pemilihs = $this->pemilih->searchPemilihByAdmin($nim, $nama);
      $jumlahsearchPemilihByAdmin = $this->pemilih->jumlahsearchPemilihByAdmin($nim, $nama);
      $main_view = 'bem/search-pemilih-admin';
      $this->load->view('template', compact('main_view', 'pemilihs', 'nim', 'nama','jumlahsearchPemilihByAdmin'));
    }

    public function searchadminajax(){
      if($this->session->has_userdata('operator')) redirect('');

      $nim = $this->input->get('nim', true);
      $nama = $this->input->get('nama', true);
      $pemilihs = $this->pemilih->searchPemilihByAdmin($nim, $nama);
      $jumlahsearchPemilihByAdmin = $this->pemilih->jumlahsearchPemilihByAdmin($nim, $nama);
      $main_view = 'bem/search-pemilih-admin-ajax';
      $this->load->view('template', compact('main_view', 'pemilihs', 'nim', 'nama','jumlahsearchPemilihByAdmin'));
    }


  }
