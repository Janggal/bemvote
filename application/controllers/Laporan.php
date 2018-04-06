<?php

class Laporan extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('Vote_model', 'vote', TRUE);
    require_once(APPPATH . 'third_party/dompdf/dompdf_config.inc.php');

    if($this->session->has_userdata('operator')) redirect('');
    if($this->session->has_userdata('dekan')) redirect('');
    if($this->session->has_userdata('rektor')) redirect('');
    if($this->session->has_userdata('nim')) redirect('');
  }

  public function index(){

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

    $html = $this->load->view('laporan', compact('paslonSatu', 'paslonDua', 'totalPemilih', 'totalSuaraMasuk', 'totalTidakMemilih', 'totalSuaraMasukStat', 'totalSuaraMasukDuaStat', 'totalSuaraMasukDua', 'totalSuaraMasukSatuStat', 'totalSuaraMasukSatu'), true);

    $pdf = new DOMPDF();
    $pdf->load_html($html);
    $pdf->set_paper('A4', 'landscape');
    $pdf->render();
    $pdf->stream("test.pdf");

    // $this->load->view('laporan', compact('paslonSatu', 'paslonDua', 'totalPemilih', 'totalSuaraMasuk', 'totalTidakMemilih', 'totalSuaraMasukStat', 'totalSuaraMasukDuaStat', 'totalSuaraMasukDua', 'totalSuaraMasukSatuStat', 'totalSuaraMasukSatu'));

  }

}
