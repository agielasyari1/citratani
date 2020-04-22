<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('satuan_model', 'satuan');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('satuan');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_satuan(){
            
            $daftar_satuan = $this->satuan->daftar_satuan();
            echo json_encode($daftar_satuan);
            
        }
        
        function view(){
            $list = $this->satuan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $satuan) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $satuan->nama_satuan;
                $row[] = '<button type="button" id="edit" onclick="change('."'".$satuan->id_satuan."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$satuan->id_satuan."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->satuan->count_all(),
                            "recordsFiltered" => $this->satuan->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
                 $inserted = $this->satuan->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->satuan->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->satuan->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->satuan->delete($id);
            echo json_encode(array('status' => $status));
        }
}
