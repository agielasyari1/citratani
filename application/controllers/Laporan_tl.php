<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_tl extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->library('session');
                    $this->load->model('tl_model', 'lp');

                }
                
	public function index()
	{
             if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('laporan_tl');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_tahun(){
            
            $daftar_tahun = $this->lp->daftar_tahun();
            echo json_encode($daftar_tahun);
            
        }
        
        function view($awal = "" , $akhir = ""){
           
            if($awal == ""){
                $awal = "0000-00-00";
            }
            if($akhir == ""){
                $akhir = "0000-00-00";
            }
            $list = $this->lp->get_datatables($awal, $akhir);
            $data = array();
            $no = $_POST['start'];
           
                foreach ($list as $penjualan) {
                    $no++;
                    $row = array();
                    $row[] = $penjualan->id_transaksi;
                    $row[] = $penjualan->tanggal;
                    $row[] = $penjualan->keterangan;
                    $row[] = number_format($penjualan->total, 0, ',', '.');

                    $data[] = $row;
                }
           
            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->lp->count_all($awal, $akhir),
                            "recordsFiltered" => $this->lp->count_filtered($awal, $akhir),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        
        function total_table_jual($awal, $akhir){
            
            $detail = $this->lp->total_table_jual($awal, $akhir);
            echo json_encode($detail);
        
        }
        
}
