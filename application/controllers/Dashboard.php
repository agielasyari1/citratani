<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('dashboard_model', 'dashboard');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in')){
                $data = $this->dashboard->get_dashboard_data();
               
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
                
		$this->load->view('dashboard', $data);
               
		$this->load->view('footer');
                
            }else{
                redirect('login');
            }
		
	}
        
        function data_penjualan_pupuk(){
//            $data['try_data'] = $this->dashboard->data("pupuk");
//            echo json_encode($data, JSON_NUMERIC_CHECK);
        }
        function data(){
            $data['try_data'] = $this->dashboard->data();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        }
        
        function lunas($tipe, $id){
            
            $this->dashboard->lunas($tipe, $id);
            echo json_encode(array('status' => TRUE));
            
        }
        
        function view($tipe){
            $list = $this->dashboard->get_datatables($tipe);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $penjualan) {
                $no++;
                $row = array();
                $row[] = $penjualan->no_penjualan;
                $row[] = $penjualan->created_date;
                if($tipe == 'ecer'){
                      $row[] = $penjualan->nama_pembeli;
                }else{
                    $row[] = $penjualan->nama_toko;
                }
              
                $row[] = number_format($penjualan->total, 0, ',', '.');
                $row[] = number_format($penjualan->pembayaran, 0, ',', '.');
                $row[] = number_format($penjualan->sisa, 0, ',', '.');
                $row[] = '<input type="checkbox" onclick="lunas('."'".$penjualan->no_penjualan."'".",'".$tipe."'".')">';
                
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->dashboard->count_all($tipe),
                            "recordsFiltered" => $this->dashboard->count_filtered($tipe),
                            "data" => $data,
                    );
            echo json_encode($output);
       }
        
}
