<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembeli extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('pembeli_model', 'pembeli');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('pembeli');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_pembeli(){
             if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_pembeli = $this->pembeli->daftar_pembeli($term);
             }
            echo json_encode($daftar_pembeli);
            
        }
        
        function view(){
            $list = $this->pembeli->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pembeli) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $pembeli->nama_toko;
                $row[] = $pembeli->nama;
                $row[] = $pembeli->alamat;
                $row[] = $pembeli->no_telp;
                $row[] = $pembeli->tipe;
                $row[] = '<button type="button" id="edit" onclick="change('."'".$pembeli->id_customer."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$pembeli->id_customer."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pembeli->count_all(),
                            "recordsFiltered" => $this->pembeli->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
                 $inserted = $this->pembeli->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->pembeli->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->pembeli->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->pembeli->delete($id);
            echo json_encode(array('status' => $status));
        }
}
