<?php
    //error_reporting(0);

    session_start(); 

    require_once "../../config/const.php";

    if(!isset($_SESSION['status-login']) || $_SESSION['level'] != "user"){ 
        header('location:'.BASEURL.'/logout');
    }

    //Require
    require_once "../../config/cekData.php";
    require_once "../../config/getData.php";
    require_once "../../config/saveData.php";
    require_once "../../config/updateData.php";
    
    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();
    $saveData = new saveData();
    $updateData = new updateData();
    
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

    //Save Borrowing Coveralls
    if($_GET['action'] == 'save-data-borrowing-'.$category){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $id);
            $name = filterInput($_POST['name']);
            $position = filterInput($_POST['position']);
            $needs = filterInput($_POST['needs']);
            $borrowdate = filterInput($_POST['borrowing-date']);
            $returndate = filterInput($_POST['return-date']);
            $stock = filterInput($_POST['stock']);
            $qty = filterInput($_POST['qty']);
            
            //Cek Ketersediaan
            if($stock > 0 && $stock > $qty){

                //Cek Required Form
                if(empty($name) || empty($position) || empty($needs) || empty($borrowdate) || empty($returndate) || empty($qty)){
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Data wajib terisi !";
    
                    header('location:'.BASEURL.'/user-add-borrowing-'.$category.'/'.$id);
                }
                else {
                    
                    $saveData->saveBorrowingReq('_tb_borrow_'.$tabel, '_id_'.$tabel, $_SESSION['id_user'], $name, $position, $needs, $id, $qty, $borrowdate, $returndate,'Pending','False', $createdAt, $updatedAt);
                    $saveData->saveDataActivity($_SESSION['id_user'], 'Melakukan request peminjaman barang (APD). Jenis : '.$detailAPD['_jenis'], $createdAt);
    
                    $_SESSION['status'] = "success";
                    $_SESSION['msg'] = "Data berhasil tersimpan";
    
                    header('location:'.BASEURL.'/user-add-borrowing-'.$category.'/'.$id);
                }
            }
            else {
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Barang/material yang ingin dipinjam mencukupi !";
    
                header('location:'.BASEURL.'/user-add-borrowing-'.$category.'/'.$id);
            }

        }
        else {
            header('location:'.BASEURL.'/user-borrowing-apd'.$category);
        }
    }

    //Save Request Coveralls
    elseif($_GET['action'] == 'save-data-request-'.$category){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = addslashes($_GET['id']);
            $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $id);
            $name = filterInput($_POST['name']);
            $position = filterInput($_POST['position']);
            $reason = filterInput($_POST['reason']);
            $qty = filterInput($_POST['qty']);
            
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

            //Cek Required Form
            if(empty($name) || empty($position) || empty($reason) || empty($qty)){
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Data wajib terisi !";

                header('location:'.BASEURL.'/user-add-request-'.$category.'/'.$id);
            }
            else {

                //Cek Extensi dan MIME Type
                if (in_array($format, $allowed_extensions) && in_array($mime_type, $allowed_mime_types)) {

                    if($f1_size <= 1000000){
                        $enkrips = hash('sha256', date('YmdHis'));
                        $fileName = $enkrips.".".$format;

                        //Upload
                        move_uploaded_file($f1,'../../uploads/request/'.$fileName);

                        $saveData->saveRequest('_tb_request_'.$tabel, '_id_'.$tabel, $_SESSION['id_user'], $name, $position, $reason, $id, $qty, 'Pending', $fileName, $createdAt, $updatedAt);
                        $saveData->saveDataActivity($_SESSION['id_user'], 'Melakukan request permintaan barang (APD). Jenis : '.$detailAPD['_jenis'], $createdAt);

                        $_SESSION['status'] = "success";
                        $_SESSION['msg'] = "Data berhasil tersimpan";

                        header('location:'.BASEURL.'/user-add-request-'.$category.'/'.$id);
                    }
                    else {
                        $_SESSION['status'] = "error";
                        $_SESSION['msg'] = "Ukuran foto tidak sesuai !";

                        header('location:'.BASEURL.'/user-add-request-'.$category.'/'.$id);
                    }
                }
                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Format foto tidak sesuai !";

                    header('location:'.BASEURL.'/user-add-request-'.$category.'/'.$id);
                }
                
            }

        }
        else {
            header('location:'.BASEURL.'/user-request-apd'.$category);
        }
    }

    //Update Password User
    elseif($_GET['action'] == 'user-save-update-password'){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id = addslashes($_GET['id']);
            $oldPassword = md5($_POST['oldpassword']);

            //Get Old Password
            $detailUser = $getData->getDataFr('_tb_user_login', '_id', $_SESSION['id_user']);

            if($oldPassword == $detailUser['_password']){
                $newPassword = hash('sha256', $_POST['newpassword']);
                $confirmPass = hash('sha256', $_POST['confirmpassword']);

                if($newPassword == $confirmPass){
                    $updateData->updatePassUser($newPassword, $updatedAt, $id);
                    $saveData->saveDataActivity($_SESSION['id_user'], 'Memperbarui password user', $createdAt);

                    $_SESSION['status'] = "success";
                    $_SESSION['msg'] = "Data berhasil diperbarui";

                    header('location:'.BASEURL.'/password-user');
                }
                else {
                    $_SESSION['status'] = "error";
                    $_SESSION['msg'] = "Password tidak cocok !";

                    header('location:'.BASEURL.'/password-user');
                }
            }
            else {
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Password lama salah !";

                header('location:'.BASEURL.'/password-user');
            }

        }
        else {
            header('location:'.BASEURL.'/dashboard-user');
        }
    }