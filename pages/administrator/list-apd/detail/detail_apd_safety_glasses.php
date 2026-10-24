<?php
    //Cek Jika Session Belum Ada
    if(!isset($_SESSION['status-login']) || !isset($_SESSION['level'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    
    //Cek Jika Data Session Sudah Ada
    if($_SESSION['status-login'] != "success"){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/logout'; ?>";
        </script>
<?php }
    elseif($_SESSION['level'] != "administrator"){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/logout'; ?>";
        </script>
<?php }
    
    //Cek Data Berdasarkan ID
    if($cekData->cekDataFr('_tb_safety_glasses','_id', $_GET['id']) < 1){ ?>
        <script>
            window.location.href = "<?= BASEURL.'/list-apd-safety-glasses'; ?>";
        </script>
<?php }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    $detailAPD = $getData->getDataFr('_tb_safety_glasses', '_id', $id);
?>
<div class="container-detail">
    <a href="<?= BASEURL; ?>/list-apd-safety-glasses" class="btn-close">X</a>

    <div>
        <div class="image">
            <img src="<?= BASEURL; ?>/uploads/safety-glasses/<?= $detailAPD['_foto']; ?>" alt="">
            <a href="<?= BASEURL; ?>/edit-apd-safety-glasses/<?= $id; ?>" class="link-edit-delete" style="background-color:#FF4500;"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Update</a>
            <a href="javascript:void(0)" class="link-edit-delete" style="background-color:#800000;" id="delete-safety-glasses" data-id="<?= $id; ?>"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a>
            <a href="#" class="link-edit-delete" style="background-color:#008000;"><i class="fa fa-image" aria-hidden="true"></i>&nbsp; Image</a>
        </div>
        <div class="detail">
            <span>Detail Kacamata (Safety Glasses)</span><hr>
            <table class="table-detail">
                <tr>
                    <td>Merk</td>
                    <td>:</td>
                    <td><b><?= $detailAPD['_merk']; ?></b></td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td>:</td>
                    <td><b><?= $detailAPD['_jenis']; ?></b></td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td>:</td>
                    <td><b><?= $detailAPD['_warna']; ?></b></td>
                </tr>
                <tr>
                    <td>Tersedia</td>
                    <td>:</td>
                    <td><div class="status" style="background-color:<?= ($detailAPD['_stok'] > 0) ? "#90EE90" : "#F08080"; ?>">&nbsp; <?= $detailAPD['_stok']; ?> &nbsp;</div></td>
                </tr>
                <tr>
                    <td>Lokasi APD</td>
                    <td>:</td>
                    <td><b><?= $detailAPD['_lokasi_apd']; ?></b></td>
                </tr>
                <tr>
                    <td>Detail Rak</td>
                    <td>:</td>
                    <td>
                        <b>
                            <?php
                                $rak = $getData->getDataFr('_tb_rack', '_id', $detailAPD['_rack']);
                                echo $rak['_code_rack'].'.'.$detailAPD['_detail_rack_num'];
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>:</td>
                    <td>
                        <b>
                            <?php
                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $detailAPD['_id_user']);
                                echo $namaUser['_nama'];
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>Dibuat</td>
                    <td>:</td>
                    <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailAPD['_created_at'])); ?></b></td>
                </tr>
                <tr>
                    <td>Diperbarui</td>
                    <td>:</td>
                    <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailAPD['_updated_at'])); ?></b></td>
                </tr>
            </table>    
            <br>
        </div>
    </div>

    <?php
        $user = $getData->getDataFr('_tb_user_login', '_id', $detailAPD['_id_user']);
    ?>
    <span style="display:block;font-size:12px;margin:30px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Terakhir diperbarui oleh <b><?= $user['_nama']; ?></b>, pada : <b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailAPD['_updated_at'])); ?></b> </span>
</div>