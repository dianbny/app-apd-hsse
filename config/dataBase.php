<?php
	class dataBase {

		private $host = "localhost";
		private $username = "root";
		private $password = "";
		private $database = "_db_hsse_bunyu_field";
		protected $koneksi = "";

		function __construct(){
			$this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
			if (mysqli_connect_errno()){
				echo "Koneksi database gagal : " . mysqli_connect_error();
			}
		}
    }

?>