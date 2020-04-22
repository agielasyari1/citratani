<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class B_Pembelian extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('B_Pembelian_M', 'pembelian');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
                
	public function index()
	{
            
            if($this->session->userdata('logged_in')){
                $data = $this->pengaturan->detail();
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('b_pembelian', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view(){
            $list = $this->pembelian->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pembelian) {
                $no++;
                $row = array();
                $row[] = $pembelian->no_pembelian;
                $row[] = $pembelian->tanggal_permintaan;
                $row[] = $pembelian->batas_pembayaran;
                $row[] = $pembelian->nama_toko;
                $row[] = number_format($pembelian->pembayaran, 0, ',', '.');
                $row[] = number_format($pembelian->sisa, 0, ',', '.');
                $row[] = number_format($pembelian->total, 0, ',', '.');
                $row[] = $pembelian->created_by;
                $row[] = $pembelian->updated_by;
                $row[] = $pembelian->updated_date;
                
                $row[] = '<button type="button" id="add" onclick="detail('."'".$pembelian->no_pembelian."'".')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-search"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$pembelian->no_pembelian."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pembelian->count_all(),
                            "recordsFiltered" => $this->pembelian->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function generateNO(){
             $detail = $this->pembelian->generateNo();
             echo json_encode($detail);
        }
        
       
                
        function add(){
             $inserted = $this->pembelian->add();
             echo json_encode(array('status' => $inserted));
             
        }
        
        function detail($id){
            $detail = $this->pembelian->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->pembelian->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->pembelian->delete($id);
            echo json_encode(array('status' => $status));
        }
        
         function get_total_jual($id){
            $total = $this->pembelian->get_total_jual($id);
            echo json_encode($total);
        }
}
