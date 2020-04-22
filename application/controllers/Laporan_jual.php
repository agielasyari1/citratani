<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_jual extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->library('session');
                    $this->load->model('lj_model', 'lj');

                }
                
	public function index()
	{
             if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('laporan_jual');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_tahun(){
            
            $daftar_tahun = $this->lj->daftar_tahun();
            echo json_encode($daftar_tahun);
            
        }
        
      
        
        function view_pj($awal = "" , $akhir= ""){
           
            
            $tipe = "partai";
            $list = $this->lj->get_datatables($tipe, $awal, $akhir);
            $data = array();
            $no = $_POST['start'];
            
                foreach ($list as $penjualan) {
                    $no++;
                    $row = array();
                    $row[] = $penjualan->no_penjualan;
                    $row[] = $penjualan->created_date;
                    if($tipe != 'ecer'){
                        $row[] = $penjualan->nama_toko;
                    }else{
                        $row[] = $penjualan->nama_pembeli;
                    }
                    
                    $row[] = number_format($penjualan->grand_total, 0, ',', '.');
                    $row[] = number_format($penjualan->pembayaran, 0, ',', '.');
                    $row[] = number_format($penjualan->sisa, 0, ',', '.');
                    

                    $data[] = $row;
                }
                
                $tipe = "ecer";
                $list = $this->lj->get_datatables($tipe, $awal, $akhir);
                foreach ($list as $penjualan) {
                    $no++;
                    $row = array();
                    $row[] = $penjualan->no_penjualan;
                    $row[] = $penjualan->created_date;
                    if($tipe != 'ecer'){
                        $row[] = $penjualan->nama_toko;
                    }else{
                        $row[] = $penjualan->nama_pembeli;
                    }
                    
                    $row[] = number_format($penjualan->grand_total, 0, ',', '.');
                    $row[] = number_format($penjualan->pembayaran, 0, ',', '.');
                    $row[] = number_format($penjualan->sisa, 0, ',', '.');
                    

                    $data[] = $row;
                }
           
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->lj->count_all($tipe, $awal, $akhir),
                            "recordsFiltered" => $this->lj->count_filtered($tipe, $awal, $akhir),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
     
        
        function total_table_jual($tipe, $awal, $akhir){
            
            $detail = $this->lj->total_table_jual($tipe, $awal, $akhir);
            echo json_encode($detail);
        
        }
        
}
