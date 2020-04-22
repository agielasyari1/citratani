<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TR_model extends CI_Model {
    
    var $table = 'transaksi_lain';
    var $column = array('id_transaksi','keterangan','tanggal','total'); //set column field database for order and search
    var $order = array('id_transaksi' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($bulan, $tahun, $tipe)
    {
        
        $like_exp = $tahun.'-'.$bulan.'-';
        
        if($tipe == 'pp'){
            $this->table = "penjualan_partai";
            $this->column = array('no_penjualan','updated_date','nama_toko','grand_total','pembayaran', 'sisa');
            $this->order = array('no_penjualan' => 'desc');
            $this->db->from($this->table);
            $this->db->like('updated_date',$like_exp, 'after');
            
        }else if($tipe == 'pe'){
            $this->table = "penjualan_ecer";
            $this->column = array('no_penjualan','updated_date','nama_pembeli','grand_total','pembayaran', 'sisa');
            $this->order = array('no_penjualan' => 'desc');
            $this->db->from($this->table);
            $this->db->like('updated_date',$like_exp, 'after');
            
        }else if($tipe == 'pb'){
            $this->table = "pembelian";
            $this->column = array('no_pembelian','updated_date','id_supplier','total','pembayaran', 'sisa');
            $this->order = array('no_pembelian' => 'desc');
            $this->db->from($this->table);
            $this->db->like('updated_date',$like_exp, 'after');
        }else{
            $this->table = 'transaksi_lain';
            $this->column = array('id_transaksi','keterangan','tanggal','total'); //set column field database for order and search
            $this->order = array('id_transaksi' => 'desc');
            $this->db->from($this->table);
            $this->db->like('tanggal',$like_exp, 'after');
        }
        
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
        
    function count_filtered($bulan, $tahun, $tipe)
    {
        $this->_get_datatables_query($bulan, $tahun, $tipe);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($bulan, $tahun, $tipe)
    {
        $like_exp = $tahun.'-'.$bulan.'-';
        $this->db->from($this->table);
        $this->db->like('tanggal', $like_exp, 'after');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->count_all_results();
    }
    
    function get_datatables($bulan, $tahun, $tipe)
    {
        $this->_get_datatables_query($bulan, $tahun, $tipe);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function daftar_tahun() {

        $query = $this->db->select('DISTINCT(LEFT(`tanggal`, 4)) as tahun');
        $query = $this->db->get('transaksi_lain');
        $list = array();
        if($query->result()){
            foreach ($query->result() as $tahun) {
                $list[$tahun->tahun] = $tahun->tahun;
            }
        } 

        return $list;
      
    }
    
    function  get_pemasukan($month, $year){
        
        $this->db->select('COALESCE(SUM(`pembayaran`),0) as je');
        $this->db->like('created_date',$year.'-'.$month, 'after');
        $result = $this->db->get('penjualan_ecer')->row();
        $this->db->select('COALESCE(SUM(`pembayaran`),0) as jp');
        $this->db->like('created_date',$year.'-'.$month, 'after');
        $result2 = $this->db->get('penjualan_partai')->row();
        
        return  $result->je + $result2->jp;
        
    }
    function  get_pengeluaran($month, $year){
        
        $this->db->select('COALESCE(SUM(`pembayaran`),0) as tb');
        $this->db->like('tanggal_permintaan',$year.'-'.$month, 'after');
        $result = $this->db->get('pembelian')->row();
        $this->db->select('COALESCE(SUM(`total`),0) as tl');
        $this->db->like('tanggal',$year.'-'.$month, 'after');
        $result2 = $this->db->get('transaksi_lain')->row();
        
        return  $result->tb + $result2->tl;
        
    }
            
    function total_table_jual($month, $year){
        $this->db->select('FORMAT(COALESCE(SUM(`total`),0),0,"de_DE") as ttj');
        $this->db->like('tanggal',$year.'-'.$month, 'after');
        $result = $this->db->get('transaksi_lain');
        $data = $result->row();
        
        return $data;
    }
    
    function get_persediaan_awal($bulan, $tahun){
        
        $jum_pa = 0;
        
        $this->db->select('id_barang, stok, hrg_beli');
        $result = $this->db->get('barang');
        
      
            foreach ($result->result() as $barang){
            
                $jum_pa += ($barang->stok + $this->qty_sold($barang->id_barang, $bulan, $tahun) - $this->qty_bought($barang->id_barang, $bulan, $tahun)) * $barang->hrg_beli;
            
                }   
       
        
        return $jum_pa;
    }
    
    
    function get_persediaan_akhir($bulan, $tahun){
        
        $jum_pa = 0;
        
        $this->db->select('id_barang, stok, hrg_beli');
        $result = $this->db->get('barang');
        
            foreach ($result->result() as $barang){
            
                $jum_pa += $barang->stok * $barang->hrg_beli;
            }
       
        return $jum_pa;
    }
    
    function qty_sold($id, $bulan, $tahun){
        
            $qty_partai = 0;
            $qty_ecer = 0;
            for($i = (int)$bulan ; $i < (int)date("m") + 1; $i++){
                if($i < 10){
                    $month = "0".$i;
                }else{
                    $month = $i;
                }
                
                $this->db->select("COALESCE(SUM(qty),0) as qty");
                $this->db->where("d.no_penjualan = p.no_penjualan");
                $this->db->where("d.id_barang = b.id_barang");
                $this->db->where("d.id_barang", $id);
                $this->db->like("p.created_date",$tahun."-".$bulan,'after');
                $result = $this->db->get("penjualan_partai p, d_penjualan_partai d, barang b")->row();
                $qty_partai += $result->qty;
                
                $this->db->select("COALESCE(SUM(qty),0) as qty");
                $this->db->where("d.no_penjualan = p.no_penjualan");
                $this->db->where("d.id_barang = b.id_barang");
                $this->db->where("d.id_barang", $id);
                $this->db->like("p.created_date",$tahun."-".$bulan,'after');
                $result2 = $this->db->get("penjualan_ecer p, d_penjualan_ecer d, barang b")->row();
                $qty_ecer += $result2->qty;
                
            }
        
        return  $qty_ecer + $qty_partai;
        
    }
    
    function qty_bought($id, $bulan, $tahun){
        
         $qty= 0;
         for($i = (int)$bulan ; $i < (int)date("m") + 1; $i++){
                if($i < 10){
                    $month = "0".$i;
                }else{
                    $month = $i;
                }
                $this->db->select("COALESCE(SUM(qty),0) as qty");
                $this->db->where("d.no_pembelian = p.no_pembelian");
                $this->db->where("d.id_barang = b.id_barang");
                $this->db->where("d.id_barang", $id);
                $this->db->like("p.created_date",$tahun."-".$bulan,'after');
                $result = $this->db->get("pembelian p, d_pembelian d, barang b")->row();
                $qty += $result->qty;
        }
        
        return $qty;
        
    }
    
}