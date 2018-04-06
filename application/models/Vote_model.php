<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Vote_model extends CI_Model{

    // Data Semua Paslon
    public function allPaslon(){
      return $this->db->select('*')->from('paslon')->get()->result();
    }

    // Data Semua Suara Masuk
    public function suaraMasuk(){
      return $this->db->select('*')->from('pemilihan')->join('pemilih','pemilihan.id_pemilih = pemilih.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->get()->result();
    }

    // Hapus Suara Masuk
    public function deleteSuaraMasuk($id){
      return $this->db->where('id_pemilihan', $id)->delete('pemilihan');
    }

    // Set Kembali Pemilih
    public function setKembaliPemilih($id){
      $sql = "update pemilih set telah_memilih = 'tidak' where id_pemilih = '$id'";
      return $this->db->query($sql);
    }

    // Data Paslon Satu
    public function getPaslonSatu(){
      return $this->db->select('*')->from('paslon')->where('id_paslon', '3')->get()->row();
    }

    // Data Paslon Dua
    public function getPaslonDua(){
      return $this->db->select('*')->from('paslon')->where('id_paslon', '4')->get()->row();
    }

    // Data Suatu Pemilih
    public function pemilih($id){
      return $this->db->where('id_pemilih', $id)->get('pemilih')->row();
    }

    // Fitur Coblos Paslon
    public function coblosPaslon($data){
      return $this->db->insert('pemilihan', $data);
    }

    // Fitur Set Telah Memilih
    public function setTelahMemilih($id){
      $sql = "update pemilih set telah_memilih = 'ya' where id_pemilih = '$id'";
      return $this->db->query($sql);
    }

    // Query Aggregat

    // Paslon Satu
    // Statistik Total Suara Masuk Paslon Satu
    public function totalSuaraMasukSatuStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukSatu();
      $totalPemilih = $this->totalSuaraMasuk();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Suara Masuk Paslon Satu
    public function totalSuaraMasukSatu(){
      return $this->db->select('*')->from('pemilihan')->join('pemilih', 'pemilihan.id_pemilih = pemilih.id_pemilih')->where('pemilihan.id_paslon', '3')->get()->num_rows();
    }

    // Paslon Dua
    // Statistik Total Suara Masuk Paslon Dua
    public function totalSuaraMasukDuaStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukDua();
      $totalPemilih = $this->totalSuaraMasuk();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Suara Masuk Paslon Dua
    public function totalSuaraMasukDua(){
      return $this->db->select('*')->from('pemilihan')->join('pemilih', 'pemilihan.id_pemilih = pemilih.id_pemilih')->where('pemilihan.id_paslon', '4')->get()->num_rows();
    }

    // Statistik Total Suara Masuk Semua Fakultas
    public function totalSuaraMasukStat(){
      $totalSuaraMasuk = $this->totalSuaraMasuk();
      $totalPemilih = $this->totalPemilih();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih
    public function totalPemilih(){
      return $this->db->select('*')->from('pemilih')->get()->num_rows();
    }

    // Total Suara Masuk
    public function totalSuaraMasuk(){
      return $this->db->select('*')->from('pemilihan')->get()->num_rows();
    }

    // Total Pemilih Belum Memilih
    public function totalTidakMemilih(){
      return $this->db->select('*')->from('pemilih')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    // Berbasis Satu Fakultas

    public function totalSuaraMasukFakultasStat($fakultas){
      $totalSuaraMasuk = $this->totalSuaraMasukFakultas($fakultas);
      $totalPemilih = $this->totalPemilihFakultas($fakultas);
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    public function totalPemilihFakultas($fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', $fakultas)->get()->num_rows();
    }

    public function totalSuaraMasukFakultas($fakultas){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', $fakultas)->get()->num_rows();
    }

    public function totalTidakMemilihFakultas($fakultas){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', $fakultas)->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    // Paslon Satu
    // Statistik Total Suara Masuk Paslon Satu
    public function totalSuaraMasukSatuFakultasStat($fakultas){
      $totalSuaraMasuk = $this->totalSuaraMasukSatuFakultas($fakultas);
      $totalPemilih = $this->totalSuaraMasukFakultas($fakultas);
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Suara Masuk Paslon Satu
    public function totalSuaraMasukSatuFakultas($fakultas){
      return $this->db->select('*')->from('pemilihan')->join('pemilih', 'pemilihan.id_pemilih = pemilih.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilihan.id_paslon', '3')->where('nama_fakultas', $fakultas)->get()->num_rows();
    }

    // Paslon Dua
    // Statistik Total Suara Masuk Paslon Dua Fakultas
    public function totalSuaraMasukDuaFakultasStat($fakultas){
      $totalSuaraMasuk = $this->totalSuaraMasukDuaFakultas($fakultas);
      $totalPemilih = $this->totalSuaraMasukFakultas($fakultas);
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Suara Masuk Paslon Dua Fakultas
    public function totalSuaraMasukDuaFakultas($fakultas){
      return $this->db->select('*')->from('pemilihan')->join('pemilih', 'pemilihan.id_pemilih = pemilih.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->where('pemilihan.id_paslon', '4')->where('nama_fakultas', $fakultas)->get()->num_rows();
    }

    // Semua Fakultas

    // Teknik
    // Total Statistik Suara Masuk Fakultas Teknik
    public function totalSuaraMasukTeknikStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukTeknik();
      $totalPemilih = $this->totalPemilihTeknik();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Teknik
    public function totalPemilihTeknik(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Teknik')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Teknik
    public function totalSuaraMasukTeknik(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Teknik')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Teknik
    public function totalTidakMemilihTeknik(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Teknik')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Ilmu Pendidikan
    // Total Statistik Suara Masuk Fakultas Ilmu Pendidikan
    public function totalSuaraMasukFIPStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFIP();
      $totalPemilih = $this->totalPemilihFIP();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Ilmu Pendidikan
    public function totalPemilihFIP(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Pendidikan')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Ilmu Pendidikan
    public function totalSuaraMasukFIP(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Ilmu Pendidikan')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Ilmu Pendidikan
    public function totalTidakMemilihFIP(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Pendidikan')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //MIPA
    // Total Statistik Suara Masuk Fakultas MIPA
    public function totalSuaraMasukMIPAStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukMIPA();
      $totalPemilih = $this->totalPemilihMIPA();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas MIPA
    public function totalPemilihMIPA(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'MIPA')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas MIPA
    public function totalSuaraMasukMIPA(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'MIPA')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas MIPA
    public function totalTidakMemilihMIPA(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'MIPA')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Ekonomi
    // Total Statistik Suara Masuk Fakultas Ekonomi
    public function totalSuaraMasukEkonomiStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukEkonomi();
      $totalPemilih = $this->totalPemilihEkonomi();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Ekonomi
    public function totalPemilihEkonomi(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ekonomi')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Ekonomi
    public function totalSuaraMasukEkonomi(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Ekonomi')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Ekonomi
    public function totalTidakMemilihEkonomi(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ekonomi')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Olahraga & Kesehatan
    // Total Statistik Suara Masuk Fakultas Olahraga & Kesehatan
    public function totalSuaraMasukFOKStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFOK();
      $totalPemilih = $this->totalPemilihFOK();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Olahraga & Kesehatan
    public function totalPemilihFOK(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Olahraga & Kesehatan')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Olahraga & Kesehatan
    public function totalSuaraMasukFOK(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Olahraga & Kesehatan')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Olahraga & Kesehatan
    public function totalTidakMemilihFOK(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Olahraga & Kesehatan')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Ilmu Sosial
    // Total Statistik Suara Masuk Fakultas Ilmu Sosial
    public function totalSuaraMasukFISStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFIS();
      $totalPemilih = $this->totalPemilihFIS();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Ilmu Sosial
    public function totalPemilihFIS(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Sosial')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Ilmu Sosial
    public function totalSuaraMasukFIS(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Ilmu Sosial')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Ilmu Sosial
    public function totalTidakMemilihFIS(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Sosial')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Ilmu Kelautan
    // Total Statistik Suara Masuk Fakultas Ilmu Kelautan
    public function totalSuaraMasukFIKStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFIK();
      $totalPemilih = $this->totalPemilihFIK();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Ilmu Kelautan
    public function totalPemilihFIK(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Kelautan')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Ilmu Kelautan
    public function totalSuaraMasukFIK(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Ilmu Kelautan')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Ilmu Kelautan
    public function totalTidakMemilihFIK(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Ilmu Kelautan')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Pertanian
    // Total Statistik Suara Masuk Fakultas Pertanian
    public function totalSuaraMasukFapertaStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFaperta();
      $totalPemilih = $this->totalPemilihFaperta();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Pertanian
    public function totalPemilihFaperta(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Pertanian')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Pertanian
    public function totalSuaraMasukFaperta(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Pertanian')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Pertanian
    public function totalTidakMemilihFaperta(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Pertanian')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Hukum
    // Total Statistik Suara Masuk Fakultas Hukum
    public function totalSuaraMasukHukumStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukHukum();
      $totalPemilih = $this->totalPemilihHukum();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Hukum
    public function totalPemilihHukum(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Hukum')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Hukum
    public function totalSuaraMasukHukum(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Hukum')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Hukum
    public function totalTidakMemilihHukum(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Hukum')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

    //Sastra & Budaya
    // Total Statistik Suara Masuk Fakultas Sastra & Budaya
    public function totalSuaraMasukFSBStat(){
      $totalSuaraMasuk = $this->totalSuaraMasukFSB();
      $totalPemilih = $this->totalPemilihFSB();
      return round($totalSuaraMasuk / $totalPemilih * 100);
    }

    // Total Pemilih Fakultas Sastra & Budaya
    public function totalPemilihFSB(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Sastra & Budaya')->get()->num_rows();
    }

    // Total Suara Masuk Fakultas Sastra & Budaya
    public function totalSuaraMasukFSB(){
      return $this->db->select('*')->from('pemilih')->join('pemilihan','pemilih.id_pemilih = pemilihan.id_pemilih')->join('fakultas', 'pemilih.id_fakultas = fakultas.id_fakultas')->join('paslon', 'pemilihan.id_paslon = paslon.id_paslon')->where('fakultas.nama_fakultas', 'Sastra & Budaya')->get()->num_rows();
    }

    // Total Tidak Memilih Fakultas Sastra & Budaya
    public function totalTidakMemilihFSB(){
      return $this->db->select('*')->from('pemilih')->join('fakultas','pemilih.id_fakultas = fakultas.id_fakultas')->where('fakultas.nama_fakultas', 'Sastra & Budaya')->where('pemilih.telah_memilih', 'tidak')->get()->num_rows();
    }

  }
