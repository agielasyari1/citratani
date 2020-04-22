<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_beli extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->library('session');
                    $this->load->model('lb_model', 'lb');

                }
                
	public function index()
	{
             if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('laporan_beli');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_tahun(){
            
            $daftar_tahun = $this->lb->daftar_tahun();
            echo json_encode($daftar_tahun);
            
        }
        
      
        
        function view_pb($tipe = "", $awal = "" , $akhir= ""){
         
            $list = $this->lb->get_datatables($tipe, $awal, $akhir);
            $data = array();
            $no = $_POST['start'];
            
                foreach ($list as $pembelian) {
                    $no++;
                    $row = array();
                    $row[] = '<a href="'.site_url('r_pembeliana/view_detail/'.$pembelian->no_pembelian).'">'.$pembelian->no_pembelian.'</a>';
                    $row[] = $pembelian->tanggal_permintaan;
                    $row[] = $pembelian->batas_pembayaran;
                    $row[] = $pembelian->nama_toko;
                    $row[] = number_format($pembelian->total, 0, ',', '.');
                    $row[] = number_format($pembelian->pembayaran, 0, ',', '.');
                    $row[] = number_format($pembelian->sisa, 0, ',', '.');
                    

                    $data[] = $row;
                }
           
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->lb->count_all($tipe, $awal, $akhir),
                            "recordsFiltered" => $this->lb->count_filtered($tipe, $awal, $akhir),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
     
        
        function total_table_beli($tipe, $awal, $akhir){
            
            $detail = $this->lb->total_table_beli($tipe, $awal, $akhir);
            echo json_encode($detail);
        
        }
        
}
