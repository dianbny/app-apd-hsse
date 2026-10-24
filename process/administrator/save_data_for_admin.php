<?php
    //error_reporting(0);

    session_start(); 

    require_once "../../config/const.php";

    //Cek Jika Session Belum Ada
    if(!isset($_SESSION['status-login']) || !isset($_SESSION['level'])){ 
        header('location:'.BASEURL);
    }

    //Cek Jika Data Session Sudah Ada
    if($_SESSION['status-login'] != "success"){
        header('location:'.BASEURL.'/logout');
    }
    elseif($_SESSION['level'] != "administrator"){
        header('location:'.BASEURL.'/logout');
    }

    //Require
    require_once "../../config/cekData.php";
    require_once "../../config/getData.php";
    require_once "../../config/saveData.php";
    require_once "../../config/updateData.php";
    require_once "../../config/deleteData.php";
    
    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();
    $saveData = new saveData();
    $updateData = new updateData();
    $deleteData = new deleteData();
    
    //Waktu 
    date_default_timezone_set("Asia/Kuala_Lumpur");
    setlocale(LC_ALL, 'id-ID', 'id_ID');

    //Filter Data
    function filterInput($data){
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }

    //Get Action 
    $page = $_GET['action'];
    $sub = explode("-", $page);
    $category;  
    $tabel;

    if(count($sub) == 4){
        $category = $sub[3];
        $tabel = $sub[3];
    }
    elseif(count($sub) == 5) {
        $category = $sub[3].'-'.$sub[4];
        $tabel = $sub[3].'_'.$sub[4];
    }

    //Datetime
    $createdAt = filterInput(date('Y-m-d H:i:s'));
    $updatedAt = filterInput(date('Y-m-d H:i:s'));

    //Save Coveralls
    if($_GET['action'] == 'save-data-new-coveralls'){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['size']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[A-Z]*$/", $_POST['size']) || strlen($_POST['size']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Ukuran tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Nomor rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-coveralls');
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $size = filterInput($_POST['size']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
            
                //Get File Upload
                $f1 = $_FILES['f1']['tmp_name'];
                $f1_name = $_FILES['f1']['name'];
                $f1_type = $_FILES['f1']['type'];
                $f1_size = $_FILES['f1']['size'];
                $format = strtolower(pathinfo($f1_name, PATHINFO_EXTENSION));

                //Validasi Extensi
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $allowed_mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
    
                //Ambil MIME Type asli menggunakan finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $f1);
                finfo_close($finfo);
    
                //Cek Extensi dan MIME Type
                if (in_array($format, $allowed_extensions) && in_array($mime_type, $allowed_mime_types)) { 
                            
                    if($f1_size <= 1000000){
                        $enkrips = hash('sha256', date('YmdHis'));
                        $fileName = $enkrips.".".$format;
                            
                        //Upload
                        move_uploaded_file($f1,'../../uploads/coveralls/'.$fileName);
                                
                        
                        $saveData->saveDataCoveralls(strtoupper($merk), $type, $size, $stock, $location, $rackCode, $rackNum, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);
    
                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data berhasil tersimpan";
    
                        header('location:'.BASEURL.'/add-apd-coveralls');
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Ukuran foto tidak valid !";

                        header('location:'.BASEURL.'/add-apd-coveralls');
    
                    }
                }
    
                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Format foto tidak valid !";
    
                    header('location:'.BASEURL.'/add-apd-coveralls');
    
                }
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-coveralls');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Update Data Coveralls
    elseif($_GET['action'] == "save-update-data-coveralls"){
        
        //Jika Submit 
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Get ID
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['size']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[A-Z]*$/", $_POST['size']) || strlen($_POST['size']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Ukuran tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Nomor rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $size = filterInput($_POST['size']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
               
                $updateData->saveUpdateDataCoveralls($id, strtoupper($merk), $type, $size, $stock, $location, $rackCode, $rackNum, $_SESSION['id_user'], $updatedAt);
                
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);
    
                $_SESSION['status'] = "success";  
                $_SESSION['msg'] = "Data berhasil diperbarui";
                header('location:'.BASEURL.'/edit-apd-coveralls'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-coveralls');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Save New Data Safety Shoes
    elseif($_GET['action'] == "save-data-new-safety-shoes"){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['size']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock']) || empty($_POST['expired'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }
            
            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[0-9\/]*$/", $_POST['size']) || strlen($_POST['size']) > 5){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Ukuran tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Nomor rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            elseif(!preg_match("/^[0-9-\/]*$/", $_POST['expired']) || strlen($_POST['expired']) > 10){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tanggal kadaluarsa tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-shoes');
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $size = filterInput($_POST['size']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
                $expired = filterInput($_POST['expired']);
               
                //Get File Upload
                $f1 = $_FILES['f1']['tmp_name'];
                $f1_name = $_FILES['f1']['name'];
                $f1_type = $_FILES['f1']['type'];
                $f1_size = $_FILES['f1']['size'];
                $format = pathinfo($f1_name, PATHINFO_EXTENSION);

                //Validasi Extensi
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $allowed_mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
    
                //Ambil MIME Type asli menggunakan finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $f1);
                finfo_close($finfo);
    
                //Cek Extensi dan MIME Type
                if (in_array($format, $allowed_extensions) && in_array($mime_type, $allowed_mime_types)) { 
                            
                    if($f1_size <= 1000000){
                        $enkrips = hash('sha256', date('YmdHis'));
                        $fileName = $enkrips.".".$format;
                            
                        //Upload
                        move_uploaded_file($f1,'../../uploads/safety-shoes/'.$fileName);
                                
                        
                        $saveData->saveDataSafetyShoes(strtoupper($merk), $type, $size, $stock, $location, $rackCode, $rackNum,  $expired, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data berhasil tersimpan";

                        header('location:'.BASEURL.'/add-apd-safety-shoes');
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Ukuran foto tidak valid !";

                        header('location:'.BASEURL.'/add-apd-safety-shoes');
    
                    }
                }

                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Format foto tidak valid !";
    
                    header('location:'.BASEURL.'/add-apd-safety-shoes');
    
                }
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-shoes');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Update Data Safety Shoes
    elseif($_GET['action'] == "save-update-data-safety-shoes"){
        
        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Get ID
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            
            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['size']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock']) || empty($_POST['expired'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9\/]*$/", $_POST['size']) || strlen($_POST['size']) > 5){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Ukuran tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Nomor rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9-\/]*$/", $_POST['expired']) || strlen($_POST['expired']) > 10){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tanggal kadaluarsa tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $size = filterInput($_POST['size']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
                $expired = filterInput($_POST['expired']);
                
                $updateData->saveUpdateDataSafetyShoes($id, strtoupper($merk), $type, $size, $stock, $location, $rackCode, $rackNum, $expired, $_SESSION['id_user'], $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);
    
                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data berhasil diperbarui";
    
                header('location:'.BASEURL.'/edit-apd-safety-shoes'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-shoes');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Save New Data Safety Helmet
    elseif($_GET['action'] == "save-data-new-safety-helmet"){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['color']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock']) || empty($_POST['expired'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }  
            
            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['color']) || strlen($_POST['color']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Warna tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = " Nomor rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            elseif(!preg_match("/^[0-9-\/]*$/", $_POST['expired']) || strlen($_POST['expired']) > 10){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tanggal kadaluarsa tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-helmet');
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $color = filterInput($_POST['color']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
                $expired = filterInput($_POST['expired']);
               
                //Get File Upload
                $f1 = $_FILES['f1']['tmp_name'];
                $f1_name = $_FILES['f1']['name'];
                $f1_type = $_FILES['f1']['type'];
                $f1_size = $_FILES['f1']['size'];
                $format = pathinfo($f1_name, PATHINFO_EXTENSION);

                //Validasi Extensi
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $allowed_mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
    
                //Ambil MIME Type asli menggunakan finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $f1);
                finfo_close($finfo);
    
                //Cek Extensi dan MIME Type
                if (in_array($format, $allowed_extensions) && in_array($mime_type, $allowed_mime_types)) { 
                            
                    if($f1_size <= 1000000){
                        $enkrips = hash('sha256', date('YmdHis'));
                        $fileName = $enkrips.".".$format;
                            
                        //Upload
                        move_uploaded_file($f1,'../../uploads/safety-helmet/'.$fileName);
                                
                        
                        $saveData->saveDataSafetyHelmet(strtoupper($merk), $type, $color, $stock, $location, $rackCode, $rackNum, $expired, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data berhasil tersimpan";

                        header('location:'.BASEURL.'/add-apd-safety-helmet');
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Ukuran foto tidak valid !";

                        header('location:'.BASEURL.'/add-apd-safety-helmet');
    
                    }
                }

                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Format foto tidak valid !";
    
                    header('location:'.BASEURL.'/add-apd-safety-helmet');
    
                }
    
            }
        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-helmet');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Update Data Safety Helmet
    elseif($_GET['action'] == "save-update-data-safety-helmet"){
        
        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Get ID
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['color']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock']) || empty($_POST['expired'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }  
            
            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['color']) || strlen($_POST['color']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Warna tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = " Nomor rak tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            elseif(!preg_match("/^[0-9-\/]*$/", $_POST['expired']) || strlen($_POST['expired']) > 10){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tanggal kadaluarsa tidak valid !";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }

            else {

                //Simpan Inputan Pada Variabel
                $id = filterInput($_GET['id']);
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $color = filterInput($_POST['color']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);
                $expired = filterInput($_POST['expired']);

                $updateData->saveUpdateDataSafetyHelmet($id, strtoupper($merk), $type, $color, $stock, $location, $rackCode, $rackNum, $expired, $_SESSION['id_user'], $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data berhasil diperbarui";

                header('location:'.BASEURL.'/edit-apd-safety-helmet'.'/'.$id);
            }
        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-helmet');
        }
    }

//--------------------------------------------------------------------------------------------------------------//

    //Save New Data Safety Glasses
    elseif($_GET['action'] == "save-data-new-safety-glasses"){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Cek Required Form
            if(empty($_POST['merk']) || empty($_POST['type']) || empty($_POST['color']) || empty($_POST['location']) || empty($_POST['rack-code']) || empty($_POST['rack-num']) || empty($_POST['stock'])){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form tidak boleh kosong !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            //Validasi Form Inputan
            elseif(!preg_match("/^[a-zA-Z0-9-' .]*$/", $_POST['merk']) || strlen($_POST['merk']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Brand/merk tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['type']) || strlen($_POST['type']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Tipe tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }  
            
            elseif(!preg_match("/^[a-zA-Z ]*$/", $_POST['color']) || strlen($_POST['color']) > 50){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Warna tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['stock']) || strlen($_POST['stock']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Jumlah tersedia tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            elseif(!preg_match("/^[a-zA-Z-' .]*$/", $_POST['location']) || strlen($_POST['location']) > 200){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Lokasi tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-code']) || strlen($_POST['rack-code']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Kode rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            elseif(!preg_match("/^[0-9]*$/", $_POST['rack-num']) || strlen($_POST['rack-num']) > 3){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = " Nomor rak tidak valid !";

                header('location:'.BASEURL.'/add-apd-safety-glasses');
            }

            else {

                //Simpan Inputan Pada Variabel
                $merk = filterInput($_POST['merk']);
                $type = filterInput($_POST['type']);
                $color = filterInput($_POST['color']);
                $stock = filterInput($_POST['stock']);
                $location = filterInput($_POST['location']);
                $rackCode = filterInput($_POST['rack-code']);
                $rackNum = filterInput($_POST['rack-num']);

                //Get File Upload
                $f1 = $_FILES['f1']['tmp_name'];
                $f1_name = $_FILES['f1']['name'];
                $f1_type = $_FILES['f1']['type'];
                $f1_size = $_FILES['f1']['size'];
                $format = pathinfo($f1_name, PATHINFO_EXTENSION);

                //Validasi Extensi
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $allowed_mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
    
                //Ambil MIME Type asli menggunakan finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $f1);
                finfo_close($finfo);
    
                //Cek Extensi dan MIME Type
                if (in_array($format, $allowed_extensions) && in_array($mime_type, $allowed_mime_types)) { 
                            
                    if($f1_size <= 1000000){
                        $enkrips = hash('sha256', date('YmdHis'));
                        $fileName = $enkrips.".".$format;
                            
                        //Upload
                        move_uploaded_file($f1,'../../uploads/safety-glasses/'.$fileName);
                                
                        
                        $saveData->saveDataSafetyGlasses(strtoupper($merk), $type, $color, $stock, $location, $rackCode, $rackNum, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data berhasil tersimpan";

                        header('location:'.BASEURL.'/add-apd-safety-glasses');
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Ukuran foto tidak valid !";

                        header('location:'.BASEURL.'/add-apd-safety-glasses');
    
                    }
                }

                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Format foto tidak valid !";
    
                    header('location:'.BASEURL.'/add-apd-safety-glasses');
    
                }
            }  
        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-glasses');
        }
    }

    //Update Data Safety Glasses
    elseif($_GET['action'] == "save-update-data-safety-glasses"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filterInput($_GET['id']);
            $merk = filterInput($_POST['merk']);
            $type = filterInput($_POST['type']);
            $color = filterInput($_POST['color']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            
            //Cek Required Form
            if(empty($merk) || empty($type) || empty($color) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-apd-safety-glasses'.'/'.$id);
            }
            else {

                $updateData->saveUpdateDataSafetyGlasses($id, strtoupper($merk), $type, $color, $stock, $location, $rackCode, $rackNum, $_SESSION['id_user'], $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";

                header('location:'.BASEURL.'/edit-apd-safety-glasses'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-glasses');
        }
    }

    //Save New Data Safety Gloves
    elseif($_GET['action'] == "save-data-new-safety-gloves"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $merk = filterInput($_POST['merk']);
            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            
            //Get File Upload
            $f1 = $_FILES['f1']['tmp_name'];
            $f1_name = $_FILES['f1']['name'];
            $f1_type = $_FILES['f1']['type'];
            $f1_size = $_FILES['f1']['size'];
            $format = pathinfo($f1_name, PATHINFO_EXTENSION);

            //Cek Required Form
            if(empty($merk) || empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/add-apd-safety-gloves');
            }
            else {
                $fileName = ($f1 != null) ? date('YmdHis').'.'.$format : "-";

                if($fileName != "-"){
                    move_uploaded_file($f1,'../uploads/safety-gloves/'.$fileName);
                }

                $saveData->saveDataSafetyGloves(strtoupper($merk), $type, $stock, $location, $rackCode, $rackNum, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been saved";

                header('location:'.BASEURL.'/add-apd-safety-gloves');
            }
        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-gloves');
        }
    }

    //Update Data Safety Gloves
    elseif($_GET['action'] == "save-update-data-safety-gloves"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filterInput($_GET['id']);
            $merk = filterInput($_POST['merk']);
            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            
            //Cek Required Form
            if(empty($merk) || empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-apd-safety-gloves'.'/'.$id);
            }
            else {

                $updateData->saveUpdateDataSafetyGloves($id, strtoupper($merk), $type, $stock, $location, $rackCode, $rackNum, $_SESSION['id_user'], $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";

                header('location:'.BASEURL.'/edit-apd-safety-gloves'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-safety-gloves');
        }
    }

    //Save New Data Souvenir
    elseif($_GET['action'] == "save-data-new-souvenir"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            
            //Get File Upload
            $f1 = $_FILES['f1']['tmp_name'];
            $f1_name = $_FILES['f1']['name'];
            $f1_type = $_FILES['f1']['type'];
            $f1_size = $_FILES['f1']['size'];
            $format = pathinfo($f1_name, PATHINFO_EXTENSION);

            //Cek Required Form
            if(empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/add-apd-souvenir');
            }
            else {
                $fileName = ($f1 != null) ? date('YmdHis').'.'.$format : "-";

                if($fileName != "-"){
                    move_uploaded_file($f1,'../uploads/souvenir/'.$fileName);
                }

                $saveData->saveDataSouvenir($type, $stock, $location, $rackCode, $rackNum, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been saved";

                header('location:'.BASEURL.'/add-apd-souvenir');
            }
        }
        else {
            header('location:'.BASEURL.'/list-apd-souvenir');
        }
    }

    //Update Data Souvenir
    elseif($_GET['action'] == "save-update-data-souvenir"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filterInput($_GET['id']);
            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            
            //Cek Required Form
            if(empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-apd-souvenir'.'/'.$id);
            }
            else {

                $updateData->saveUpdateDataSouvenir($id, $type, $stock, $location, $rackCode, $rackNum, $_SESSION['id_user'], $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";

                header('location:'.BASEURL.'/edit-apd-souvenir'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-souvenir');
        }
    }

    //Save New Data Other APD
    elseif($_GET['action'] == "save-data-new-other-apd"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            $expired = filterInput($_POST['expired']);
        
            //Get File Upload
            $f1 = $_FILES['f1']['tmp_name'];
            $f1_name = $_FILES['f1']['name'];
            $f1_type = $_FILES['f1']['type'];
            $f1_size = $_FILES['f1']['size'];
            $format = pathinfo($f1_name, PATHINFO_EXTENSION);

            //Cek Required Form
            if(empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/add-apd-other');
            }
            else {
                $fileName = ($f1 != null) ? date('YmdHis').'.'.$format : "-";

                if($fileName != "-"){
                    move_uploaded_file($f1,'../uploads/other/'.$fileName);
                }

                if(!empty($expired)){
                    $saveData->saveDataOther($type, $stock, $location, $rackCode, $rackNum, $expired, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                }
                else {
                    $saveData->saveDataOtherNE($type, $stock, $location, $rackCode, $rackNum, $fileName, $_SESSION['id_user'], $createdAt, $updatedAt);
                }
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been saved";

                header('location:'.BASEURL.'/add-apd-other');
            }
        }
        else {
            header('location:'.BASEURL.'/list-apd-other');
        }
    }

    //Update Data Other APD
    elseif($_GET['action'] == "save-update-data-other-apd"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filterInput($_GET['id']);
            $type = filterInput($_POST['type']);
            $stock = filterInput($_POST['stock']);
            $location = filterInput($_POST['location']);
            $rackCode = filterInput($_POST['rack-code']);
            $rackNum = filterInput($_POST['rack-num']);
            $expired = filterInput($_POST['expired']);

            //Cek Required Form
            if(empty($type) || empty($location) || empty($rackCode) || empty($rackNum) || empty($stock)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-apd-other'.'/'.$id);
            }
            else {

                if(!empty($expired)){
                    $updateData->saveUpdateDataOther($id, $type, $stock, $location, $rackCode, $rackNum, $expired, $_SESSION['id_user'], $updatedAt);
                }
                else {
                    $updateData->saveUpdateDataOtherNE($id, $type, $stock, $location, $rackCode, $rackNum, $_SESSION['id_user'], $updatedAt);
                }
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data barang (APD). Jenis : '.$type, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";

                header('location:'.BASEURL.'/edit-apd-other'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-apd-other');
        }
    }

    //Save Data Status
    elseif($_GET['action'] == 'save-data-status-'.$category){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filterInput($_POST[$category]);
            $qty = filterInput($_POST['qty']);
            $status = filterInput($_POST['status']);
            $information = filterInput($_POST['information']);
            $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $id);
            $stock;

            //Cek Required Form
            if(empty($id) || empty($qty) || empty($status)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/add-status-'.$category);
            }
            else {
                
                if($status == "Restocked"){
                    $stock = $detailAPD['_stok'] + $qty;

                    $saveData->saveDataStatus('_tb_status_'.$tabel, '_id_'.$tabel, $id, $qty, $_SESSION['id_user'], $_SESSION['id_user'], $status, $information, $createdAt, $updatedAt);
                    $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $id);
                    $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data status barang (APD)', $createdAt);

                    $_SESSION['status'] = "success";
                    $_SESSION['msg'] = "Data has been saved";

                    header('location:'.BASEURL.'/add-status-'.$category);
                }
                else {
                    if($qty <= $detailAPD['_stok']){
                        $stock = $detailAPD['_stok'] - $qty;

                        $saveData->saveDataStatus('_tb_status_'.$tabel, '_id_'.$tabel, $id, $qty, $_SESSION['id_user'], $_SESSION['id_user'], $status, $information, $createdAt, $updatedAt);
                        $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $id);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Menambah data status barang (APD)', $createdAt);

                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data has been saved";

                        header('location:'.BASEURL.'/add-status-'.$category);
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Stock is not enough !";

                        header('location:'.BASEURL.'/add-status-'.$category);
                    }
                }

                
            }
        }
        else {
            header('location:'.BASEURL.'/status-apd-'.$category);
        }
    }

    //Update Data Status
    elseif($_GET['action'] == 'update-data-status-'.$category){

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $idStatus = filterInput($_GET['id']);
            $detailStatus = $getData->getDataFr('_tb_status_'.$tabel, '_id', $idStatus);
            $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $detailStatus['_id_'.$tabel]);
            $id = $detailAPD['_id'];
            $qty = filterInput($_POST['qty']);
            $status = filterInput($_POST['status']);
            $information = filterInput($_POST['information']);
            $stockSementara;
            $stock;
    
            //Cek Required Form
            if(empty($id) || empty($qty) || empty($status)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";
    
                header('location:'.BASEURL.'/edit-status-'.$category.'/'.$idStatus);
            }
            else {
                    
                if($status == "Restocked"){
                    //Mengembalikan Ke Stock Semula
                    if($detailAPD['_stok'] >= $detailStatus['_jumlah']){
                        $stockSementara = $detailAPD['_stok'] - $detailStatus['_jumlah'];
                    }
                    else {
                        $stockSementara = $detailStatus['_jumlah'] - $detailAPD['_stok'];
                    }
                    $stock = $stockSementara + $qty;
                        
                    $updateData->updateStatusAPD('_tb_status_'.$tabel, $qty, $_SESSION['id_user'], $_SESSION['id_user'], $status, $information, $updatedAt, $idStatus);
                    $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $id);
                    $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data status barang (APD)', $createdAt);
    
                    $_SESSION['status'] = "success";
                    $_SESSION['msg'] = "Data has been updated";
    
                    header('location:'.BASEURL.'/edit-status-'.$category.'/'.$idStatus);
                }
                else {
                    //Mengembalikan Ke Stock Semula
                    $stockSementara = $detailAPD['_stok'] + $detailStatus['_jumlah'];
    
                    if($qty <= $stockSementara){
                        $stock = $stockSementara - $qty;
    
                        $updateData->updateStatusAPD('_tb_status_'.$tabel, $qty, $_SESSION['id_user'], $_SESSION['id_user'], $status, $information, $updatedAt, $idStatus);
                        $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $id);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data status barang (APD)', $createdAt);
    
                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data has been updated";
    
                        header('location:'.BASEURL.'/edit-status-'.$category.'/'.$idStatus);
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Stock is not enough !";
    
                        header('location:'.BASEURL.'/edit-status-'.$category.'/'.$idStatus);
                    }
                }
    
                    
            }
        }
        else {
            header('location:'.BASEURL.'/status-apd-'.$category);
        }
    }

    //Save Data User From Admin
    elseif($_GET['action'] == "save-data-new-user"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $fullName = filterInput($_POST['name']);
            $email = filterInput($_POST['email']);
            $userName = filterInput($_POST['username']);
            $password = md5($_POST['password']);
            $levelUser = filterInput($_POST['level']);

            if(empty($fullName) || empty($email) || empty($userName) || empty($password) || empty($levelUser)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/add-user');
            }
            else {
                if(!preg_match("/^[a-zA-Z-' ]*$/", $fullName)) {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Fullname only letters and white space allowed !";

                    header('location:'.BASEURL.'/add-user');
                }
                elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Invalid email format !";

                    header('location:'.BASEURL.'/add-user');
                }
                
                $saveData->saveDataUser($fullName, $email, $userName, $password, $levelUser, 'Approved', $createdAt, $updatedAt);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menambahkan user baru. Nama user : '.$fullName, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been saved";
    
                header('location:'.BASEURL.'/add-user');
            }

        }
        else {
            header('location:'.BASEURL.'/list-user');
        }
    }

    //Save Update Data User From Admin
    elseif($_GET['action'] == "save-update-data-user"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = filterInput($_GET['id']);
            $fullName = filterInput($_POST['name']);
            $email = filterInput($_POST['email']);
            $userName = filterInput($_POST['username']);
            $levelUser = filterInput($_POST['level']);
            $statusUser = filterInput($_POST['status']);

            if(empty($fullName) || empty($email) || empty($userName) || empty($levelUser)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-user'.'/'.$id);
            }
            else {
                if(!preg_match("/^[a-zA-Z-' ]*$/", $fullName)) {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Fullname only letters and white space allowed !";

                    header('location:'.BASEURL.'/edit-user'.'/'.$id);
                }
                elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Invalid email format !";

                    header('location:'.BASEURL.'/edit-user'.'/'.$id);
                }
                
                $updateData->updateDataUser($fullName, $email, $userName, $levelUser, $statusUser, $updatedAt, $id);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui data user. User : '.$fullName, $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";
    
                header('location:'.BASEURL.'/edit-user'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-user');
        }
    }

    //Save Update Password User From Admin
    elseif($_GET['action'] == "save-update-password-user"){

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = filterInput($_GET['id']);
            $password = md5($_POST['newpassword']);
           
            if(empty($password)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Form is required !";

                header('location:'.BASEURL.'/edit-password-user'.'/'.$id);
            }
            else {
             
                $updateData->updatePassUser($password, $updatedAt, $id);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui password user', $createdAt);

                $_SESSION['status'] = "success";
                $_SESSION['msg'] = "Data has been updated";
    
                header('location:'.BASEURL.'/edit-password-user'.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/list-user');
        }
    }

    //Approved Borrowing
    elseif($_GET['action'] == 'approved-status-borrowing-'.$category){
        $id = filterInput($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_borrow_'.$tabel, '_id', $id);
        $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $detailStatus['_id_'.$tabel]);

        if($detailStatus['_status'] == "Pending"){
            if($detailAPD['_stok'] >= $detailStatus['_jumlah']){
                $stock = $detailAPD['_stok'] - $detailStatus['_jumlah'];
        
                $saveData->saveDataStatus('_tb_status_'.$tabel, '_id_'.$tabel, $detailAPD['_id'], $detailStatus['_jumlah'], $_SESSION['id_user'], $detailStatus['_id_user'], 'Borrowed', $detailStatus['_keperluan'], $createdAt, $updatedAt);
                $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $detailAPD['_id']);
                $updateData->updateStatusRequest('_tb_borrow_'.$tabel, '_status', 'Approved', $updatedAt, $id);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menyetujui (Approved) Peminjaman Barang (APD)', $createdAt);
        
                header('location:'.BASEURL.'/detail-borrowing-'.$category.'/'.$id);
            }
            else {
                header('location:'.BASEURL.'/borrowing-apd-'.$category);
            }
        }
        else {
            
            header('location:'.BASEURL.'/detail-borrowing-'.$category.'/'.$id);
        }
    }

    //Rejected Borrowing
    elseif($_GET['action'] == 'rejected-status-borrowing-'.$category){
        $id = filterInput($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_borrow_'.$tabel, '_id', $id);
        
        if($detailStatus['_status'] == "Pending"){
            $updateData->updateStatusRequest('_tb_borrow_'.$tabel, '_status', 'Rejected', $updatedAt, $id);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Menolak (Rejected) Peminjaman Barang (APD)', $createdAt);
        
            header('location:'.BASEURL.'/detail-borrowing-'.$category.'/'.$id);
        }
        else {
            
            header('location:'.BASEURL.'/detail-borrowing-'.$category.'/'.$id);
        }
    }

    //Approved Request
    elseif($_GET['action'] == 'approved-status-request-'.$category){
        $id = filterInput($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_request_'.$tabel, '_id', $id);
        $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $detailStatus['_id_'.$tabel]);

        if($detailStatus['_status'] == "Pending"){
            if($detailAPD['_stok'] >= $detailStatus['_jumlah']){

                $stock = $detailAPD['_stok'] - $detailStatus['_jumlah'];
        
                $saveData->saveDataStatus('_tb_status_'.$tabel, '_id_'.$tabel, $detailAPD['_id'], $detailStatus['_jumlah'], $_SESSION['id_user'], $detailStatus['_id_user'], 'Issued', $detailStatus['_keterangan'], $createdAt, $updatedAt);
                $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $detailAPD['_id']);
                $updateData->updateStatusRequest('_tb_request_'.$tabel, '_status', 'Approved', $updatedAt, $id);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menyetujui (Approved) Permintaan Barang (APD)', $createdAt);
        
                header('location:'.BASEURL.'/detail-request-'.$category.'/'.$id);
            }
            else {
                header('location:'.BASEURL.'/request-apd-'.$category);
            }
        }
        else {
           
            header('location:'.BASEURL.'/detail-request-'.$category.'/'.$id);
        }
    }

    //Rejected Request
    elseif($_GET['action'] == 'rejected-status-request-'.$category){
        $id = filterInput($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_request_'.$tabel, '_id', $id);
        
        if($detailStatus['_status'] == "Pending"){
            $updateData->updateStatusRequest('_tb_request_'.$tabel, '_status', 'Rejected', $updatedAt, $id);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Menolak (Rejected) Permintaan Barang (APD)', $createdAt);
        
            header('location:'.BASEURL.'/detail-request-'.$category.'/'.$id);
        }
        else {
            
            header('location:'.BASEURL.'/detail-request-'.$category.'/'.$id);
        }
    }

    //Returnd Borrowing APD
    elseif($_GET['action'] == 'returned-borrowing-apd-'.$category){
        $id = filterInput($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_borrow_'.$tabel, '_id', $id);
        $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $detailStatus['_id_'.$tabel]);

        if($detailStatus['_status'] == "Approved"){
            $stock = $detailAPD['_stok'] + $detailStatus['_jumlah'];

            $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $detailAPD['_id']);
            $deleteData->softDeleteData('_tb_status_'.$tabel, '_updated_at', $detailStatus['_updated_at'], $updatedAt);
            $updateData->updateStatusRequest('_tb_borrow_'.$tabel, '_status_pengembalian', 'True', $updatedAt, $id);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Mengembalikan peminjaman Barang (APD)', $createdAt);
        
            header('location:'.BASEURL.'/borrowing-apd-'.$category);
        }
        else {
            
            header('location:'.BASEURL.'/borrowing-apd-'.$category);
        }
    }

    //Update Password Admin
    elseif($_GET['action'] == 'admin-save-update-password'){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = addslashes($_GET['id']);
            $oldPassword = md5($_POST['oldpassword']);

            //Get Old Password
            $detailUser = $getData->getDataFr('_tb_user_login', '_id', $_SESSION['id_user']);

            if($oldPassword == $detailUser['_password']){
                $newPassword = md5($_POST['newpassword']);
                $confirmPass = md5($_POST['confirmpassword']);

                if($newPassword == $confirmPass){
                    $updateData->updatePassUser($newPassword, $updatedAt, $id);
                    $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui password admin', $createdAt);

                    $_SESSION['status'] = "success";
                    $_SESSION['msg'] = "Data has been updated";

                    header('location:'.BASEURL.'/password');
                }
                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Password does not match !";

                    header('location:'.BASEURL.'/password');
                }
            }
            else {
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Old password incorrect !";

                header('location:'.BASEURL.'/password');
            }

        }
        else {
            header('location:'.BASEURL.'/dashboard-administrator');
        }
    }

    


    