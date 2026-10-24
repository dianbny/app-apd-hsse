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
    <img src="<?= BASEURL; ?>/assets/img/other.png" alt="">Other Items
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/list-apd-other" method="POST">
        <select name="filter" id="filter" class="select-filter" required>
            <?php
                if(isset($_POST['filter'])){ ?>
                    <option value="<?= $_POST['filter']; ?>" selected><?= $_POST['filter']; ?></option>
                    <option value="" disabled>- Filter -</option>
          <?php }
            ?>
            <option value="In Store" <?= (!isset($_POST['filter'])) ? "selected" : ""; ?>>In Store</option>
            <option value="In Use/Damaged">In Use/Damaged</option>
        </select>
    
        <input type="submit" name="search" class="button-search" value="Search">
    </form>

    <div class="top">
        <h5>List of Other Items</h5>
        <div>
            <a href="<?= BASEURL; ?>/add-apd-other" class="link-crud" style="background-color:#008000;"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?= BASEURL; ?>/list-apd-other" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <?php
                if($cekData->cekDataAll('_tb_other') > 0){ ?>
                    <a href="<?= BASEURL; ?>/pages/export/export_apd_other.php?filter=<?= (isset($_POST['filter'])) ? $_POST['filter'] : "In Store"; ?>" class="link-crud" style="background-color:#4169E1;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
          <?php }
            ?>
            
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th><?= (isset($_POST['filter']) && $_POST['filter'] == "In Use/Damaged") ? "Amount" : "Stock"; ?></th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <?php
                        if(!isset($_POST['filter']) || $_POST['filter'] == "In Store"){ ?>
                            <th style="text-align:center;">Action</th>
                  <?php }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_other') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            if(trim(strip_tags($_POST['filter'])) == "In Store"){
                                foreach($getData->getDataAll('_tb_other','_id') as $row){ ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td><?= $row['_jenis']; ?></td>
                                        <td><?= $row['_stok']; ?></td>
                                        <td><div class="status" style="background-color:#90EE90;">In Store</div></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-apd-other/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                
                                    </tr>
                          <?php } ?>
                                <tr>
                                    <td colspan="10" style="text-align:center;font-weight:bold;">Total Material - APD : 
                                        <?php
                                            $totalOther = $getData->getSumData('_tb_other');
                                            echo $totalOther['stok'];
                                        ?>
                                    </td>
                                </tr>
                      <?php }
                            else {
                                if($cekData->cekDataFrNE('_tb_status_other', '_status', 'Restocked') > 0){
                                    foreach($getData->getDataAllDescNE('_tb_status_other', '_status', 'Restocked', '_id') as $row){ 
                                        $detailAPD = $getData->getDataFr('_tb_other', '_id', $row['_id_other']); ?>
                                        <tr>
                                            <td><?= $no++.'.'; ?></td>
                                            <td><?= $detailAPD['_jenis']; ?></td>
                                            <td><?= $row['_jumlah']; ?></td>
                                            <td><div class="status" style="background-color:<?php if($row['_status'] == "Borrowed") { echo "#FFA07A"; } elseif($row['_status'] == "Issued") { echo "#F08080"; } else { echo "#C0C0C0"; } ?>"><?= $row['_status']; ?></div></td>
                                            <td>
                                                <?php
                                                    $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                    echo $namaUser['_nama'];
                                                ?>
                                            </td>
                                            <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                            <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                            
                                        </tr>
                            <?php }
                                }
                                else { ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                    </tr>
                          <?php }
                            }
                        }
                        else {
                            foreach($getData->getDataAll('_tb_other','_id') as $row){ ?>
                                <tr>
                                    <td><?= $no++.'.'; ?></td>
                                    <td><?= $row['_jenis']; ?></td>
                                    <td><?= $row['_stok']; ?></td>
                                    <td><div class="status" style="background-color:#90EE90;">In Store</div></td>
                                    <td>
                                        <?php
                                            $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                            echo $namaUser['_nama'];
                                        ?>
                                    </td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                    <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-apd-other/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                            
                                </tr>
                      <?php } ?>
                                <tr>
                                    <td colspan="10" style="text-align:center;font-weight:bold;">Total Material - APD : 
                                        <?php
                                            $totalOther = $getData->getSumData('_tb_other');
                                            echo $totalOther['stok'];
                                        ?>
                                    </td>
                                </tr>
                 <?php  }
                    }
                    else { ?>
                        <tr>
                            <td colspan="8" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                        </tr>
              <?php }
                ?>
            </tbody>
        </table>
    </div>
    
</div>