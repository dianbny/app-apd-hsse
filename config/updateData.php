<?php
    require_once "dataBase.php";
    
    class updateData extends dataBase {

        //Update Data Coveralls
        public function saveUpdateDataCoveralls($id, $merk, $type, $size, $stock, $location, $rack, $rackNum, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_coveralls SET _merk = '$merk', _jenis = '$type', _ukuran = '$size', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _id_user = '$user', _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }
        
        //Update Data Safety Shoes
        public function saveUpdateDataSafetyShoes($id, $merk, $type, $size, $stock, $location, $rack, $rackNum, $expired, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_safety_shoes SET _merk = '$merk', _jenis = '$type', _ukuran = '$size', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _expired = '$expired', _id_user = '$user', _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Safety Helmet
        public function saveUpdateDataSafetyHelmet($id, $merk, $type, $color, $stock, $location, $rack, $rackNum, $expired, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_safety_helmet SET _merk = '$merk', _jenis = '$type', _warna = '$color', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _expired = '$expired', _id_user = '$user', _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Safety Glasses
        public function saveUpdateDataSafetyGlasses($id, $merk, $type, $warna, $stock, $location, $rack, $rackNum, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_safety_glasses SET _merk = '$merk', _jenis = '$type', _warna = '$warna', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _id_user = '$user', _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Safety Gloves
        public function saveUpdateDataSafetyGloves($id, $merk, $type, $stock, $location, $rack, $rackNum, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_safety_gloves SET _merk = '$merk', _jenis = '$type', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _id_user = '$user' , _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Souvenir
        public function saveUpdateDataSouvenir($id, $type, $stock, $location, $rack, $rackNum, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_souvenir SET _jenis = '$type', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _id_user = '$user' , _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Other APD
        public function saveUpdateDataOther($id, $type, $stock, $location, $rack, $rackNum, $expired, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_other SET _jenis = '$type', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _expired = '$expired', _id_user = '$user' , _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Other APD Not Expired
        public function saveUpdateDataOtherNE($id, $type, $stock, $location, $rack, $rackNum, $user, $updatedAt){
            mysqli_query($this->koneksi, "UPDATE _tb_other SET _jenis = '$type', _stok = '$stock', _lokasi_apd = '$location', _rack = '$rack', _detail_rack_num = '$rackNum', _id_user = '$user' , _updated_at = '$updatedAt' WHERE _id = '$id' ");
        }

        //Update Data Stock
        public function updateStockAPD($tbl, $stock, $user, $updatedAt, $id){
            mysqli_query($this->koneksi, "UPDATE $tbl SET _stok = '$stock', _id_user = '$user', _updated_at = '$updatedAt' WHERE _id = '$id'");
        }

        //Update Data Status
        public function updateStatusAPD($tbl, $qty, $user, $requester, $status, $information, $updatedAt, $id){
            mysqli_query($this->koneksi, "UPDATE $tbl SET _jumlah = '$qty', _id_user = '$user', _id_requester = '$requester', _status = '$status', _keterangan = '$information', _updated_at = '$updatedAt' WHERE _id = '$id'");
        }

        //Update Data User
        public function updateDataUser($fullName, $email, $username, $level, $status, $updatedAt, $id){
            mysqli_query($this->koneksi, "UPDATE _tb_user_login SET _nama = '$fullName', _email = '$email', _username = '$username', _level = '$level', _status = '$status', _updated_at = '$updatedAt' WHERE _id = '$id'");
        }

        //Update Password User
        public function updatePassUser($password, $updatedAt, $id){
            mysqli_query($this->koneksi, "UPDATE _tb_user_login SET _password = '$password', _updated_at = '$updatedAt' WHERE _id = '$id'");
        }

        //Update Status Request
        public function updateStatusRequest($tabel, $col, $status, $updatedAt, $id){
            mysqli_query($this->koneksi, "UPDATE $tabel SET $col = '$status', _updated_at = '$updatedAt' WHERE _id = '$id'");
        }


    }