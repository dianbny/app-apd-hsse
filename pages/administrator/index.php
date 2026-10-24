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

    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();

    //Filter Data
    function filterInput($data){
        $data = trim($data);
        $data = strip_tags($data);
        $data = addslashes($data);
        return $data;
    }
    
    //Get Data User
    $dataUserLogin = $getData->getDataFr('_tb_user_login', '_username', $_SESSION['username']);
    $_SESSION['id_user'] = $dataUserLogin['_id'];

    //Waktu 
    date_default_timezone_set("Asia/Kuala_Lumpur");
    setlocale(LC_ALL, 'id-ID', 'id_ID');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style_page.css">
    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/assets/vendors/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>HSSE Bunyu Field</title>
</head>
<body>
    <!-- Loading Animation -->
    <div id="load"></div>

    <!-- Header -->
    <header>
        <span style="font-size:26px;cursor:pointer;color:black;" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <img src="<?= BASEURL; ?>/assets/img/pertamina.png">
        <span class="title-logo">PERTAMINA <span style="color:red;">EP</span></span>
        <div class="right">
            <span><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp; <?= $dataUserLogin['_nama']; ?></span>
            <a href="<?= BASEURL; ?>/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a>
        </div>
    </header>

    <div id="mySidenav" class="sidenav">
        <button class="closebtn" onclick="closeNav()"><i class="fa fa-times-circle" aria-hidden="true"></i></button>

        <a href="<?= BASEURL; ?>/dashboard-administrator"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp; Dashboard</a>
        <a href="javascript:void(0)" id="first"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; Daftar APD - Material</a>
            <div class="menu-first">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAll('_tb_category_apd','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/list-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="javascript:void(0)" id="second"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Peminjaman</a>
            <div class="menu-second">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/borrowing-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="javascript:void(0)" id="third"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Permintaan</a>
            <div class="menu-third">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/request-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="javascript:void(0)" id="fourth"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp; Status Material - APD</a>
            <div class="menu-fourth">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAll('_tb_category_apd','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/status-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="<?= BASEURL; ?>/list-user"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Daftar Pengguna</a>
        <a href="<?= BASEURL; ?>/list-activity"><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp; Daftar Aktivitas</a>
        <a href="<?= BASEURL; ?>/password"><i class="fa fa-key" aria-hidden="true"></i>&nbsp; Pengaturan Sandi</a>

    </div>

    <div class="jumbotron"></div>
    
    <div class="container">

    <?php

        $page = addslashes($_GET['page']);

        $sub = explode("-" , $page);

        $category = ""; 
        $file = "";

        if(count($sub) == 2){
            $category = $sub[1];
            $file = $sub[1];
        }
        elseif(count($sub) == 3) {
            $category = $sub[2];
            $file = $sub[2];
        }
        elseif(count($sub) == 4) {
            $category = $sub[2].'-'.$sub[3];
            $file = $sub[2].'_'.$sub[3];
        }

        switch($page){
            case 'list-apd-'.$category:

                include 'list-apd/list/list_apd_'.$file.'.php';

                break;

            case 'add-apd-'.$category:

                include 'list-apd/add/add_apd_'.$file.'.php';
    
                break;

            case 'detail-apd-'.$category:

                include 'list-apd/detail/detail_apd_'.$file.'.php';
        
                break;

            case 'edit-apd-'.$category:

                include 'list-apd/edit/edit_apd_'.$file.'.php';
            
                break;

            case 'borrowing-apd-'.$category:

                include 'borrowing-apd/list/borrowing_apd_'.$file.'.php';
                    
                break;

            case 'detail-borrowing-'.$category:

                include 'borrowing-apd/detail/detail_borrow_'.$file.'.php';
                        
                break;

            case 'request-apd-'.$category:

                include 'request-apd/list/request_apd_'.$file.'.php';
                
                break;

            case 'detail-request-'.$category:

                include 'request-apd/detail/detail_request_'.$file.'.php';
                    
                break;


                







            case 'status-apd-'.$category:

                include 'status-apd/list/status_apd_'.$file.'.php';
                    
                break;

            case 'add-status-'.$category:

                include 'status-apd/add/status_apd_'.$file.'.php';
                        
                break;

            case 'detail-status-'.$category:

                include 'status-apd/detail/status_apd_'.$file.'.php';
                            
                break;

            case 'edit-status-'.$category:

                include 'status-apd/edit/status_apd_'.$file.'.php';
                                
                break;

            case 'list-user':

                include 'users/list-user/list_user.php';
                                    
                break;

            case 'add-user':

                include 'users/add/add_user.php';
                                        
                break;

            case 'edit-user':

                include 'users/edit/edit_user.php';
                                            
                break;

            case 'edit-password-user':

                include 'users/edit/edit_password_user.php';
                                                
                break;

            case 'list-activity':

                include 'activity/list_activity.php';
                                                    
                break;

            case 'password':

                include 'password/password.php';
                                                        
                break;



            case "dashboard-administrator" : ?>
                <div class="title-page">
                    <img src="<?= BASEURL; ?>/assets/img/dashboard.png" alt="">Dashboard
                </div>

                <div class="category">
                    
                    <div class="bottom">
                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/coveralls.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Coveralls</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_coveralls') > 0){
                                                $totalCoveralls = $getData->getSumData('_tb_coveralls');
                                                echo $totalCoveralls['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_coveralls') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_coveralls', '_status', 'Restocked') > 0){
                                                    $brCoveralls = $getData->getSumDataFr('_tb_status_coveralls', '_status', 'Borrowed');
                                                    $isCoveralls = $getData->getSumDataFr('_tb_status_coveralls', '_status', 'Issued');
                                                    
                                                    echo $brCoveralls['jumlah'] + $isCoveralls['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-coveralls" class="btnLd">Lihat</a>
                            </div>
                        </div>
            
                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/shoes.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Safety Shoes</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_safety_shoes') > 0){
                                                $totalSafetyShoes = $getData->getSumData('_tb_safety_shoes');
                                                echo $totalSafetyShoes['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_safety_shoes') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_safety_shoes', '_status', 'Restocked') > 0){
                                                    $brSafetyShoes = $getData->getSumDataFr('_tb_status_safety_shoes', '_status', 'Borrowed');
                                                    $isSafetyShoes = $getData->getSumDataFr('_tb_status_safety_shoes', '_status', 'Issued');
                                                    
                                                    echo $brSafetyShoes['jumlah'] + $isSafetyShoes['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-safety-shoes" class="btnLd">Lihat</a>
                            </div>
                        </div>
            
                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/safety-helmet.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Safety Helmet</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_safety_helmet') > 0){
                                                $totalSafetyHelmet = $getData->getSumData('_tb_safety_helmet');
                                                echo $totalSafetyHelmet['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_safety_helmet') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_safety_helmet', '_status', 'Restocked') > 0){
                                                    $brSafetyHelmet = $getData->getSumDataFr('_tb_status_safety_helmet', '_status', 'Borrowed');
                                                    $isSafetyHelmet = $getData->getSumDataFr('_tb_status_safety_helmet', '_status', 'Issued');
                                                    
                                                    echo $brSafetyHelmet['jumlah'] + $isSafetyHelmet['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-safety-helmet" class="btnLd">Lihat</a>
                            </div>
                        </div>
            
                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/safety-goggles.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Safety Glasses</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_safety_glasses') > 0){
                                                $totalSafetyGlasses = $getData->getSumData('_tb_safety_glasses');
                                                echo $totalSafetyGlasses['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_safety_glasses') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_safety_glasses', '_status', 'Restocked') > 0){
                                                    $brSafetyGlasses = $getData->getSumDataFr('_tb_status_safety_glasses', '_status', 'Borrowed');
                                                    $isSafetyGlasses = $getData->getSumDataFr('_tb_status_safety_glasses', '_status', 'Issued');
                                                    
                                                    echo $brSafetyGlasses['jumlah'] + $isSafetyGlasses['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-safety-glasses" class="btnLd">Lihat</a>
                            </div>
                        </div>
            
                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/gloves.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Safety Gloves</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_safety_gloves') > 0){
                                                $totalSafetyGloves = $getData->getSumData('_tb_safety_gloves');
                                                echo $totalSafetyGloves['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_safety_gloves') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_safety_gloves', '_status', 'Restocked') > 0){
                                                    $brSafetyGloves = $getData->getSumDataFr('_tb_status_safety_gloves', '_status', 'Borrowed');
                                                    $isSafetyGloves = $getData->getSumDataFr('_tb_status_safety_gloves', '_status', 'Issued');
                                                    
                                                    echo $brSafetyGloves['jumlah'] + $isSafetyGloves['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-safety-gloves" class="btnLd">Lihat</a>
                            </div>
                        </div>

                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/souvenir.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Souvenir</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_souvenir') > 0){
                                                $totalSouvenir = $getData->getSumData('_tb_souvenir');
                                                echo $totalSouvenir['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_souvenir') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_souvenir', '_status', 'Restocked') > 0){
                                                    $brSouvenir = $getData->getSumDataFr('_tb_status_souvenir', '_status', 'Borrowed');
                                                    $isSouvenir= $getData->getSumDataFr('_tb_status_souvenir', '_status', 'Issued');
                                                    
                                                    echo $brSouvenir['jumlah'] + $isSouvenir['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-souvenir" class="btnLd">Lihat</a>
                            </div>
                        </div>

                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/other.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Other</h6>
                                <div>
                                    Tersedia
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_other') > 0){
                                                $totalOther = $getData->getSumData('_tb_other');
                                                echo $totalOther['stok'];
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    Terpakai
                                    <div class="total">
                                        <?php
                                            if($cekData->cekDataAll('_tb_status_other') > 0){
                                                if($cekData->cekDataFrNE('_tb_status_other', '_status', 'Restocked') > 0){
                                                    $brOther = $getData->getSumDataFr('_tb_status_other', '_status', 'Borrowed');
                                                    $isOther = $getData->getSumDataFr('_tb_status_other', '_status', 'Issued');
                                                    
                                                    echo $brOther['jumlah'] + $isOther['jumlah'];
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            }
                                            else {
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
            
                                <a href="<?= BASEURL; ?>/list-apd-other" class="btnLd">Lihat</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel">
                    <div class="info-tabel">
                        
                        <!-- Request -->
                        <div>
                            <h5>Informasi</h5>
                            <div>
                                <table class="table-dashboard">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Pending (Tertunda)</th>
                                            <th>Approved (Disetujui)</th>
                                            <th>Jatuh Tempo</th>
                                            
                                        </tr>
                                        
                                    </thead>

                                    <tbody>
                                        <?php
                                            if($cekData->cekDataAll('_tb_category_apd') > 0){
                                                foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                                                    <tr>
                                                        <td rowspan="2"><?= $row['_category']; ?></td>
                                                        <td><b>Peminjaman</b></td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#FFA07A;">
                                                                <?php
                                                                    $brPending = $cekData->cekDataFr('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Pending');
                                                                    echo $brPending;

                                                                    if($brPending > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#90EE90;">
                                                                <?php
                                                                    $brApproved = $cekData->cekDataFr('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Approved');
                                                                    echo $brApproved;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#F08080;">
                                                                <?php
                                                                    $brDDate = $cekData->cekDataThLKS('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_tgl_pengembalian', date('Y-m-d'), '_status', 'Approved', '_status_pengembalian', 'False');
                                                                    echo $brDDate;

                                                                    if($brDDate > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Permintaan</b></td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#FFA07A;">
                                                                <?php
                                                                    $rqPending = $cekData->cekDataFr('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Pending');
                                                                    echo $rqPending;

                                                                    if($rqPending > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#90EE90;">
                                                                <?php
                                                                    $rqApproved = $cekData->cekDataFr('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Approved');
                                                                    echo $rqApproved;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>-</td>
                                                    </tr>
                                          <?php }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Section Request -->                    
                                            
                        <!-- Status -->
                        <div>
                            <h5>Status</h5>
                            <div>
                                <table class="table-dashboard">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th style="text-align:center;">Penambahan</th>
                                            <th style="text-align:center;">Terpinjam</th>
                                            <th style="text-align:center;">Keluar</th>
                                            <th style="text-align:center;">Rusak</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($cekData->cekDataAll('_tb_category_apd') > 0){
                                                foreach ($getData->getDataAll('_tb_category_apd','_id') as $row){ 
                                                $node = $getData->getDataByLimit('_tb_status_'.str_replace(' ','_', strtolower($row['_category']))); ?>
                                                <tr>
                                                    <td><?= $row['_category']; ?></td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#90EE90;">
                                                            <?php
                                                                if($cekData->cekDataFr('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Restocked') > 0){
                                                                    $restockR = $getData->getSumDataByYears('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Restocked', date('Y'));
                                                                    
                                                                    if($restockR['jumlah'] > 0){
                                                                        echo $restockR['jumlah'];
                                                                    }
                                                                    else {
                                                                        echo "0";
                                                                    }

                                                                    if($node['_status'] == "Restocked" && $restockR['jumlah'] > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                }
                                                                else {
                                                                    echo "0";
                                                                }
                                                                
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#FFA07A;">
                                                            <?php
                                                                if($cekData->cekDataFr('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Borrowed') > 0){
                                                                    $restockB = $getData->getSumDataByYears('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Borrowed', date('Y'));
                                                                    
                                                                    if($restockB['jumlah'] > 0){
                                                                        echo $restockB['jumlah'];
                                                                    }
                                                                    else {
                                                                        echo "0";
                                                                    }
                                                                    
                                                                    if($node['_status'] == "Borrowed" && $restockB['jumlah'] > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                }
                                                                else {
                                                                    echo "0";
                                                                }

                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#F08080;">
                                                            <?php
                                                                if($cekData->cekDataFr('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Issued') > 0){
                                                                    $restockI = $getData->getSumDataByYears('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Issued', date('Y'));
                                                                    
                                                                    if($restockI['jumlah'] > 0){
                                                                        echo $restockI['jumlah'];
                                                                    }
                                                                    else {
                                                                        echo "0";
                                                                    }

                                                                    if($node['_status'] == "Issued" && $restockI['jumlah'] > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                }
                                                                else {
                                                                    echo "0";
                                                                }

                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#C0C0C0;">
                                                            <?php
                                                                if($cekData->cekDataFr('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Damaged') > 0){
                                                                    $restockD = $getData->getSumDataByYears('_tb_status_'.str_replace(' ','_', strtolower($row['_category'])), '_status', 'Damaged', date('Y'));
                                                                    
                                                                    if($restockD['jumlah'] > 0){
                                                                        echo $restockD['jumlah'];
                                                                    }
                                                                    else {
                                                                        echo "0";
                                                                    }

                                                                    if($node['_status'] == "Damaged" && $restockD['jumlah'] > 0){ ?>
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                              <?php }
                                                                }
                                                                else {
                                                                    echo "0";
                                                                }

                                                            ?>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                         <?php  }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Section Status -->
                         
                    </div>

                    <div class="info-tabel">
                    
                        <!-- Expired -->
                        <div>
                            <h5>Kadaluarsa</h5>
                            <div>
                                <table class="table-dashboard">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Kadaluarsa Tahun Ini</th>
                                            <th>Telah Kadaluarsa</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                        
                                    </thead>

                                    <tbody>
                                        <?php
                                            if($cekData->cekDataAll('_tb_category_apd') > 0){
                                                foreach ($getData->getDataAll('_tb_category_apd','_id') as $row){ 
                                                $warn;
                                                $exp; ?>
                                                <tr>
                                                    <td><?= $row['_category']; ?></td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#FFA07A;">
                                                            <?php
                                                                if($cekData->cekFieldName('_tb_'.str_replace(' ','_', strtolower($row['_category'])), '_expired') > 0){
                                                                    $warning = $getData->getSumWarning('_tb_'.str_replace(' ','_', strtolower($row['_category'])), '_expired', date('Y'));
                                                                    
                                                                    if($warning['stok'] == 0){
                                                                        $warn = "0";
                                                                    }
                                                                    else {
                                                                        $warn = $warning['stok'];
                                                                    }
                                                                    echo $warn;
                                                                }
                                                                else {
                                                                    $warn = "0";
                                                                    echo "0";
                                                                }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#F08080;">
                                                            <?php
                                                                if($cekData->cekFieldName('_tb_'.str_replace(' ','_', strtolower($row['_category'])), '_expired') > 0){
                                                                    $expired = $getData->getSumExpired('_tb_'.str_replace(' ','_', strtolower($row['_category'])), '_expired', date('Y'));
                                                                    
                                                                    if($expired['stok'] == 0){
                                                                        $exp = "0";
                                                                    }
                                                                    else {
                                                                        $exp = $expired['stok'];
                                                                    }
                                                                    echo $exp;
                                                                }
                                                                else {
                                                                    $exp = "0";
                                                                    echo "0";
                                                                }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="status-dashboard" style="background-color:#C0C0C0;">
                                                            <?= $warn + $exp; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                    
                                                </tr>
                                         <?php  }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Section Expired -->
                        

                        <!-- Activity -->
                        <div>
                            <h5>Aktivitas Pengguna</h5>
                            <div>
                                <?php
                                    if($cekData->cekDataAllND('_tb_activity') > 0){ 
                                        foreach($getData->getDataAllNDDesc('_tb_activity', '_id') as $row){ ?>
                                            <div class="activity">
                                                <b>
                                                    <?php
                                                        $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                        echo $namaUser['_nama'];
                                                    ?>
                                                </b><br>
                                                <span style="display:block;margin-top:8px;margin-bottom:9px;"><?= $row['_activity']; ?></span>
                                                <span style="font-size:10px;font-weight:bold;"><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></span>
                                            </div>
                                  <?php }
                                    }
                                    else{ ?>
                                        <span style="display:block;font-size:12px;color:#FF0000;">Data not found !</span>
                              <?php } 
                                ?>
                                
                            </div>
                        </div>
                        <!-- End Section Activity -->

                    </div>

                    <div class="info-grafik">
                        <h5>Persentase</h5>
                        <div>

                            <!-- Coveralls -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/coveralls.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentCL = $getData->getSumData('_tb_coveralls');
                                        $topercentCB = $getData->getSumDataByYears('_tb_status_coveralls', '_status', 'Borrowed', date('Y'));
                                        $topercentCI = $getData->getSumDataByYears('_tb_status_coveralls', '_status', 'Issued', date('Y'));
                                        $topercentCD = $getData->getSumDataByYears('_tb_status_coveralls', '_status', 'Damaged', date('Y'));

                                        $sumtopercentCV = $topercentCL['stok'] + $topercentCB['jumlah'] + $topercentCI['jumlah'] + $topercentCD['jumlah'];
                                        $inUseCV = $topercentCB['jumlah'] + $topercentCI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentCV != 0) ? ceil($topercentCL['stok'] / $sumtopercentCV * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentCV != 0) ? substr($topercentCL['stok'] / $sumtopercentCV * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentCV != 0) ? ceil($inUseCV / $sumtopercentCV * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentCV != 0) ? substr($inUseCV / $sumtopercentCV * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentCV != 0) ? ceil($topercentCD['jumlah'] / $sumtopercentCV * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentCV != 0) ? substr($topercentCD['jumlah'] / $sumtopercentCV * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Coveralls -->

                            <!-- Safety Shoes -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/shoes.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentSHL = $getData->getSumData('_tb_safety_shoes');
                                        $topercentSHB = $getData->getSumDataByYears('_tb_status_safety_shoes', '_status', 'Borrowed', date('Y'));
                                        $topercentSHI = $getData->getSumDataByYears('_tb_status_safety_shoes', '_status', 'Issued', date('Y'));
                                        $topercentSHD = $getData->getSumDataByYears('_tb_status_safety_shoes', '_status', 'Damaged', date('Y'));

                                        $sumtopercentSH = $topercentSHL['stok'] + $topercentSHB['jumlah'] + $topercentSHI['jumlah'] + $topercentSHD['jumlah'];
                                        $inUseSH = $topercentSHB['jumlah'] + $topercentSHI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSH != 0) ? ceil($topercentSHL['stok'] / $sumtopercentSH * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentSH != 0) ? substr($topercentSHL['stok'] / $sumtopercentSH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSH != 0) ? ceil($inUseSH / $sumtopercentSH * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentSH != 0) ? substr($inUseSH / $sumtopercentSH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSH != 0) ? ceil($topercentSHD['jumlah'] / $sumtopercentSH * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentSH != 0) ? substr($topercentSHD['jumlah'] / $sumtopercentSH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Safety Shoes -->

                            <!-- Safety Helmet -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/safety-helmet.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentHL = $getData->getSumData('_tb_safety_helmet');
                                        $topercentHB = $getData->getSumDataByYears('_tb_status_safety_helmet', '_status', 'Borrowed', date('Y'));
                                        $topercentHI = $getData->getSumDataByYears('_tb_status_safety_helmet', '_status', 'Issued', date('Y'));
                                        $topercentHD = $getData->getSumDataByYears('_tb_status_safety_helmet', '_status', 'Damaged', date('Y'));

                                        $sumtopercentH = $topercentHL['stok'] + $topercentHB['jumlah'] + $topercentHI['jumlah'] + $topercentHD['jumlah'];
                                        $inUseH = $topercentHB['jumlah'] + $topercentHI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentH != 0) ? ceil($topercentHL['stok'] / $sumtopercentH * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentH != 0) ? substr($topercentHL['stok'] / $sumtopercentH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentH != 0) ? ceil($inUseH / $sumtopercentH * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentH != 0) ? substr($inUseH / $sumtopercentH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentH != 0) ? ceil($topercentHD['jumlah'] / $sumtopercentH * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentH != 0) ? substr($topercentHD['jumlah'] / $sumtopercentH * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Safety Helmet -->

                            <!-- Safety Glasses -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/safety-goggles.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentGL = $getData->getSumData('_tb_safety_glasses');
                                        $topercentGB = $getData->getSumDataByYears('_tb_status_safety_glasses', '_status', 'Borrowed', date('Y'));
                                        $topercentGI = $getData->getSumDataByYears('_tb_status_safety_glasses', '_status', 'Issued', date('Y'));
                                        $topercentGD = $getData->getSumDataByYears('_tb_status_safety_glasses', '_status', 'Damaged', date('Y'));

                                        $sumtopercentG = $topercentGL['stok'] + $topercentGB['jumlah'] + $topercentGI['jumlah'] + $topercentGD['jumlah'];
                                        $inUseG = $topercentGB['jumlah'] + $topercentGI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentG != 0) ? ceil($topercentGL['stok'] / $sumtopercentG * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentG != 0) ? substr($topercentGL['stok'] / $sumtopercentG * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentG != 0) ? ceil($inUseG / $sumtopercentG * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentG != 0) ? substr($inUseG / $sumtopercentG * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentG != 0) ? ceil($topercentGD['jumlah'] / $sumtopercentG * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentG != 0) ? substr($topercentGD['jumlah'] / $sumtopercentG * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Safety Glasses -->

                            <!-- Safety Gloves -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/gloves.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentGvL = $getData->getSumData('_tb_safety_gloves');
                                        $topercentGvB = $getData->getSumDataByYears('_tb_status_safety_gloves', '_status', 'Borrowed', date('Y'));
                                        $topercentGvI = $getData->getSumDataByYears('_tb_status_safety_gloves', '_status', 'Issued', date('Y'));
                                        $topercentGvD = $getData->getSumDataByYears('_tb_status_safety_gloves', '_status', 'Damaged', date('Y'));

                                        $sumtopercentGv = $topercentGvL['stok'] + $topercentGvB['jumlah'] + $topercentGvI['jumlah'] + $topercentGvD['jumlah'];
                                        $inUseGv = $topercentGvB['jumlah'] + $topercentGvI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentGv != 0) ? ceil($topercentGvL['stok'] / $sumtopercentGv * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentGv != 0) ? substr($topercentGvL['stok'] / $sumtopercentGv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentGv != 0) ? ceil($inUseGv / $sumtopercentGv * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentGv != 0) ? substr($inUseGv / $sumtopercentGv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentGv != 0) ? ceil($topercentGvD['jumlah'] / $sumtopercentGv * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentGv != 0) ? substr($topercentGvD['jumlah'] / $sumtopercentGv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Safety Gloves -->

                            <!-- Souvenir -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/souvenir.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentSvL = $getData->getSumData('_tb_souvenir');
                                        $topercentSvB = $getData->getSumDataByYears('_tb_status_souvenir', '_status', 'Borrowed', date('Y'));
                                        $topercentSvI = $getData->getSumDataByYears('_tb_status_souvenir', '_status', 'Issued', date('Y'));
                                        $topercentSvD = $getData->getSumDataByYears('_tb_status_souvenir', '_status', 'Damaged', date('Y'));

                                        $sumtopercentSv = $topercentSvL['stok'] + $topercentSvB['jumlah'] + $topercentSvI['jumlah'] + $topercentSvD['jumlah'];
                                        $inUseSv = $topercentSvB['jumlah'] + $topercentSvI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSv != 0) ? ceil($topercentSvL['stok'] / $sumtopercentSv * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentSv != 0) ? substr($topercentSvL['stok'] / $sumtopercentSv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSv != 0) ? ceil($inUseSv / $sumtopercentSv * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentSv != 0) ? substr($inUseSv / $sumtopercentSv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentSv != 0) ? ceil($topercentSvD['jumlah'] / $sumtopercentSv * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentSv != 0) ? substr($topercentSvD['jumlah'] / $sumtopercentSv * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Souvenir -->

                            <!-- Other -->
                            <div>
                                <div class="icon">
                                    <img src="<?= BASEURL; ?>/assets/img/other.png" alt="">
                                </div>
                                <div class="percent">
                                    <?php
                                        $topercentOL = $getData->getSumData('_tb_other');
                                        $topercentOB = $getData->getSumDataByYears('_tb_status_other', '_status', 'Borrowed', date('Y'));
                                        $topercentOI = $getData->getSumDataByYears('_tb_status_other', '_status', 'Issued', date('Y'));
                                        $topercentOD = $getData->getSumDataByYears('_tb_status_other', '_status', 'Damaged', date('Y'));

                                        $sumtopercentO = $topercentOL['stok'] + $topercentOB['jumlah'] + $topercentOI['jumlah'] + $topercentOD['jumlah'];
                                        $inUseO = $topercentOB['jumlah'] + $topercentOI['jumlah'];

                                    ?>
                                    <div>
                                        <b>Tersedia</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentO != 0) ? ceil($topercentOL['stok'] / $sumtopercentO * 100) : 0; ?>%; background-color:#90EE90;"><span><?= ($sumtopercentO != 0) ? substr($topercentOL['stok'] / $sumtopercentO * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Terpakai</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentO != 0) ? ceil($inUseO / $sumtopercentO * 100) : 0; ?>%; background-color:#FFA07A;"><span><?= ($sumtopercentO != 0) ? substr($inUseO / $sumtopercentO * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Rusak</b>
                                        <div class="div-progress">
                                            <div class="progress" style="width:<?= ($sumtopercentO != 0) ? ceil($topercentOD['jumlah'] / $sumtopercentO * 100) : 0; ?>%; background-color:#C0C0C0;"><span><?= ($sumtopercentO != 0) ? substr($topercentOD['jumlah'] / $sumtopercentO * 100, 0, 4) : 0; ?>%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Section Other -->
                            
                        </div>
                    </div>

                </div>

                <script>
                    setTimeout(function() {
                        window.location.reload();
                    }, 60000);
                </script>
                
        <?php
            break; 

            }
    ?>
        
   </div>

    <footer>
        &copy; Copyright HSSE Bunyu Field <?= date('Y'); ?>, WhatsApp : &nbsp; <a href=""><i class="fa fa-whatsapp" aria-hidden="true"></i> +62 821-5023-7071</a> 
    </footer>

    <!-- Javascript JQuery -->
    <script>
        function openNav() {
        document.getElementById("mySidenav").style.width = "240px";
        }

        function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <script>
        var load = document.getElementById('load');

        window.addEventListener('load', function(){
            load.style.display = "none";
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <script src="<?= BASEURL; ?>/assets/js/script.js"></script>

   
</body>
</html>
