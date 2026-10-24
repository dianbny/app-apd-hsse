<?php
    error_reporting(0);

    session_start(); 

    require_once "../../config/const.php";

    if(!isset($_SESSION['status-login']) || $_SESSION['level'] != "user"){ 
        header('location:'.BASEURL.'/logout');
    }

    //Require
    require_once "../../config/cekData.php";
    require_once "../../config/getData.php";
    require_once "../../config/deleteData.php";
    require_once "../../config/saveData.php";
    require_once "../../config/updateData.php";
    
    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();
    $deleteData = new deleteData();
    $saveData = new saveData();
    $updateData = new updateData();
    
    //Waktu 
    date_default_timezone_set("Asia/Kuala_Lumpur");
    setlocale(LC_ALL, 'id-ID', 'id_ID');

    //Filter Data
    function filterInput($data){
        $data = trim($data);
        $data = strip_tags($data);
        $data = addslashes($data);
        return $data;
    }

    //Get Action
    $page = $_GET['action'];
    $sub = explode("-", $page);
    $category;  
    $tabel;

    if(count($sub) == 3){
        $category = $sub[2];
        $tabel = $sub[2];
    }
    elseif(count($sub) == 4) {
        $category = $sub[2].'-'.$sub[3];
        $tabel = $sub[2].'_'.$sub[3];
    }

    //Datetime
    $createdAt = filterInput(date('Y-m-d H:i:s'));
    $updatedAt = filterInput(date('Y-m-d H:i:s'));
    $deletedAt = filterInput(date('Y-m-d H:i:s'));

    //Soft Delete Data
    if($_GET['action'] == 'delete-borrowing-'.$category){

        $id = addslashes($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_borrow_'.$tabel, '_id', $id);

        if($detailStatus['_status'] == "Pending"){

            $deleteData->softDeleteData('_tb_borrow_'.$tabel, '_id', $id, $deletedAt);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Menghapus request peminjaman barang (APD)', $createdAt);
    
            header('location:'.BASEURL.'/user-borrowing-apd-'.$category);
        }
        else {
            header('location:'.BASEURL.'/user-borrowing-apd-'.$category);
        }

    }
    
    elseif($_GET['action'] == 'delete-request-'.$category){

        $id = addslashes($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_request_'.$tabel, '_id', $id);

        if($detailStatus['_status'] == "Pending"){

            $deleteData->softDeleteData('_tb_request_'.$tabel, '_id', $id, $deletedAt);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Menghapus request permintaan barang (APD)', $createdAt);
    
            header('location:'.BASEURL.'/user-request-apd-'.$category);
        }
        else {
            header('location:'.BASEURL.'/user-request-apd-'.$category);
        }

    }