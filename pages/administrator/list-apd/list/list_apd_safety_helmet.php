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
    <form action="<?= BASEURL; ?>/list-apd-safety-helmet" method="POST">
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
    
        <input type="submit" name="search" class="button-search" value="Cari">
    </form>

    <div class="top">
        <h5>Daftar Helm (Safety Helmet)</h5>
        <div>
            <a href="<?= BASEURL; ?>/add-apd-safety-helmet" class="link-crud" style="background-color:#008000;"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?= BASEURL; ?>/list-apd-safety-helmet" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <?php
                if($cekData->cekDataAll('_tb_safety_helmet') > 0){ ?>
                    <a href="<?= BASEURL; ?>/pages/export/export_apd_safety_helmet.php?filter=<?= (isset($_POST['filter'])) ? $_POST['filter'] : "In Store"; ?>" class="link-crud" style="background-color:#4169E1;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
          <?php }
            ?>
            
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Warna</th>
                    <th><?= (isset($_POST['filter']) && $_POST['filter'] == "In Use/Damaged") ? "Jumlah" : "Tersedia"; ?></th>
                    <th>Kadaluarsa</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Dibuat</th>
                    <th>Diperbarui</th>
                    <?php
                        if(!isset($_POST['filter']) || $_POST['filter'] == "In Store"){ ?>
                            <th style="text-align:center;">Aksi</th>
                  <?php }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_safety_helmet') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            if(trim(strip_tags($_POST['filter'])) == "In Store"){
                                foreach($getData->getDataAll('_tb_safety_helmet','_id') as $row){ ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td><?= $row['_merk']; ?></td>
                                        <td><?= $row['_jenis']; ?></td>
                                        <td><?= $row['_warna']; ?></td>
                                        <td><?= $row['_stok']; ?></td>
                                        <td>
                                            <?php
                                                if(substr($row['_expired'], 0, 4) == date('Y')){
                                                    if(substr($row['_expired'], 5, 2) <= date('m')){ ?>
                                                        <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                              <?php }
                                                    else { ?>
                                                        <div class="status" style="background-color: #FF8C00"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                              <?php }
                                                }
                                                elseif(substr($row['_expired'], 0, 4) < date('Y')){ ?>
                                                    <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                          <?php }
                                                else { ?>
                                                    <div class="status" style="background-color: #90EE90"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                          <?php }
                                        ?>
                                        </td>
                                        <td><div class="status" style="background-color:#90EE90;">In Store</div></td>
                                        <td>
                                            <?php
                                                $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                                echo $namaUser['_nama'];
                                            ?>
                                        </td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-apd-safety-helmet/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                
                                    </tr>
                          <?php } ?>
                                    <tr>
                                        <td colspan="11" style="text-align:center;font-weight:bold;">Total APD - Material : 
                                            <?php
                                                $totalSafetyHelmet = $getData->getSumData('_tb_safety_helmet');
                                                echo $totalSafetyHelmet['stok'];
                                            ?>
                                        </td>
                                    </tr>
                      <?php }
                            else {
                                if($cekData->cekDataFrNE('_tb_status_safety_helmet', '_status', 'Restocked') > 0){
                                    foreach($getData->getDataAllDescNE('_tb_status_safety_helmet', '_status', 'Restocked', '_id') as $row){
                                        $detailAPD = $getData->getDataFr('_tb_safety_helmet', '_id', $row['_id_safety_helmet']); ?>
                                        <tr>
                                            <td><?= $no++.'.'; ?></td>
                                            <td><?= $detailAPD['_merk']; ?></td>
                                            <td><?= $detailAPD['_jenis']; ?></td>
                                            <td><?= $detailAPD['_warna']; ?></td>
                                            <td><?= $row['_jumlah']; ?></td>
                                            <td>
                                                <?php
                                                    if(substr($detailAPD['_expired'], 0, 4) == date('Y')){
                                                        if(substr($detailAPD['_expired'], 5, 2) <= date('m')){ ?>
                                                            <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($detailAPD['_expired'])); ?></div>
                                                  <?php }
                                                        else { ?>
                                                            <div class="status" style="background-color: #FF8C00"><?= strftime('%d %B %Y', strtotime($detailAPD['_expired'])); ?></div>
                                                  <?php }
                                                    }
                                                    elseif(substr($detailAPD['_expired'], 0, 4) < date('Y')){ ?>
                                                        <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($detailAPD['_expired'])); ?></div>
                                              <?php }
                                                    else { ?>
                                                        <div class="status" style="background-color: #90EE90"><?= strftime('%d %B %Y', strtotime($detailAPD['_expired'])); ?></div>
                                              <?php }
                                                ?>
                                            </td>
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
                                        <td colspan="9" style="text-align:center;color:#FF0000;font-size:12px;">Data tidak ditemukan !</td>
                                    </tr>
                          <?php }
                            }
                        }
                        else {
                            foreach($getData->getDataAll('_tb_safety_helmet','_id') as $row){ ?>
                                <tr>
                                    <td><?= $no++.'.'; ?></td>
                                    <td><?= $row['_merk']; ?></td>
                                    <td><?= $row['_jenis']; ?></td>
                                    <td><?= $row['_warna']; ?></td>
                                    <td><?= $row['_stok']; ?></td>
                                    <td>
                                        <?php
                                            if(substr($row['_expired'], 0, 4) == date('Y')){
                                                if(substr($row['_expired'], 5, 2) <= date('m')){ ?>
                                                    <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                          <?php }
                                                else { ?>
                                                    <div class="status" style="background-color: #FF8C00"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                          <?php }
                                            }
                                            elseif(substr($row['_expired'], 0, 4) < date('Y')){ ?>
                                                <div class="status" style="background-color: #F08080"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                      <?php }
                                            else { ?>
                                                <div class="status" style="background-color: #90EE90"><?= strftime('%d %B %Y', strtotime($row['_expired'])); ?></div>
                                      <?php }
                                        ?>
                                    </td>
                                    <td><div class="status" style="background-color:#90EE90;">In Store</div></td>
                                    <td>
                                        <?php
                                            $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                            echo $namaUser['_nama'];
                                        ?>
                                    </td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                    <td style="text-align:center;"><a href="<?= BASEURL; ?>/detail-apd-safety-helmet/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                            
                                </tr>
                      <?php } ?>
                                <tr>
                                    <td colspan="11" style="text-align:center;font-weight:bold;">Total APD - Material : 
                                        <?php
                                            $totalSafetyHelmet = $getData->getSumData('_tb_safety_helmet');
                                            echo $totalSafetyHelmet['stok'];
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
                ?>
            </tbody>
        </table>
    </div>
    
</div>