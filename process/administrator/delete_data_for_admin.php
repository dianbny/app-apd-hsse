<?php
    error_reporting(0);

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
    if($_GET['action'] == 'delete-data-'.$category){

        $id = addslashes($_GET['id']);

        $deleteData->softDeleteData('_tb_'.$tabel, '_id', $id, $deletedAt);
        
        if($cekData->cekDataFr('_tb_status_'.$tabel, '_id_'.$tabel, $id) > 0){
                $deleteData->softDeleteData('_tb_status_'.$tabel, '_id_'.$tabel, $id, $deletedAt);
        }

        if($cekData->cekTableName('_tb_borrow_'.$tabel) > 0){
            if($cekData->cekDataFr('_tb_borrow_'.$tabel, '_id_'.$tabel, $id) > 0){
                $deleteData->softDeleteData('_tb_borrow_'.$tabel, '_id_'.$tabel, $id, $deletedAt);
            }
        }

        if($cekData->cekTableName('_tb_request_'.$tabel) > 0){
            if($cekData->cekDataFr('_tb_request_'.$tabel, '_id_'.$tabel, $id) > 0){
                $deleteData->softDeleteData('_tb_request_'.$tabel, '_id_'.$tabel, $id, $deletedAt);
            }
        }

        header('location:'.BASEURL.'/list-apd-'.$category);

    }

    elseif($_GET['action'] == 'delete-status-'.$category){

        $id = addslashes($_GET['id']);
        $detailStatus = $getData->getDataFr('_tb_status_'.$tabel, '_id', $id);
        $detailAPD = $getData->getDataFr('_tb_'.$tabel, '_id', $detailStatus['_id_'.$tabel]);
        $idAPD = $detailAPD['_id'];
        $stock;

        if($detailStatus['_status'] == "Restocked"){
            if($detailStatus['_jumlah'] >= $detailAPD['_stok']){
                header('location:'.BASEURL.'/status-apd-'.$category);
            }
            else {
                $stock = $detailAPD['_stok'] - $detailStatus['_jumlah'];

                $deleteData->softDeleteData('_tb_status_'.$tabel, '_id', $id, $deletedAt);
                $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $idAPD);
                $saveData->saveDataActivity($_SESSION['id_user'], 'Menghapus data status barang (APD)', $createdAt);

                header('location:'.BASEURL.'/status-apd-'.$category);
            }
        }
        else {
            $stock = $detailStatus['_jumlah'] + $detailAPD['_stok'];

            $deleteData->softDeleteData('_tb_status_'.$tabel, '_id', $id, $deletedAt);
            $updateData->updateStockAPD('_tb_'.$tabel, $stock, $_SESSION['id_user'], $updatedAt, $idAPD);
            $saveData->saveDataActivity($_SESSION['id_user'], 'Menghapus data status barang (APD)', $createdAt);

            header('location:'.BASEURL.'/status-apd-'.$category);
        }

        

    }

    elseif($_GET['action'] == 'delete-user'){

        $id = addslashes($_GET['id']);

        $deleteData->softDeleteData('_tb_user_login', '_id', $id, $deletedAt);

        header('location:'.BASEURL.'/list-user');

    }


    

    

    

    

    