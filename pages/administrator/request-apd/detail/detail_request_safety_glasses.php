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

    $id = addslashes($_GET['id']);

    $detailStatus = $getData->getDataFr('_tb_request_safety_glasses', '_id', $id);
    $detailAPD = $getData->getDataFr('_tb_safety_glasses', '_id', $detailStatus['_id_safety_glasses']);
?>
<div class="container-detail">
    <a href="<?= BASEURL; ?>/request-apd-safety-glasses" class="btn-close">X</a>

    <h5>Safety Glasses Status Details</h5>
    <table class="table-detail">
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><div class="status" style="background-color:<?php if($detailStatus['_status'] == "Approved") { echo "#90EE90"; } elseif($detailStatus['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>"><?= $detailStatus['_status']; ?></div></td>
        </tr>
        <tr>
            <td>Requester</td>
            <td>:</td>
            <td>
                <b>
                    <?php
                        $namaRequester = $getData->getDataFr('_tb_user_login', '_id', $detailStatus['_id_user']);
                        echo $namaRequester['_nama'];
                    ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td><b><?= $detailStatus['_nama']; ?></b></td>
        </tr>
        <tr>
            <td>Position</td>
            <td>:</td>
            <td><b><?= $detailStatus['_jabatan']; ?></b></td>
        </tr>
        <tr>
            <td>Reason for Replacement</td>
            <td>:</td>
            <td><b><?= $detailStatus['_keterangan']; ?></b></td>
        </tr>
        <tr>
            <td>Detail Request</td>
            <td>:</td>
            <td><b><?= $detailAPD['_merk'].' | '.$detailAPD['_jenis'].' | '.$detailAPD['_warna']; ?></b></td>
        </tr>
        <tr>
            <td>Stock</td>
            <td>:</td>
            <td><b><?= $detailAPD['_stok']; ?></b></td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>:</td>
            <td><b><?= $detailStatus['_jumlah']; ?></b></td>
        </tr>
        <tr>
            <td>Old Material/APD Photo</td>
            <td>:</td>
            <td>
                <?php
                    if($detailStatus['_foto'] == '-'){ ?>
                        <img src="<?= BASEURL; ?>/assets/img/no-image.png" alt="" style="width:70%;">
              <?php }
                    else { ?>
                        <img src="<?= BASEURL; ?>/uploads/request/<?= $detailStatus['_foto']; ?>" alt="" style="width:70%;">
              <?php }
                ?>
            </td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>:</td>
            <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailStatus['_created_at'])); ?></b></td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>:</td>
            <td><b><?= strftime('%d %B %Y, %H:%M:%S', strtotime($detailStatus['_updated_at'])); ?></b></td>
        </tr>
    </table>
    <?php
        if($detailStatus['_status'] == "Pending"){ ?>
            <a href="javascript:void(0)" class="btn-edit-delete" id="approved-request" data-id="<?= $id; ?>" data-category="safety-glasses" style="background-color:#008000;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Approved</a>
            <a href="javascript:void(0)" class="btn-edit-delete" id="rejected-request" data-id="<?= $id; ?>" data-category="safety-glasses" style="background-color:#800000;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; Rejected</a>
  <?php }
        else { ?>
            <span style="display:block;font-size:12px;margin:30px 8px;">Status : <?= $detailStatus['_status']; ?></span>
  <?php }
    ?>
    
</div>