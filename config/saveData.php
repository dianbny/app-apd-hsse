<?php
    require_once "dataBase.php";
    
    class saveData extends dataBase {
        
        //Save Data New User
        public function saveDataUser($fullName, $email, $username, $password, $level, $status, $createdAt, $updatedAt){
            
            mysqli_query($this->koneksi,"INSERT INTO _tb_user_login (_nama, _email, _username, _password, _level, _status, _created_at, _updated_at) VALUES ('$fullName','$email','$username','$password','$level','$status','$createdAt', '$updatedAt')");
        }

        //Save Data New Coveralls
        public function saveDataCoveralls($merk, $type, $size, $stock, $location, $rack, $rackNum, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi,"INSERT INTO _tb_coveralls (_merk, _jenis, _ukuran, _stok, _lokasi_apd, _rack, _detail_rack_num, _foto, _id_user, _created_at, _updated_at) VALUES ('$merk','$type','$size','$stock','$location','$rack','$rackNum','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Safety Shoes
        public function saveDataSafetyShoes($merk, $type, $size, $stock, $location, $rack, $rackNum, $expired, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_safety_shoes (_merk, _jenis, _ukuran, _stok, _lokasi_apd, _rack, _detail_rack_num, _expired, _foto, _id_user, _created_at, _updated_at) VALUES ('$merk','$type','$size','$stock','$location','$rack','$rackNum','$expired','$photo','$user','$createdAt','$updatedAt')");
        }

        //Save Data New Safety Helmet
        public function saveDataSafetyHelmet($merk, $type, $color, $stock, $location, $rack, $rackNum, $expired, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_safety_helmet (_merk, _jenis, _warna, _stok, _lokasi_apd, _rack, _detail_rack_num, _expired, _foto, _id_user, _created_at, _updated_at) VALUES ('$merk','$type','$color','$stock','$location','$rack','$rackNum','$expired','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Safety Glasses
        public function saveDataSafetyGlasses($merk, $type, $warna, $stock, $location, $rack, $rackNum, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_safety_glasses (_merk, _jenis, _warna, _stok, _lokasi_apd, _rack, _detail_rack_num, _foto, _id_user, _created_at, _updated_at) VALUES ('$merk','$type','$warna','$stock','$location','$rack','$rackNum','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Safety Gloves
        public function saveDataSafetyGloves($merk, $type, $stock, $location, $rack, $rackNum, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_safety_gloves (_merk, _jenis, _stok, _lokasi_apd, _rack, _detail_rack_num, _foto, _id_user, _created_at, _updated_at) VALUES ('$merk','$type','$stock','$location','$rack','$rackNum','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Souvenir
        public function saveDataSouvenir($type, $stock, $location, $rack, $rackNum, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_souvenir (_jenis, _stok, _lokasi_apd, _rack, _detail_rack_num, _foto, _id_user, _created_at, _updated_at) VALUES ('$type','$stock','$location','$rack','$rackNum','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Other APD
        public function saveDataOther($type, $stock, $location, $rack, $rackNum, $expired, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_other (_jenis, _stok, _lokasi_apd, _rack, _detail_rack_num, _expired, _foto, _id_user, _created_at, _updated_at) VALUES ('$type','$stock','$location','$rack','$rackNum','$expired','$photo','$user','$createdAt', '$updatedAt')");
        }

        //Save Data New Other APD Not Expired
        public function saveDataOtherNE($type, $stock, $location, $rack, $rackNum, $photo, $user, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_other (_jenis, _stok, _lokasi_apd, _rack, _detail_rack_num, _foto, _id_user, _created_at, _updated_at) VALUES ('$type','$stock','$location','$rack','$rackNum','$photo','$user','$createdAt', '$updatedAt')");
        }

         //Save Data Status Coveralls
         public function saveDataStatusCoveralls($id, $qty, $user, $requester, $status, $keterangan, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_status_coveralls (_id_coveralls, _jumlah, _id_user, _id_requester, _status, _keterangan, _created_at, _updated_at) VALUES ('$id','$qty','$user','$requester','$status','$keterangan','$createdAt', '$updatedAt')");
        }

         //Save Data Status Safety Shoes
         public function saveDataStatusSafetyShoes($id, $qty, $user, $requester, $status, $keterangan, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_status_safety_shoes (_id_safety_shoes, _jumlah, _id_user, _id_requester, _status, _keterangan, _created_at, _updated_at) VALUES ('$id','$qty','$user','$requester','$status','$keterangan','$createdAt', '$updatedAt')");
        }

        //Save Data Status Safety Helmet
        public function saveDataStatusSafetyHelmet($id, $qty, $user, $requester, $status, $keterangan, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_status_safety_helmet (_id_safety_helmet, _jumlah, _id_user, _id_requester, _status, _keterangan, _created_at, _updated_at) VALUES ('$id','$qty','$user','$requester','$status','$keterangan','$createdAt', '$updatedAt')");
        }

        //Save Data Status Safety Glasses
        public function saveDataStatusSafetyGlasses($id, $qty, $user, $requester, $status, $keterangan, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_status_safety_glasses (_id_safety_glasses, _jumlah, _id_user, _id_requester, _status, _keterangan, _created_at, _updated_at) VALUES ('$id','$qty','$user','$requester','$status','$keterangan','$createdAt', '$updatedAt')");
        }

        //Save Data Status
        public function saveDataStatus($tabel, $col, $id, $qty, $user, $requester, $status, $keterangan, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO $tabel ($col, _jumlah, _id_user, _id_requester, _status, _keterangan, _created_at, _updated_at) VALUES ('$id','$qty','$user','$requester','$status','$keterangan','$createdAt', '$updatedAt')");
        }

        //Save Data Activity 
        public function saveDataActivity($user, $activity, $createdAt){
            mysqli_query($this->koneksi, "INSERT INTO _tb_activity (_id_user, _activity, _created_at) VALUES ('$user','$activity','$createdAt')");
        }

        //Save Data Borrowing 
        public function saveBorrowingReq($tabel, $colId, $user, $name, $position, $needs, $id, $qty, $borrowDate, $returnDate, $status, $returnStatus, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO $tabel (_id_user, _nama, _jabatan, _keperluan, $colId, _jumlah, _tgl_peminjaman, _tgl_pengembalian, _status, _status_pengembalian, _created_at, _updated_at) VALUES ('$user','$name','$position','$needs','$id','$qty','$borrowDate','$returnDate','$status','$returnStatus','$createdAt','$updatedAt')");
        }

        //Save Data Request 
        public function saveRequest($tabel, $colId, $user, $name, $position, $reason, $id, $qty, $status, $foto, $createdAt, $updatedAt){
            mysqli_query($this->koneksi, "INSERT INTO $tabel (_id_user, _nama, _jabatan, _keterangan, $colId, _jumlah, _status, _foto, _created_at, _updated_at) VALUES ('$user','$name','$position','$reason','$id','$qty','$status','$foto','$createdAt','$updatedAt')");
        }

    }