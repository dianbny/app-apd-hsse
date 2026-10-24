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

?>
<div class="title-page">
    <img src="<?= BASEURL; ?>/assets/img/other.png" alt="">Other
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/request-apd-other" method="POST">
        <select name="filter" id="filter" class="select-filter" required>
            <?php
                if(isset($_POST['filter'])){ ?>
                    <option value="<?= $_POST['filter']; ?>" selected><?= $_POST['filter']; ?></option>
                    <option value="" disabled>- Filter -</option>
          <?php }
            ?>
            <option value="Pending" <?= (!isset($_POST['filter'])) ? "selected" : ""; ?>>Pending</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
        </select>
        
        <input type="date" name="start" class="date-filter" value="<?= (isset($_POST['start'])) ? $_POST['start'] : ""; ?>" required>
        <input type="date" name="end" class="date-filter" value="<?= (isset($_POST['end'])) ? $_POST['end'] : ""; ?>" required>

        <input type="submit" name="search" class="button-search" value="Search">
    </form>

    <div class="top">
        <h5>Other Items Request</h5>
        <div>
            <a href="<?= BASEURL; ?>/request-apd-other" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requester</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Reason for Replacement</th>
                    <th>Detail</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_request_other') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $filter = filterInput($_POST['filter']);
                            $start = filterInput($_POST['start']);
                            $end = filterInput($_POST['end']);
                            if($cekData->cekDataFrBW('_tb_request_other', '_status', $filter, $start, $end) > 0){
                                foreach($getData->getDataAllFrBW('_tb_request_other', '_status', $filter, $start, $end, '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_other', '_id', $row['_id_other']); ?>
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
                                        <td><?= $detailAPD['_jenis']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-request-other/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                    </tr>
                          <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                </tr>
                      <?php }
                            
                        }
                        else {
                            if($cekData->cekDataScMY('_tb_request_other', date('m'), date('Y'))){
                                foreach($getData->getDataAllDescMY('_tb_request_other', date('m'), date('Y'), '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_other', '_id', $row['_id_other']); ?>
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
                                        <td><?= $detailAPD['_jenis']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-request-other/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                    </tr>
                        <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                </tr>
                      <?php }
                        }
                    }
                    else { ?>
                        <tr>
                            <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                        </tr>
              <?php }
                ?>
            </tbody>
        </table>
    </div>
    
</div>