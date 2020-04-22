<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('pengguna_model', 'pengguna');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('pengguna');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function generateID(){
             $detail = $this->pengguna->generateID();
             echo json_encode($detail);
        }
        
        function add(){
                 $inserted = $this->pengguna->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function view(){
            $list = $this->pengguna->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pengguna) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $pengguna->nama;
                $row[] = $pengguna->alamat;
                $row[] = $pengguna->no_telp;
                
                if($pengguna->posisi == 1){
                    $row[] = "Administrator";
                }else{
                    $row[] = "Pegawai";
                }
                if($pengguna->status == 0){
                    $row[] = "<span class='badge badge-danger'>offline</span>";
                }else{
                    $row[] = "<span class='badge badge-success'>online</span>";
                }
                
                
                $row[] = '<button type="button" id="edit" onclick="change('."'".$pengguna->username."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$pengguna->username."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pengguna->count_all(),
                            "recordsFiltered" => $this->pengguna->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function detail($id){
            $detail = $this->pengguna->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->pengguna->update();
             echo json_encode(array('status' => $status));
        }
                
        function delete($id){
                    
            $status = $this->pengguna->delete($id);
            echo json_encode(array('status' => $status));
            
        }
        
        function foto(){
            $detail = $this->pengguna->foto();
            echo json_encode($detail);
        }
        
}
