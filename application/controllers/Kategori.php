<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('kategori_model', 'kategori');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('kategori');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_kategori(){
            
            $daftar_kategori = $this->kategori->daftar_kategori();
            echo json_encode($daftar_kategori);
            
        }
        
        function view(){
            $list = $this->kategori->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $kategori) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $kategori->nama_kategori;
                $row[] = '<button type="button" id="edit" onclick="change('."'".$kategori->id_kategori."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$kategori->id_kategori."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->kategori->count_all(),
                            "recordsFiltered" => $this->kategori->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
                 $inserted = $this->kategori->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->kategori->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->kategori->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->kategori->delete($id);
            echo json_encode(array('status' => $status));
        }
}
