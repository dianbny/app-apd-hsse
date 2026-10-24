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
    elseif($_SESSION['level'] != "user"){
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

        <a href="<?= BASEURL; ?>/dashboard-user"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp; Dashboard</a>
        <a href="javascript:void(0)" id="first"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; Daftar APD - Material</a>
            <div class="menu-first">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/user-list-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="javascript:void(0)" id="second"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Peminjaman</a>
            <div class="menu-second">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/user-borrowing-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="javascript:void(0)" id="third"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Permintaan</a>
            <div class="menu-third">
                <?php
                    if($cekData->cekDataAll('_tb_category_apd') > 0){
                        foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                            <a href="<?= BASEURL.'/user-request-apd-'.str_replace(' ', '-', strtolower($row['_category'])); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; <?= $row['_category']; ?></a>
                 <?php  }
                    }
                ?>
            </div>
        <a href="<?= BASEURL; ?>/my-activity"><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp; Aktivitas Saya</a>
        <a href="<?= BASEURL; ?>/password-user"><i class="fa fa-key" aria-hidden="true"></i>&nbsp; Pengaturan Sandi</a>

    </div>

    <div class="jumbotron"></div>
    
    <div class="container">

    <?php

        $page = addslashes($_GET['page']);

        $sub = explode("-" , $page);

        $category = ""; 
        $file = "";

        if(count($sub) == 4) {
            $category = $sub[3];
            $file = $sub[3];
        }
        elseif(count($sub) == 5) {
            $category = $sub[3].'-'.$sub[4];
            $file = $sub[3].'_'.$sub[4];
        }

        switch($page){
            case 'user-list-apd-'.$category:

                include 'list-apd/list/list_apd_'.$file.'.php';
                    
                break;
            
            case 'user-borrowing-apd-'.$category:

                include 'borrowing-apd/list/borrowing_apd_'.$file.'.php';
                    
                break;

            case 'user-select-borrowing-'.$category:

                include 'borrowing-apd/select/select_borrowing_'.$file.'.php';
                        
                break;

            case 'user-add-borrowing-'.$category:

                include 'borrowing-apd/add/add_borrowing_'.$file.'.php';
                        
                break;

            case 'user-request-apd-'.$category:

                include 'request-apd/list/request_apd_'.$file.'.php';
                
                break;

            case 'user-select-request-'.$category:

                include 'request-apd/select/select_request_'.$file.'.php';
                            
                break;

            case 'user-add-request-'.$category:

                include 'request-apd/add/add_request_'.$file.'.php';
                            
                break;

            case 'my-activity':

                include 'activity/my_activity.php';
                                
                break;

            case 'password-user':

                include 'user/password.php';
                                    
                break;


            case "dashboard-user" : ?>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-coveralls" class="btnLd">Detail</a>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-safety-shoes" class="btnLd">Detail</a>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-safety-helmet" class="btnLd">Detail</a>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-safety-glasses" class="btnLd">Detail</a>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-safety-gloves" class="btnLd">Detail</a>
                            </div>
                        </div>

                        <div>
                            <div class="image">
                                <img src="<?= BASEURL; ?>/assets/img/other.png" alt="">
                            </div>
                            <div class="info">
                                <h6>Lainnya</h6>
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
            
                                <a href="<?= BASEURL; ?>/user-list-apd-other" class="btnLd">Detail</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="info-user">
                    <div>
                        <h5>Status Peminjaman APD - Material</h5>
                            <div class="table-layout">
                                <table class="table-style">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th style="text-align:center;">Diproses</th>
                                            <th style="text-align:center;">Disetujui</th>
                                            <th style="text-align:center;">Jatuh Tempo</th>
                                            <th>Terakhir Diperbarui</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($cekData->cekDataAll('_tb_category_apd') > 0){
                                                foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                                                    <tr>
                                                        <td><?= $row['_category']; ?></td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#FFA07A;">
                                                                <?php
                                                                    $brPending = $cekData->cekDataSc('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_status', '_id_user', 'Pending', $_SESSION['id_user']);
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
                                                                    $brApproved = $cekData->cekDataSc('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_status', '_id_user', 'Approved', $_SESSION['id_user']);
                                                                    echo $brApproved;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#F08080;">
                                                            <?php
                                                                $brDDate = $cekData->cekDataFoLKS('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_tgl_pengembalian', date('Y-m-d'), '_status', 'Approved', '_status_pengembalian', 'False','_id_user', $_SESSION['id_user']);
                                                                echo $brDDate;

                                                                if($brDDate > 0){ ?>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                          <?php }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if($cekData->cekDataFr('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])), '_id_user', $_SESSION['id_user']) > 0){
                                                                $lastUpdated = $getData->getDataByLimit('_tb_borrow_'.str_replace(' ','_', strtolower($row['_category'])));

                                                                echo strftime('%d %B %Y, %H:%M:%S', strtotime($lastUpdated['_updated_at']));
                                                            }
                                                            else {
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </td>

                                                </tr>

                                          <?php }
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>

                    <div>
                        <h5>Status Permintaan APD - Material</h5>
                            <div class="table-layout">
                                <table class="table-style">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th style="text-align:center;">Diproses</th>
                                            <th style="text-align:center;">Disetujui</th>
                                            <th>Terakhir Diperbarui</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($cekData->cekDataAll('_tb_category_apd') > 0){
                                                foreach ($getData->getDataAllNE('_tb_category_apd','_id','6','_id') as $row){ ?>
                                                    <tr>
                                                        <td><?= $row['_category']; ?></td>
                                                        <td>
                                                            <div class="status-dashboard" style="background-color:#FFA07A;">
                                                                <?php
                                                                    $rqPending = $cekData->cekDataSc('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])), '_status', '_id_user', 'Pending', $_SESSION['id_user']);
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
                                                                    $rqApproved = $cekData->cekDataSc('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])), '_status', '_id_user', 'Approved', $_SESSION['id_user']);
                                                                    echo $rqApproved;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if($cekData->cekDataFr('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])), '_id_user', $_SESSION['id_user']) > 0){
                                                                    $lastUpdatedRq = $getData->getDataByLimit('_tb_request_'.str_replace(' ','_', strtolower($row['_category'])));

                                                                    echo strftime('%d %B %Y, %H:%M:%S', strtotime($lastUpdatedRq['_updated_at']));
                                                                }
                                                                else {
                                                                    echo "-";
                                                                }
                                                            ?>
                                                        </td>

                                                    </tr>

                                          <?php }
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>

                <div class="warn">
                    <h3><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp; Informasi Pengguna</h3><br>
                    <ul>
                        <li>User dapat melakukan peminjaman/permintaan barang (material/APD) dengan menggunakan aplikasi</li>
                        <li>User harus melakukan pengembalian barang sebelum atau pada saat tanggal pengembalian barang (material/APD) yang telah ditentukan</li>
                        <li>Pada saat permintaan barang (material/APD) user harus melampirkan foto barang (material/APD) yang bermasalah/rusak sebagai bukti untuk permintaan barang (material/AP) baru</li>
                        <li>Untuk informasi lebih lanjut dapat menghubungin kontak berikut +62 823-3646-9903</li>
                    </ul>
                    <img src="<?= BASEURL; ?>/assets/img/hsee_ptm.png" alt="pertamina">
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