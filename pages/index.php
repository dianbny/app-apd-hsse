<?php
    error_reporting(0);

    //Require
    require_once "../config/const.php";
    require_once "../config/cekData.php";
    require_once "../config/getData.php";

    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();

    //Waktu 
    date_default_timezone_set("Asia/Kuala_Lumpur");
    setlocale(LC_ALL, 'id-ID', 'id_ID');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/assets/vendors/font-awesome/css/font-awesome.css" />
    <title>HSSE Bunyu Field</title>
</head>
<body>

<header>
    <div>
        <div class="link">
            <a href="">Kontak Kami</a>
        </div>
        <div class="link">
            <a href="<?= BASEURL; ?>/login" class="btnLg"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp; Login</a>
        </div>
    </div>
</header>
<div class="jumbotron">
    <div>
        <h1>
            Aplikasi Pergudangan HSSE<br>
            Pertamina EP Bunyu Field
        </h1>
        <span>Aplikasi untuk Memanajemen Pergudangan HSSE di Pertamina Bunyu</span> 

        <a href="" class="btnLm">Pelajari Selengkapnya</a>
    </div>
    
    <img src="<?= BASEURL; ?>/assets/img/hsee_ptm.png" alt="pertamina">
</div>
<div class="container">

    <div class="category">
        <div class="top">
            <h3>Lihat Berdasarkan Kategori</h3>
        </div>
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

                    <a href="<?= BASEURL; ?>/detail-coveralls" class="btnLd">Lihat</a>
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

                    <a href="<?= BASEURL; ?>/detail-safety-shoes" class="btnLd">Lihat</a>
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

                    <a href="<?= BASEURL; ?>/detail-safety-helmet" class="btnLd">Lihat</a>
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

                    <a href="<?= BASEURL; ?>/detail-safety-glasses" class="btnLd">Lihat</a>
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

                    <a href="<?= BASEURL; ?>/detail-safety-gloves" class="btnLd">Lihat</a>
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
            
                    <a href="<?= BASEURL; ?>/detail-other" class="btnLd">Lihat</a>
                </div>
            </div>

        </div>
    </div>

</div>

<footer>
    &copy; Copyright HSSE Bunyu Field <?= date('Y'); ?>, WhatsApp : &nbsp; <a href=""><i class="fa fa-whatsapp" aria-hidden="true"></i> +62 821-5023-7071</a> 
</footer>
</body>
</html>
