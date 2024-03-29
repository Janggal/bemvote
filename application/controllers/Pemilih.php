<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Pemilih extends MY_Controller{

    public function __construct(){
      parent::__construct();
      $this->load->model('Pemilih_model', 'pemilih', TRUE);
      $this->load->library('pagination');

      // Hanya bisa diakses Operator, Dekan, Rektor
      if($this->session->has_userdata('nim')) redirect('');

    }

    // Halaman Utama Pemilih
    public function index($page = null){
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

      $perPage = 25;
      if($page === null) $offset = 0;
      else $offset = ($page * $perPage) - $perPage;

      $pemilihs = $this->pemilih->allPemilih($fakultas, $perPage, $offset);
      $jumlahPemilih = $this->pemilih->jumlahPemilih($fakultas);
      $belumMemilihs = $this->pemilih->allPemilihBelumMemilih($fakultas, $perPage, $offset);
      $jumlahBelumPemilih = $this->pemilih->jumlahBelumPemilih($fakultas);
      $fakultass = $this->pemilih->allFakultas();
      $input = (object) $this->pemilih->pemilihDefaultValues();

      $config['base_url'] = base_url('pemilih');
      $config['total_rows'] = $jumlahPemilih;
      $config['per_page'] = $perPage;
      $config['use_page_numbers'] = true;
      $config['next_link'] = 'Selanjutnya';
      $config['prev_link'] = 'Sebelumnya';
      $config['first_link'] = 'Pertama';
      $config['last_link'] = 'Terakhir';
      $config['num_links'] = '2';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['last_tag_open'] = "<li class='page-item'>";
      $config['last_tag_close'] = '</li>';
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = '</li>';
      $config['prev_tag_open'] = "<li class='page-item'>";
      $config['prev_tag_close'] = '</li>';
      $config['cur_tag_open'] = "<li class='page-item'><span class='page-link'>";
      $config['cur_tag_close'] = "<span class='sr-only'>(current)</span></span></li>";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = '</li>';
      $config['attributes'] = array('class' => 'page-item');
      $this->pagination->initialize($config);
      $pagination = $this->pagination->create_links();

      $main_view = 'bem/pemilih';
      $this->load->view('template', compact('main_view', 'pemilihs', 'input', 'fakultass', 'belumMemilihs', 'pemilihFakultass', 'jumlahPemilih', 'jumlahBelumPemilih', 'pagination'));
    }

    // Halaman Pemilih untuk Admin, Dekan, Rektor
    public function pemilihadmin($page = null){
      if($this->session->has_userdata('operator')) redirect('');

      $perPage = 25;
      if($page === null) $offset = 0;
      else $offset = ($page * $perPage) - $perPage;

      $pemilihs = $this->pemilih->allPemilihAdmin($perPage, $offset);
      $totalPemilihAdmin = $this->pemilih->totalPemilihAdmin();
      $belumMemilihs = $this->pemilih->allPemilihBelumMemilihAdmin($perPage, $offset);
      $totalPemilihBelumMemilihAdmin = $this->pemilih->totalPemilihBelumMemilihAdmin();
      $fakultass = $this->pemilih->allFakultas();
      $input = (object) $this->pemilih->pemilihDefaultValues();

      $config['base_url'] = base_url('pemilih-admin');
      $config['total_rows'] = $totalPemilihAdmin;
      $config['per_page'] = $perPage;
      $config['use_page_numbers'] = true;
      $config['next_link'] = 'Selanjutnya';
      $config['prev_link'] = 'Sebelumnya';
      $config['first_link'] = 'Pertama';
      $config['last_link'] = 'Terakhir';
      $config['num_links'] = '2';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['last_tag_open'] = "<li class='page-item'>";
      $config['last_tag_close'] = '</li>';
      $config['next_tag_open'] = "<li class='page-item'>";
      $config['next_tag_close'] = '</li>';
      $config['prev_tag_open'] = "<li class='page-item'>";
      $config['prev_tag_close'] = '</li>';
      $config['cur_tag_open'] = "<li class='page-item'><span class='page-link'>";
      $config['cur_tag_close'] = "<span class='sr-only'>(current)</span></span></li>";
      $config['num_tag_open'] = "<li class='page-item'>";
      $config['num_tag_close'] = '</li>';
      $config['attributes'] = array('class' => 'page-item');
      $this->pagination->initialize($config);
      $pagination = $this->pagination->create_links();

      $main_view = 'bem/pemilih-admin';
      $this->load->view('template', compact('main_view', 'pemilihs', 'input', 'fakultass', 'belumMemilihs', 'pemilihFakultass', 'totalPemilihAdmin', 'totalPemilihBelumMemilihAdmin', 'pagination'));
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
