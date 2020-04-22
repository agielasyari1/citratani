<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('barang_model', 'barang');
                    $this->load->library('session');
                }
                
	public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('barang');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function daftar_barang(){
            
            if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_barang = $this->barang->daftar_barang($term);
              }
            
            echo json_encode($daftar_barang);
            
        }
        function daftar_barangB(){
            
             if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_barang = $this->barang->daftar_barangB($term);
              }
            echo json_encode($daftar_barang);
            
        }
        
        function daftar_barang2(){
            
            if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_barang = $this->barang->daftar_barang2($term);
              }
            
            echo json_encode($daftar_barang);
            
        }
        function daftar_barangB2(){
            
             if (isset($_GET['term'])){
                $term = strtolower($_GET['term']);
                $daftar_barang = $this->barang->daftar_barangB2($term);
              }
            echo json_encode($daftar_barang);
            
        }
        
        function view(){
            $list = $this->barang->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $barang) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $barang->nama_barang;
                $row[] = number_format($barang->stok, 1, ',', '.');
                $row[] = $barang->nama_satuan;
                $row[] = number_format($barang->hrg_beli, 0, ',', '.');
                $row[] = number_format($barang->hrg_jual_eceran, 0, ',', '.');
                $row[] = number_format($barang->hrg_jual_grosir, 0, ',', '.');
                $row[] = $barang->gudang;
                $row[] = $barang->nama_kategori;
                $row[] = '<button type="button" id="edit" onclick="change('."'".$barang->id_barang."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$barang->id_barang."'".')"  class="btn btn-xs btn-danger" ><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->barang->count_all(),
                            "recordsFiltered" => $this->barang->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function add(){
                 $inserted = $this->barang->add();
                 echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->barang->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->barang->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->barang->delete($id);
            echo json_encode(array('status' => $status));
        }
        
         function get_harga_grosir($id){
            $detail = $this->barang->get_harga_grosir($id);
            echo json_encode($detail);
        }
         function get_harga_ecer($id){
            $detail = $this->barang->get_harga_ecer($id);
            echo json_encode($detail);
        }
        
        function get_gudang_barang($id){
            $detail = $this->barang->get_gudang_barang($id);
            echo json_encode($detail);
        }
        
}
