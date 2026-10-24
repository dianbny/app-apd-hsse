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
    <img src="<?= BASEURL; ?>/assets/img/safety-helmet.png" alt="">Safety Helmet
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/status-apd-safety-helmet" method="POST">
        <select name="filter" id="filter" class="select-filter" required>
            <?php
                if(isset($_POST['filter'])){ ?>
                    <option value="<?= $_POST['filter']; ?>" selected><?= $_POST['filter']; ?></option>
          <?php }
            ?>
            <option value="" disabled <?= (!isset($_POST['filter'])) ? "selected" : ""; ?>>- Filter -</option>
            <option value="Restocked">Restocked</option>
            <option value="Borrowed">Borrowed</option>
            <option value="Issued">Issued</option>
            <option value="Damaged">Damaged</option>
        </select>
    
        <input type="date" name="start" class="date-filter" value="<?= (isset($_POST['start'])) ? $_POST['start'] : ""; ?>" required>
        <input type="date" name="end" class="date-filter" value="<?= (isset($_POST['end'])) ? $_POST['end'] : ""; ?>" required>
    
        <input type="submit" name="search" class="button-search" value="Search">
    </form>

    <div class="top">
        <h5>Safety Helmet Status</h5>
        <div>
            <a href="<?= BASEURL; ?>/add-status-safety-helmet" class="link-crud" style="background-color:#008000;"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?= BASEURL; ?>/status-apd-safety-helmet" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Color</th>
                    <th>Qty</th>
                    <th>User</th>
                    <th>Requester</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_status_safety_helmet') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $filter = filterInput($_POST['filter']);
                            $start = filterInput($_POST['start']);
                            $end = filterInput($_POST['end']);
                            if($cekData->cekDataFrBW('_tb_status_safety_helmet', '_status', $filter, $start, $end) > 0){
                                foreach($getData->getDataAllFrBW('_tb_status_safety_helmet', '_status', $filter, $start, $end, '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_safety_helmet', '_id', $row['_id_safety_helmet']); ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td><?= $detailAPD['_merk']; ?></td>
                                        <td><?= $detailAPD['_jenis']; ?></td>
                                        <td><?= $detailAPD['_warna']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $namaRequester = $getData->getDataFr('_tb_user_login', '_id', $row['_id_requester']);
                                                echo $namaRequester['_nama'];
                                            ?>
                                        </td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Restocked") { echo "#90EE90"; } elseif($row['_status'] == "Borrowed") { echo "#FFA07A"; } elseif($row['_status'] == "Issued") { echo "#F08080"; } else { echo "#C0C0C0"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-status-safety-helmet/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                
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
                            if($cekData->cekDataScMY('_tb_status_safety_helmet', date('m'), date('Y'))){
                                foreach($getData->getDataAllDescMY('_tb_status_safety_helmet', date('m'), date('Y'), '_id') as $row){ 
                                    $detailAPD = $getData->getDataFr('_tb_safety_helmet', '_id', $row['_id_safety_helmet']); ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td><?= $detailAPD['_merk']; ?></td>
                                        <td><?= $detailAPD['_jenis']; ?></td>
                                        <td><?= $detailAPD['_warna']; ?></td>
                                        <td><?= $row['_jumlah']; ?></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $namaRequester = $getData->getDataFr('_tb_user_login', '_id', $row['_id_requester']);
                                                echo $namaRequester['_nama'];
                                            ?>
                                        </td>
                                        <td><div class="status" style="background-color:<?php if($row['_status'] == "Restocked") { echo "#90EE90"; } elseif($row['_status'] == "Borrowed") { echo "#FFA07A"; } elseif($row['_status'] == "Issued") { echo "#F08080"; } else { echo "#C0C0C0"; } ?>"><?= $row['_status']; ?></div></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-status-safety-helmet/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                
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

        <div class="status" style="background-color:#90EE90">
            Restocked
            <?php
                if($cekData->cekDataThMY('_tb_status_safety_helmet', '_status', 'Restocked', date('m'), date('Y')) > 0){
                    $restockR = $getData->getSumDataByMY('_tb_status_safety_helmet', '_status', 'Restocked', date('m'), date('Y'));
                    echo '('.$restockR['jumlah'].')';
                }
                else {
                    echo "(0)";
                }
            ?>

        </div>

        <div class="status" style="background-color:#FFA07A">
            Borrowed
            <?php
                if($cekData->cekDataThMY('_tb_status_safety_helmet', '_status', 'Borrowed', date('m'), date('Y')) > 0){
                    $restockB = $getData->getSumDataByMY('_tb_status_safety_helmet', '_status', 'Borrowed', date('m'), date('Y'));
                    echo '('.$restockB['jumlah'].')';
                }
                else {
                    echo "(0)";
                }
            ?>

        </div>

        <div class="status" style="background-color:#F08080">
            Issued
            <?php
                if($cekData->cekDataThMY('_tb_status_safety_helmet', '_status', 'Issued', date('m'), date('Y')) > 0){
                    $restockI = $getData->getSumDataByMY('_tb_status_safety_helmet', '_status', 'Issued', date('m'), date('Y'));
                    echo '('.$restockI['jumlah'].')';
                }
                else {
                    echo "(0)";
                }
            ?>

        </div>

        <div class="status" style="background-color:#C0C0C0">
            Damaged
            <?php
                if($cekData->cekDataThMY('_tb_status_safety_helmet', '_status', 'Damaged', date('m'), date('Y')) > 0){
                    $restockD = $getData->getSumDataByMY('_tb_status_safety_helmet', '_status', 'Damaged', date('m'), date('Y'));
                    echo '('.$restockD['jumlah'].')';
                }
                else {
                    echo "(0)";
                }
            ?>

        </div>

    </div>
    
</div>