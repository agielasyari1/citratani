<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class D_PenjualanPartai extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('d_penjualanpartai_model', 'penjualan');
                    $this->load->model('penjualanpartai_model', 'penjualanpartai');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
        
        public function penjualan_baru()
	{
            
            if($this->session->userdata('logged_in')){
                $ppn = $this->pengaturan->detail();
                $data['ppn'] = $this->pengaturan->detail()->ppn;
                $data['id_penjualan'] = $this->penjualanpartai->generateNo();
                if(!$this->penjualanpartai->cek_ada($data['id_penjualan'])){
                     $this->penjualanpartai->add($data['id_penjualan']);
                }
               
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('d_penjualanpartai', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}        
                
	public function view_detail($id_penjualan)
	{
            
            if($this->session->userdata('logged_in')){
                $ppn = $this->pengaturan->detail();
                $data['ppn'] = $ppn->ppn;
                $data['id_penjualan'] = $id_penjualan;
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('d_penjualanpartai', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view($no_penjualan){
            $list = $this->penjualan->get_datatables($no_penjualan);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $penjualan) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $penjualan->nama_barang;
                $row[] = number_format($penjualan->qty, 1, ',', '.');
                $row[] = number_format($penjualan->harga_satuan, 0, ',', '.');
                $row[] = number_format($penjualan->harga_total, 0, ',', '.');
                $row[] = '<button type="button" id="edit" onclick="change('."'".$penjualan->id."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$penjualan->id."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->penjualan->count_all($no_penjualan),
                            "recordsFiltered" => $this->penjualan->count_filtered($no_penjualan),
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
        
         function batal($id){
            $status = $this->penjualan->batal($id);
            $status = $this->penjualanpartai->delete($id);
            echo json_encode(array('status' => $status));
        }
}
