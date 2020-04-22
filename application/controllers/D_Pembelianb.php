<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class D_Pembelianb extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('D_Pembelianb_M', 'pembelian');
                    $this->load->model('B_Pembelian_M', 'pembeliana');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
        
        public function pembelian_baru()
	{
            
            if($this->session->userdata('logged_in')){
                $ppn = $this->pengaturan->detail();
                $data['ppn'] = $ppn->ppn;
                $data['id_pembelian'] = $this->pembeliana->generateNo();
                if(!$this->pembeliana->cek_ada($data['id_pembelian'])){
                     $this->pembeliana->add($data['id_pembelian']);
                }
               
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('d_pembelianb', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}        
                
	public function view_detail($id_pembelian)
	{
            
            if($this->session->userdata('logged_in')){
                $ppn = $this->pengaturan->detail();
                $data['ppn'] = $ppn->ppn;
                $data['id_pembelian'] = $id_pembelian;
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('d_pembelianb', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view($no_pembelian){
            $list = $this->pembelian->get_datatables($no_pembelian);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pembelian) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $pembelian->nama_barang;
                $row[] = number_format($pembelian->qty, 1, ',', '.');
                $row[] = number_format($pembelian->harga_satuan, 0, ',', '.');
                $row[] = number_format($pembelian->harga_total, 0, ',', '.');
                $row[] = '<button type="button" id="edit" onclick="change('."'".$pembelian->id."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$pembelian->id."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pembelian->count_all($no_pembelian),
                            "recordsFiltered" => $this->pembelian->count_filtered($no_pembelian),
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
        
         function batal($id){
            $status = $this->pembelian->batal($id);
            $status = $this->pembeliana->delete($id);
            echo json_encode(array('status' => $status));
        }
}
