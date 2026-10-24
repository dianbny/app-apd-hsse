<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }
?>
<div class="title-page">
    <img src="<?= BASEURL; ?>/assets/img/coveralls.png" alt="">Coveralls
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/user-request-apd-coveralls" method="POST">
        <select name="filter" id="filter" class="select-filter" required>
            <?php
                if(isset($_POST['filter'])){ ?>
                    <option value="<?= $_POST['filter']; ?>" selected><?= $_POST['filter']; ?></option>
                    <option value="" disabled>- Filter -</option>
          <?php }
            ?>
            <option value="Pending" <?= (!isset($_POST['filter'])) ? "selected" : ""; ?>>Pending</option>
            <option value="Approved">Approved</option>
        </select>
        
        <input type="date" name="start" class="date-filter" value="<?= (isset($_POST['start'])) ? $_POST['start'] : ""; ?>" required>
        <input type="date" name="end" class="date-filter" value="<?= (isset($_POST['end'])) ? $_POST['end'] : ""; ?>" required>

        <input type="submit" name="search" class="button-search" value="Cari">
    </form>

    <div class="top">
        <h5>Daftar Permintaan Baju Terusan (Coveralls)</h5>
        <div>
            <a href="<?= BASEURL; ?>/user-select-request-coveralls" class="link-crud" style="background-color:#008000;"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?= BASEURL; ?>/user-request-apd-coveralls" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pemohon</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Alasan Penggantian</th>
                    <th>Detail</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Diperbarui</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_request_coveralls') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $filter = filterInput($_POST['filter']);
                            $start = filterInput($_POST['start']);
                            $end = filterInput($_POST['end']);
                            if($cekData->cekDataScBW('_tb_request_coveralls', '_status', $filter, '_id_user', $_SESSION['id_user'], $start, $end) > 0){
                                foreach($getData->getDataAllScBW('_tb_request_coveralls', '_status', $filter, '_id_user', $_SESSION['id_user'], $start, $end, '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_coveralls', '_id', $row['_id_coveralls']); ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td><?= $row['_nama']; ?></td>
                                        <td><?= $row['_jabatan']; ?></td>
                                        <td><?= $row['_keterangan']; ?></td>
                                        <td><?= $detailAPD['_merk'].' | '.$detailAPD['_jenis'].' | '.$detailAPD['_ukuran']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;">
                                            <?php
                                                if($row['_status'] == "Pending"){ ?>
                                                    <a href="javascript:void(0)" class="link-edit-detail delete-request" data-id="<?= $row['_id']; ?>" data-category="coveralls" style="background-color:#800000;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                          <?php }
                                                else {
                                                    echo "-";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                          <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data tidak ditemukan !</td>
                                </tr>
                      <?php }
                            
                        }
                        else {
                            if($cekData->cekDataScMYUsr('_tb_request_coveralls', '_id_user', $_SESSION['id_user'], date('m'), date('Y'))){
                                foreach($getData->getDataAllDescMYUsr('_tb_request_coveralls', '_id_user', $_SESSION['id_user'], date('m'), date('Y'), '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_coveralls', '_id', $row['_id_coveralls']); ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td><?= $row['_nama']; ?></td>
                                        <td><?= $row['_jabatan']; ?></td>
                                        <td><?= $row['_keterangan']; ?></td>
                                        <td><?= $detailAPD['_merk'].' | '.$detailAPD['_jenis'].' | '.$detailAPD['_ukuran']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;">
                                            <?php
                                                if($row['_status'] == "Pending"){ ?>
                                                    <a href="javascript:void(0)" class="link-edit-detail delete-request" data-id="<?= $row['_id']; ?>" data-category="coveralls" style="background-color:#800000;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                          <?php }
                                                else {
                                                    echo "-";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                        <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data tidak ditemukan !</td>
                                </tr>
                      <?php }
                        }
                    }
                    else { ?>
                        <tr>
                            <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data tidak ditemukan !</td>
                        </tr>
              <?php }
                ?>
            </tbody>
        </table>
    </div>
    
</div>