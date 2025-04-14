<?php
class TransaksiModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllTransaksi($user_id, $role) {
        if ($role === 'admin') {
           
            $query = "
                SELECT t.id,u.nama,  p.nama_produk, t.jumlah, t.diskon, t.total_harga_setelah_diskon, t.tanggal_transaksi 
                FROM transaksi t
                JOIN produk p ON t.produk_id = p.id JOIN user u ON t.user_id = u.id ";
        } else {
            
            $query = "
                SELECT t.id, u.nama,  p.nama_produk, t.jumlah, t.diskon, t.total_harga_setelah_diskon, t.tanggal_transaksi 
                FROM transaksi t
                JOIN produk p ON t.produk_id = p.id JOIN user u ON t.user_id = u.id
                WHERE t.user_id = $user_id
            ";
        }
        
        $result = mysqli_query($this->conn, $query);
    
        
        if (!$result) {
            die('Query gagal: ' . mysqli_error($this->conn));
        }
    
        $transaksiList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $transaksiList[] = $row;
        }
    
        return $transaksiList;
    }
}    
