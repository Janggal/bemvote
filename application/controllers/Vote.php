<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Vote extends MY_Controller{

    public function __construct(){
      parent::__construct();
      $this->load->model('Vote_model', 'vote', TRUE);
      $this->load->model('Paslon_model', 'paslon', TRUE);
    }

    // Fitur Mencoblos
    public function index(){
      if($this->input->post('coblos', TRUE)) {
        $data = [
          'id_pemilih' => $this->input->post('id_pemilih', TRUE),
          'id_paslon' => $this->input->post('id_paslon', TRUE)
        ];

        $pemilih = $this->vote->pemilih($this->session->userdata('id_pemilih'));
        if ($pemilih->telah_memilih === 'tidak') {
          $this->vote->coblosPaslon($data);
        }

        $this->vote->setTelahMemilih($this->session->userdata('id_pemilih'));
        $this->session->unset_userdata('pemilih');
        $this->session->set_flashdata('mencoblos', TRUE);
        redirect('');
      }else{
        $paslons = $this->vote->allPaslon();
        $capress = $this->paslon->allCapres();
        $cawapress = $this->paslon->allCawapres();
        $main_view = 'bem/index';
        $this->load->view('template', compact('main_view', 'paslons', 'capress', 'cawapress'));
      }
    }

    // Halaman Pemilihan
    public function pemilihan(){
      if(!$this->cekLoginAdmin()) redirect('');
      $suaraMasuks = $this->vote->suaraMasuk();
      $totalSuaraMasuk = $this->vote->totalSuaraMasuk();
      $main_view = 'bem/pemilihan';
      $this->load->view('template', compact('main_view', 'suaraMasuks', 'totalSuaraMasuk'));
    }

    // Fitur Statistik Pemilihan
    public function stat(){
      if($this->session->has_userdata('nim')) redirect('');
      if($this->session->has_userdata('operator')) redirect('');

      $totalPemilihTeknik = $this->vote->totalPemilihTeknik();
      $totalSuaraMasukTeknik = $this->vote->totalSuaraMasukTeknik();
      $totalTidakMemilihTeknik = $this->vote->totalTidakMemilihTeknik();
      $totalSuaraMasukTeknikStat = $this->vote->totalSuaraMasukTeknikStat();

      $totalPemilihFIP = $this->vote->totalPemilihFIP();
      $totalSuaraMasukFIP = $this->vote->totalSuaraMasukFIP();
      $totalTidakMemilihFIP = $this->vote->totalTidakMemilihFIP();
      $totalSuaraMasukFIPStat = $this->vote->totalSuaraMasukFIPStat();

      $totalPemilihMIPA = $this->vote->totalPemilihMIPA();
      $totalSuaraMasukMIPA = $this->vote->totalSuaraMasukMIPA();
      $totalTidakMemilihMIPA = $this->vote->totalTidakMemilihMIPA();
      $totalSuaraMasukMIPAStat = $this->vote->totalSuaraMasukMIPAStat();

      $totalPemilihEkonomi = $this->vote->totalPemilihEkonomi();
      $totalSuaraMasukEkonomi = $this->vote->totalSuaraMasukEkonomi();
      $totalTidakMemilihEkonomi = $this->vote->totalTidakMemilihEkonomi();
      $totalSuaraMasukEkonomiStat = $this->vote->totalSuaraMasukEkonomiStat();

      $totalPemilihFOK = $this->vote->totalPemilihFOK();
      $totalSuaraMasukFOK = $this->vote->totalSuaraMasukFOK();
      $totalTidakMemilihFOK = $this->vote->totalTidakMemilihFOK();
      $totalSuaraMasukFOKStat = $this->vote->totalSuaraMasukFOKStat();

      $totalPemilihFIS = $this->vote->totalPemilihFIS();
      $totalSuaraMasukFIS = $this->vote->totalSuaraMasukFIS();
      $totalTidakMemilihFIS = $this->vote->totalTidakMemilihFIS();
      $totalSuaraMasukFISStat = $this->vote->totalSuaraMasukFISStat();

      $totalPemilihFIK = $this->vote->totalPemilihFIK();
      $totalSuaraMasukFIK = $this->vote->totalSuaraMasukFIK();
      $totalTidakMemilihFIK = $this->vote->totalTidakMemilihFIK();
      $totalSuaraMasukFIKStat = $this->vote->totalSuaraMasukFIKStat();

      $totalPemilihFaperta = $this->vote->totalPemilihFaperta();
      $totalSuaraMasukFaperta = $this->vote->totalSuaraMasukFaperta();
      $totalTidakMemilihFaperta = $this->vote->totalTidakMemilihFaperta();
      $totalSuaraMasukFapertaStat = $this->vote->totalSuaraMasukFapertaStat();

      $totalPemilihHukum = $this->vote->totalPemilihHukum();
      $totalSuaraMasukHukum = $this->vote->totalSuaraMasukHukum();
      $totalTidakMemilihHukum = $this->vote->totalTidakMemilihHukum();
      $totalSuaraMasukHukumStat = $this->vote->totalSuaraMasukHukumStat();

      $totalPemilihFSB = $this->vote->totalPemilihFSB();
      $totalSuaraMasukFSB = $this->vote->totalSuaraMasukFSB();
      $totalTidakMemilihFSB = $this->vote->totalTidakMemilihFSB();
      $totalSuaraMasukFSBStat = $this->vote->totalSuaraMasukFSBStat();

      $main_view = 'bem/statistik-pemilih';
      $this->load->view('template', compact('main_view',
      'totalSuaraMasukTeknikStat', 'totalTidakMemilihTeknik', 'totalSuaraMasukTeknik', 'totalPemilihTeknik',
      'totalSuaraMasukFSBStat', 'totalTidakMemilihFSB', 'totalSuaraMasukFSB', 'totalPemilihFSB',
      'totalSuaraMasukHukumStat', 'totalTidakMemilihHukum', 'totalSuaraMasukHukum', 'totalPemilihHukum',
      'totalSuaraMasukFapertaStat', 'totalTidakMemilihFaperta', 'totalSuaraMasukFaperta', 'totalPemilihFaperta',
      'totalSuaraMasukFIKStat', 'totalTidakMemilihFIK', 'totalSuaraMasukFIK', 'totalPemilihFIK',
      'totalSuaraMasukFISStat', 'totalTidakMemilihFIS', 'totalSuaraMasukFIS', 'totalPemilihFIS',
      'totalSuaraMasukMIPAStat', 'totalTidakMemilihMIPA', 'totalSuaraMasukMIPA', 'totalPemilihMIPA',
      'totalSuaraMasukFOKStat', 'totalTidakMemilihFOK', 'totalSuaraMasukFOK', 'totalPemilihFOK',
      'totalSuaraMasukEkonomiStat', 'totalTidakMemilihEkonomi', 'totalSuaraMasukEkonomi', 'totalPemilihEkonomi',
      'totalSuaraMasukFIPStat', 'totalTidakMemilihFIP', 'totalSuaraMasukFIP', 'totalPemilihFIP'
      ));
    }

    // Fitur Statistik Pemilihan Berdasarkan Fakultas
    public function statfakultas(){
      if($this->session->has_userdata('nim')) redirect('');
      if($this->session->has_userdata('admin')) redirect('');
      if($this->session->has_userdata('dekan')) redirect('');
      if($this->session->has_userdata('rektor')) redirect('');

      $fakultas = $this->session->userdata('fakultas');
      $totalPemilihFakultas = $this->vote->totalPemilihFakultas($fakultas);
      $totalSuaraMasukFakultas = $this->vote->totalSuaraMasukFakultas($fakultas);
      $totalTidakMemilihFakultas = $this->vote->totalTidakMemilihFakultas($fakultas);
      $totalSuaraMasukFakultasStat = $this->vote->totalSuaraMasukFakultasStat($fakultas);

      $main_view = 'bem/statistik-fakultas';
      $this->load->view('template', compact('main_view',
      'totalSuaraMasukFakultasStat', 'totalTidakMemilihFakultas', 'totalSuaraMasukFakultas', 'totalPemilihFakultas'));
    }

    // Fitur Live Count
    public function livecount(){
      if($this->session->has_userdata('nim')) redirect('');

      $paslonSatu = $this->vote->getPaslonSatu();
      $paslonDua = $this->vote->getPaslonDua();

      $totalSuaraMasukSatuStat = $this->vote->totalSuaraMasukSatuStat();
      $totalSuaraMasukSatu = $this->vote->totalSuaraMasukSatu();

      $totalSuaraMasukDuaStat = $this->vote->totalSuaraMasukDuaStat();
      $totalSuaraMasukDua = $this->vote->totalSuaraMasukDua();

      $totalPemilih = $this->vote->totalPemilih();
      $totalSuaraMasuk = $this->vote->totalSuaraMasuk();
      $totalTidakMemilih = $this->vote->totalTidakMemilih();
      $totalSuaraMasukStat = $this->vote->totalSuaraMasukStat();

      $main_view = 'bem/live-count';
      $this->load->view('template', compact('main_view', 'paslonSatu', 'paslonDua', 'totalPemilih', 'totalSuaraMasuk', 'totalTidakMemilih', 'totalSuaraMasukStat', 'totalSuaraMasukDuaStat', 'totalSuaraMasukDua', 'totalSuaraMasukSatuStat', 'totalSuaraMasukSatu'));
    }

    // Fitur Live Count Fakultas
    public function livecountfakultas(){
      if($this->session->has_userdata('nim')) redirect('');
      if($this->session->has_userdata('admin')) redirect('');
      if($this->session->has_userdata('dekan')) redirect('');
      if($this->session->has_userdata('rektor')) redirect('');

      $fakultas = $this->session->userdata('fakultas');

      $paslonSatu = $this->vote->getPaslonSatu();
      $paslonDua = $this->vote->getPaslonDua();

      $totalSuaraMasukSatuFakultasStat = $this->vote->totalSuaraMasukSatuFakultasStat($fakultas);
      $totalSuaraMasukSatuFakultas = $this->vote->totalSuaraMasukSatuFakultas($fakultas);

      $totalSuaraMasukDuaFakultasStat = $this->vote->totalSuaraMasukDuaFakultasStat($fakultas);
      $totalSuaraMasukDuaFakultas = $this->vote->totalSuaraMasukDuaFakultas($fakultas);

      $totalPemilihFakultas = $this->vote->totalPemilihFakultas($fakultas);
      $totalSuaraMasukFakultas = $this->vote->totalSuaraMasukFakultas($fakultas);
      $totalTidakMemilihFakultas = $this->vote->totalTidakMemilihFakultas($fakultas);
      $totalSuaraMasukFakultasStat = $this->vote->totalSuaraMasukFakultasStat($fakultas);

      $main_view = 'bem/live-count-fakultas';
      $this->load->view('template', compact('main_view', 'paslonSatu', 'paslonDua', 'totalPemilihFakultas', 'totalSuaraMasukFakultas', 'totalTidakMemilihFakultas', 'totalSuaraMasukFakultasStat', 'totalSuaraMasukDuaFakultasStat', 'totalSuaraMasukDuaFakultas', 'totalSuaraMasukSatuFakultasStat', 'totalSuaraMasukSatuFakultas'));
    }

    public function waitlivecount(){
      $this->load->view('waitlivecount');
    }


  }
