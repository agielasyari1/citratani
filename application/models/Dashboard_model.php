<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
   
    var $table = 'penjualan_ecer';
    var $column = array('no_penjualan','created_date','nama_pembeli','total','pembayaran', 'sisa', 'created_by', 'edited_by', 'date_edited'); //set column field database for order and search
    var $order = array('no_penjualan' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($tipe)
        {
        
        if($tipe == 'partai'){
            $this->table = 'penjualan_partai';
            $this->column = array('no_penjualan','pp.created_date','nama_toko','total','pembayaran', 'sisa', 'pp.created_by', 'pp.updated_by', 'pp.updated_date');
            $this->order = array('no_penjualan' => 'desc');
            
            $this->db->select('no_penjualan, pp.created_date,nama_toko, total, pembayaran, sisa, pp.created_by, pp.updated_by, pp.updated_date');
            $this->db->from($this->table." pp");
            $this->db->where('sisa !=',0);
            $this->db->join('customer c', 'pp.id_customer = c.id_customer', 'left');
        }else{
             $this->db->from($this->table);
             $this->db->where('sisa !=',0);
        }
        
        $this->db->order_by('no_penjualan', 'DESC');
 
        $i = 0;
     
        foreach ($this->column as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
        
    function count_filtered($tipe)
    {
        $this->_get_datatables_query($tipe);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($tipe)
    {
         if($tipe == 'partai'){
            $this->table = 'penjualan_partai';
            $this->column = array('no_penjualan','pp.created_date','nama_toko','total','pembayaran', 'sisa', 'pp.created_by', 'pp.updated_by', 'pp.updated_date');
            $this->order = array('no_penjualan' => 'desc');
            
            $this->db->select('no_penjualan, pp.created_date,nama_toko, total, pembayaran, sisa, pp.created_by, pp.updated_by, pp.updated_date');
            $this->db->from($this->table." pp");
            $this->db->where('sisa !=',0);
            $this->db->join('customer c', 'pp.id_customer = c.id_customer', 'left');
        }else{
             $this->db->from($this->table);
             $this->db->where('sisa !=',0);
        }
        return $this->db->count_all_results();
    }
    
    function get_datatables($tipe)
    {
        $this->_get_datatables_query($tipe);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }      
    function get_dashboard_data(){
        
//        $data = array();
//        $this->db->select('COUNT(no_permintaan) as jumlah');
//        $this->db->where('batas_pembayaran', date('Y-m-d'));
//        $row = $this->db->get('pembelian')->row();
//        if (isset($row))
//        {
//                $data['jum_pelunasan'] = $row->jumlah;
//        }
//        
//        $this->db->select('COUNT(no_penjualan) as jumlah');
//        $this->db->where('tanggal_pengantaran', date('Y-m-d'));
//        $row = $this->db->get('penjualan')->row();
//        if (isset($row))
//        {
//                $data['jum_antar'] = $row->jumlah;
//        }
//        
//        $this->db->select('nama_barang, stok');
//        $result = $this->db->get('barang');
//        $data['barang'] = $result->result();
//        
//        return $data;
//        
//    }
//    
//    function data($barang){
//        
//        $this->db->where('Tahun', date("Y"));
//        if($barang == "pupuk"){
//            $row = $this->db->get('years_sell_pupuk')->row();
//
//        }else{
//            $row = $this->db->get('years_sell_semen')->row();
//
//        }
//        if (isset($row))
//        {
//               $data = array((int)$row->Jan, 
//                             (int)$row->Feb,
//                             (int)$row->Mar,
//                             (int)$row->Apr,
//                             (int)$row->Mei,
//                             (int)$row->Jun,
//                             (int)$row->Jul,
//                             (int)$row->Ags,
//                             (int)$row->Sep,
//                             (int)$row->Okt,
//                             (int)$row->Nop,
//                             (int)$row->Des,
//                       );
//        }
//        
       //return $data;
   }
   
   function data(){
       
       $data = array();
       for($i = 1; $i<=12; $i++){
           array_push($data, $this->total_penjualan($i) - $this->total_pembelian($i) - $this->total_tl($i) );
       }
       return $data;
       
   }
   
   
   function total_penjualan($i){
           $this->db->select('sum(pembayaran) as total');
           $this->db->like('created_date', date("Y-").sprintf('%02s', $i), 'after');
           $result = $this->db->get('penjualan_partai')->row();
           $this->db->select('sum(pembayaran) as total');
           $this->db->like('created_date', date("Y-").sprintf('%02s', $i), 'after');
           $result2 = $this->db->get('penjualan_ecer')->row();
           return $result->total + $result2->total;
   }
   function total_pembelian($i){
           $this->db->select('sum(pembayaran) as total');
           $this->db->like('created_date', date("Y-").sprintf('%02s', $i), 'after');
           $result = $this->db->get('pembelian')->row();
           return $result->total;
   }
   function total_tl($i){
           $this->db->select('sum(total) as total');
           $this->db->like('tanggal', date("Y-").sprintf('%02s', $i), 'after');
           $result = $this->db->get('transaksi_lain')->row();
           return $result->total;
   }
           
   function lunas($tipe, $id)
   {
        $this->db->set('pembayaran', 'grand_total', FALSE);
        $this->db->set('sisa', 0, FALSE);
        $this->db->where('no_penjualan', $id);
        if($tipe == 'ecer'){
            $this->db->update('penjualan_ecer');
        }else{
            $this->db->update('penjualan_partai');
        }
        
   }    
}