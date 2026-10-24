<?php
    error_reporting(0);

    //Require
    require_once "../config/const.php";
    require_once "../config/cekData.php";
    require_once "../config/getData.php";

    //Inisialisasi
    $cekData = new cekData();
    $getData = new getData();

    $page = addslashes($_GET['page']);
    $sub = explode("-" , $page);

    $category = ""; 
    $folder = "";

    if(count($sub) == 2){
        $category = $sub[1];
        $folder = $sub[1];
    }
    elseif(count($sub) == 3) {
        $category = $sub[1].'_'.$sub[2];
        $folder = $sub[1].'-'.$sub[2];
    }


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
    <title>Detail Material - APD</title>
</head>
<body>
    <div class="jumbotron"></div>
    
    <div class="container">
        <div class="container-select-item">
        <a href="<?= BASEURL; ?>/landing-page" class="btn-close">X</a>

        <h5>Detail Material - APD (Alat Pelindung Diri)</h5>
        <div class="div-card">
            <?php
                if($cekData->cekDataAll('_tb_'.$category) > 0){
                    foreach($getData->getDataAll('_tb_'.$category, '_id') as $row){ ?>
                        <div class="card">
                            <img src="<?= BASEURL; ?>/uploads/<?= $folder; ?>/<?= $row['_foto']; ?>" alt="">
                            <table>
                                <tr>
                                    <td>Merk</td>
                                    <td>:</td>
                                    <td><b><?= $row['_merk']; ?></b></td>
                                </tr>
                                <tr>
                                    <td>Tipe</td>
                                    <td>:</td>
                                    <td><b><?= $row['_jenis']; ?></b></td>
                                </tr>
                                <tr>
                                    <td>Ukuran</td>
                                    <td>:</td>
                                    <td><b><?= ($row['_ukuran'] != "") ? $row['_ukuran'] : "Semua Ukuran"; ?></b></td>
                                </tr>
                                <tr>
                                    <td>Tersedia</td>
                                    <td>:</td>
                                    <td><div class="status" style="background-color:<?= ($row['_stok'] > 0) ? "#90EE90" : "#F08080"; ?>">&nbsp; <?= $row['_stok']; ?> &nbsp;</div></td>
                                </tr>
                                <tr>
                                    <td>Lokasi</td>
                                    <td>:</td>
                                    <td><b><?= $row['_lokasi_apd']; ?></b></td>
                                </tr>
                            </table>
                            
                        </div>
            <?php  }
                }
                else { ?>
                    <span style="font-size:13px;color:rgba(235, 31, 39, 1);">Data tidak ditemukan !</span>
        <?php }
            ?>
        </div>
    </div>
    </div>
</body>
</html>