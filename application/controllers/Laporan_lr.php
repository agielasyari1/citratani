<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_lr extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->library('session');
                    $this->load->model('tr_model', 'lp');

                }
                
	public function index()
	{
             if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('laporan_lr');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_tahun(){
            
            $daftar_tahun = $this->lp->daftar_tahun();
            echo json_encode($daftar_tahun);
            
        }
        
         function view($bulan = "" , $tahun = ""){
           
            if($bulan == ""){
                $bulan = date('m');
            }
            if($tahun == ""){
                $tahun = date("Y");
            }
            
            $j_jumlah = 0;
            $b_jumlah = 0;
            
            $penjualan_partai = $this->lp->get_datatables($bulan, $tahun, "pp");
            $penjualan_ecer = $this->lp->get_datatables($bulan, $tahun, "pe");
            $pembelian = $this->lp->get_datatables($bulan, $tahun, "pb");
            $transaksi_lain = $this->lp->get_datatables($bulan, $tahun, "tl");
            
            $data = array();
            $no = $_POST['start'];
//           
            //DAFTAR PEMASUKAN
               $flag = 0;
               foreach ($penjualan_partai as $penjualan) {
                    $no++;
                    $row = array();
                    
                    if($flag == 0){
                       $row[] = "Pendapatan";   
                    }else{
                        $row[] = "";
                    }
                    $row[] = "Penjualan ".$penjualan->no_penjualan;
                    $row[] = "";
                    $row[] = number_format($penjualan->pembayaran,2,',','.');
                    
                    
                    $data[] = $row;
                    $flag++;
                    $j_jumlah += $penjualan->pembayaran;
                }
                
               foreach ($penjualan_ecer as $penjualan) {
                    $no++;
                    $row = array();
                    
                    $row[] = "";
                    $row[] = "Penjualan ".$penjualan->no_penjualan;
                    $row[] = "";
                    $row[] = number_format($penjualan->pembayaran,2,',','.');
                    
                    $data[] = $row;
                    $j_jumlah += $penjualan->pembayaran;
                }
                
                $row = array();
                $row[] = "<strong>Jumlah</strong>";
                $row[] = "";
                $row[] = "";
                $row[] = number_format($j_jumlah,2,',','.');
                $data[] = $row;
                
                $persediaan_awal = $this->lp->get_persediaan_awal($bulan, $tahun);
                $row = array();
                $row[] = "HPP";
                $row[] = "Persediaan Awal";
                $row[] = number_format($persediaan_awal,2,',','.');
                $row[] = "";
                $data[] = $row; 
                
               //DAFTAR PENGELUARAN
               $flag = 0;
               foreach ($pembelian as $pembelian) {
                    $no++;
                    $row = array();
                    
                    $row[] = "";
                    $row[] = "Pembelian ".$pembelian->no_pembelian;
                    $row[] = number_format($pembelian->pembayaran,2,',','.');
                    $row[] = "";
                    
                    
                    $data[] = $row;
                    $flag++;
                    $b_jumlah += $pembelian->pembayaran;
                }
                
                
                $row = array();
                $row[] = "<strong>Jumlah barang untuk dijual</strong>";
                $row[] = "";
                $row[] = number_format($b_jumlah+$persediaan_awal,2,',','.');
                $row[] = "";
                $data[] = $row;
                
                $persediaan_akhir = $this->lp->get_persediaan_akhir($bulan, $tahun);
                //$persediaan_akhir = 10;
                $row = array();
                $row[] = "";
                $row[] = "Dikurangi: Persediaan Akhir";
                $row[] = number_format($persediaan_akhir,2,',','.');
                $row[] = "";
                $data[] = $row;
                
                $hpp = $b_jumlah + $persediaan_awal - $persediaan_akhir;
                $row = array();
                $row[] = "<strong>Jumlah HPP</strong>";
                $row[] = "";
                $row[] = "";
                $row[] = number_format($hpp,2,',','.');
                $data[] = $row;
                
                $laba_kotor = $j_jumlah - $hpp;
                $row = array();
                $row[] = "<strong>Laba Kotor</strong>";
                $row[] = "";
                $row[] = "";
                $row[] = number_format($laba_kotor,2,',','.');
                $data[] = $row;
                
                $flag = 0;
                $l_jumlah = 0;
                foreach ($transaksi_lain as $transaksi) {
                    $no++;
                    $row = array();
                    
                    if($flag == 0){
                       $row[] = "Biaya Operasional";   
                    }else{
                        $row[] = "";
                    }
                    $row[] = $transaksi->keterangan;
                    $row[] = number_format($transaksi->total,2,',','.');
                    $row[] = "";
                    
                    $data[] = $row;
                    $l_jumlah += $transaksi->total;
                    $flag++;
                }
                
                $row = array();
                $row[] = "<strong>Jumlah</strong>";
                $row[] = "";
                $row[] = "";
                $row[] = number_format($l_jumlah,2,',','.');
                $data[] = $row;
                
                $row = array();
                $row[] = "<strong>Laba Bersih</strong>";
                $row[] = "";
                $row[] = "";
                $row[] = number_format($laba_kotor - $l_jumlah,2,',','.');
                $data[] = $row;
                
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => 1,
                            "recordsFiltered" => 1,
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function total_table_jual($month, $year){
            
            $detail = $this->lp->total_table_jual($month, $year);
            echo json_encode($detail);
        
        }
        
        function to_month_name($i){
            
            if($i == "01"){
                return "Januari";
            }else if($i == "02"){
                return "Februari";
            }else if($i == "03"){
                return "Maret";
            }else if($i == "04"){
                return "April";
            }else if($i == "05"){
                return "Mei";
            }else if($i == "06"){
                return "Juni";
            }else if($i == "07"){
                return "Juli";
            }else if($i == "08"){
                return "Agustus";
            }else if($i == "09"){
                return "September";
            }else if($i == "10"){
                return "Oktober";
            }else if($i == "11"){
                return "Nopember";
            }else if($i == "12"){
                return "Desember";
            }else{
                return "";
            }
            
        }
        
}
