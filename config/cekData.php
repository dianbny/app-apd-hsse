<?php
    require_once "dataBase.php";
    
    class cekData extends dataBase {

        //Cek Data
        public function cekLogin($username, $password, $level){
            $cekUser = mysqli_query($this->koneksi, "SELECT * FROM _tb_user_login WHERE _username = '$username' AND _password = '$password' AND _level = '$level' AND _status = 'Approved' AND _deleted_at IS NULL");
			$cek = mysqli_num_rows($cekUser);
			if($cek > 0){
				return true;
			}

			return false;
        }

        //Cek Data 0 Clause
        public function cekDataAll($tabel){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }
        

        //Cek Data 0 Clause
        public function cekDataAllND($tabel){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 1 Clause
        public function cekDataFr($tabel, $colfr, $datafr){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

         //Cek Data 1 Clause No Deleted
         public function cekDataFrND($tabel, $colfr, $datafr){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr'");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 1 Clause
        public function cekDataFrLKS($tabel, $colfr, $datafr){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE DATE($colfr) <= '$datafr' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 3 Clause
        public function cekDataThLKS($tabel, $colfr, $datafr, $colsc, $datasc, $colth, $datath){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE DATE($colfr) <= '$datafr' AND $colsc = '$datasc' AND $colth = '$datath' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 4 Clause
        public function cekDataFoLKS($tabel, $colfr, $datafr, $colsc, $datasc, $colth, $datath, $colfo, $datafo){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE DATE($colfr) <= '$datafr' AND $colsc = '$datasc' AND $colth = '$datath' AND $colfo = '$datafo' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 1 Clause
        public function cekDataLikeFr($tabel, $colfr, $datafr){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr LIKE '%$datafr%' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

         //Cek Data 1 Clause Between
         public function cekDataFrBW($tabel, $colfr, $datafr, $dataSc, $dataTh){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND DATE(_updated_at) BETWEEN '$dataSc' AND '$dataTh' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 1 Clause Between User
        public function cekDataScBW($tabel, $colfr, $datafr, $colSc, $dataSc, $dataTh, $dataFo){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND $colSc = $dataSc AND DATE(_updated_at) BETWEEN '$dataTh' AND '$dataFo' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek  Between
        public function cekDataBW($tabel, $colfr, $dataFr, $dataSc){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE DATE($colfr) BETWEEN '$dataFr' AND '$dataSc'");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek  Between
        public function cekDataBWUsr($tabel, $colUsr, $dataUsr, $colfr, $dataFr, $dataSc){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colUsr = '$dataUsr' AND DATE($colfr) BETWEEN '$dataFr' AND '$dataSc'");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 1 Clause Not Equals
        public function cekDataFrNE($tabel, $colfr, $datafr){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr != '$datafr' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        //Cek Data 2 Clause
        public function cekDataSc($tabel, $colfr, $colsc, $datafr, $datasc){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND $colsc = '$datasc' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekDataScMY($tabel, $datafr, $datasc){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE MONTH(_updated_at) = '$datafr' AND YEAR(_updated_at) = '$datasc' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekDataScMYUsr($tabel, $colfr, $datafr, $datasc, $datath){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND MONTH(_updated_at) = '$datasc' AND YEAR(_updated_at) = '$datath' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekDataScMYND($tabel, $col, $datafr, $datasc){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE MONTH($col) = '$datafr' AND YEAR($col) = '$datasc'");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekDataThMYND($tabel, $col, $datafr, $datasc, $colx, $datax){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE MONTH($col) = '$datafr' AND YEAR($col) = '$datasc' AND $colx = '$datax'");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekDataThMY($tabel, $colfr, $datafr, $datasc, $datath){
            $cekData = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND MONTH(_updated_at) = '$datasc' AND YEAR(_updated_at) = '$datath' AND _deleted_at IS NULL");
			$cekJumlah = mysqli_num_rows($cekData);
			
			return $cekJumlah;
        }

        public function cekFieldName($tabel, $col){
            $cekKolom = mysqli_query($this->koneksi, "SELECT * FROM INFORMATION_SCHEMA.columns WHERE table_name = '$tabel' AND column_name = '$col'");
            $cekJumlah = mysqli_num_rows($cekKolom);
			
			return $cekJumlah;
        }

        public function cekTableName($tabel){
            $cekKolom = mysqli_query($this->koneksi, "SELECT * FROM INFORMATION_SCHEMA.columns WHERE table_name = '$tabel'");
            $cekJumlah = mysqli_num_rows($cekKolom);
			
			return $cekJumlah;
        }



    }