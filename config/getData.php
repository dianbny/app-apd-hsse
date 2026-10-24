<?php
    require_once "dataBase.php";
    
    class getData extends dataBase {

		//Get Data 1 Clause
		public function getDataFr($tabel, $colfr, $datafr){
			$data = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colfr = '$datafr' AND _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($data);
			
			return $getData;
		}

		//Get Data by Limit Desc
		public function getDataByLimit($tabel){
			$data = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE _deleted_at IS NULL ORDER BY _id DESC LIMIT 1");
			$getData = mysqli_fetch_assoc($data);
			
			return $getData;
		}

		//Get Data by Limit Desc
		public function getDataByLimitFr($tabel, $colFr, $dtFr){
			$data = mysqli_query($this->koneksi,"SELECT * FROM $tabel WHERE $colFr = '$dtFr' AND _deleted_at IS NULL ORDER BY _id DESC LIMIT 1");
			$getData = mysqli_fetch_assoc($data);
			
			return $getData;
		}

        //Get Data All 0 Clause
        public function getDataAll($table, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 3 Clause Between
        public function getDataAllFrBW($table, $colFr, $dtFr, $dtSc, $dtTh, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colFr = '$dtFr' AND DATE(_updated_at) BETWEEN '$dtSc' AND '$dtTh' AND _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 3 Clause Between
        public function getDataAllScBW($table, $colFr, $dtFr, $colSc, $dtSc, $dtTh, $dtFo, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colFr = '$dtFr' AND $colSc = '$dtSc' AND DATE(_updated_at) BETWEEN '$dtTh' AND '$dtFo' AND _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data Between
        public function getDataAllBW($table, $colFr, $dtFr, $dtSc, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE DATE($colFr) BETWEEN '$dtFr' AND '$dtSc' ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data Between
        public function getDataAllBWUsr($table, $colUsr, $dataUsr, $colFr, $dtFr, $dtSc, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colUsr = '$dataUsr' AND DATE($colFr) BETWEEN '$dtFr' AND '$dtSc' ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 0 Clause Desc
        public function getDataAllDesc($table, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE _deleted_at IS NULL ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 0 Clause Desc Limit
        public function getDataAllNDDesc($table, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table ORDER BY $col DESC LIMIT 50");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 2 Clause Month Year Desc
        public function getDataAllDescMY($table, $dtFr, $dtSc, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE MONTH(_updated_at) = '$dtFr' AND YEAR(_updated_at) = '$dtSc' AND _deleted_at IS NULL ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 2 Clause Month Year Desc
        public function getDataAllDescMYUsr($table, $colFr, $dtFr, $dtSc, $dtTh, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colFr = '$dtFr' AND MONTH(_updated_at) = '$dtSc' AND YEAR(_updated_at) = '$dtTh' AND _deleted_at IS NULL ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 2 Clause Month Year Desc No Deleted
        public function getDataAllDescMYND($table, $colMY, $dtFr, $dtSc, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE MONTH($colMY) = '$dtFr' AND YEAR($colMY) = '$dtSc' ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 2 Clause Month Year Desc No Deleted
        public function getDataAllDescMYNDUsr($table, $colUs, $dtUs, $colMY, $dtFr, $dtSc, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colUs = '$dtUs' AND MONTH($colMY) = '$dtFr' AND YEAR($colMY) = '$dtSc' ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 1 Clause Not Equals
        public function getDataAllNE($table, $colfr, $datafr, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colfr != '$datafr' AND _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 1 Clause Not Equals
        public function getDataAllDescNE($table, $colfr, $datafr, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colfr != '$datafr' AND _deleted_at IS NULL ORDER BY $col DESC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 1 Clause
        public function getDataAllFr($table, $colfr, $datafr, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colfr = '$datafr' AND _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Data All 1 Clause
        public function getDataAllLikeFr($table, $colfr, $datafr, $col){
			$dataAll = mysqli_query($this->koneksi,"SELECT * FROM $table WHERE $colfr LIKE '%$datafr%' AND _deleted_at IS NULL ORDER BY $col ASC");
			while($listDataAll = mysqli_fetch_assoc($dataAll)){
				$result[] = $listDataAll;
			}

			return $result;
		}

		//Get Sum Table
		public function getSumData($table){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_stok) AS stok FROM $table WHERE _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}

		//Get Sum Table 1 Clauses
		public function getSumDataFr($table, $colFr, $dtFr){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_jumlah) AS jumlah FROM $table WHERE $colFr = '$dtFr' AND  _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}

		//Get Sum Table 2 Clauses By Year
		public function getSumDataByYears($table, $colFr, $dtFr, $year){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_jumlah) AS jumlah FROM $table WHERE $colFr = '$dtFr' AND YEAR(_created_at) = '$year' AND  _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}

		//Get Sum Table 2 Clauses By Year
		public function getSumDataByMY($table, $colFr, $dtFr, $month, $year){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_jumlah) AS jumlah FROM $table WHERE $colFr = '$dtFr' AND MONTH(_created_at) = '$month' AND YEAR(_created_at) = '$year' AND  _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}

		//Get Sum Expired
		public function getSumExpired($table, $col, $dtFr){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_stok) AS stok FROM $table WHERE YEAR($col) < '$dtFr' AND _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}

		//Get Sum Expired
		public function getSumWarning($table, $col, $dtFr){
			$sumData = mysqli_query($this->koneksi,"SELECT SUM(_stok) AS stok FROM $table WHERE YEAR($col) = '$dtFr' AND _deleted_at IS NULL");
			$getData = mysqli_fetch_assoc($sumData);
			
			return $getData;
		}


    }