<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('supplier_model', 'supplier');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('supplier');
		$this->load->view('footer');
            }
            else{
                redirect('login');
            }
		
	}
        
        function daftar_supplier(){
            if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_supplier = $this->supplier->daftar_supplier($term);
            }
            echo json_encode($daftar_supplier);
            
        }
        
        function view(){
            $list = $this->supplier->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $supplier) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $supplier->nama_toko;
                $row[] = $supplier->nama;
                $row[] = $supplier->alamat;
                $row[] = $supplier->no_telp;
                $row[] = '<button type="button" id="edit" onclick="change('."'".$supplier->id_supplier."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$supplier->id_supplier."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->supplier->count_all(),
                            "recordsFiltered" => $this->supplier->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
                 $inserted = $this->supplier->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->supplier->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->supplier->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->supplier->delete($id);
            echo json_encode(array('status' => $status));
        }
}
