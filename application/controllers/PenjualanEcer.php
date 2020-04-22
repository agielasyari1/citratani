<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualanecer extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('penjualanecer_model', 'penjualan');
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
		$this->load->view('penjualanecer', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view(){
            $list = $this->penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $penjualan) {
                $no++;
                $row = array();
                $row[] = $penjualan->no_penjualan;
                $row[] = $penjualan->created_date;
                $row[] = $penjualan->nama_pembeli;
                $row[] = number_format($penjualan->grand_total, 0, ',', '.');
                $row[] = number_format($penjualan->pembayaran, 0, ',', '.');
                $row[] = number_format($penjualan->sisa, 0, ',', '.');
                $row[] = $penjualan->created_by;
                $row[] = $penjualan->updated_by;
                $row[] = $penjualan->updated_date;
                
                $row[] = '<button type="button" id="print" onclick="print_kw('."'".$penjualan->no_penjualan."'".')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-print"></i></button> '
                        .'<button type="button" id="add" onclick="detail('."'".$penjualan->no_penjualan."'".')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-search"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$penjualan->no_penjualan."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->penjualan->count_all(),
                            "recordsFiltered" => $this->penjualan->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function generateNO(){
             $detail = $this->penjualan->generateNo();
             echo json_encode($detail);
        }
        
        function add(){
             $inserted = $this->penjualan->add();
             echo json_encode(array('status' => $inserted));
             
        }
        
        function detail($id){
            $detail = $this->penjualan->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->penjualan->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->penjualan->delete($id);
            echo json_encode(array('status' => $status));
        }
        
        function get_total_jual($id){
            $total = $this->penjualan->get_total_jual($id);
            echo json_encode($total);
        }
}
