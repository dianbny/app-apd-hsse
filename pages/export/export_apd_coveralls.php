<?php

    error_reporting(0);
    session_start();
    require_once "../../config/const.php";

    if(!isset($_SESSION['status-login']) || $_SESSION['level'] != "administrator"){ 
        header('location:'.BASEURL.'/logout');
    }

    require_once '../../config/getData.php';
    $getData = new getData();

    $filter = addslashes($_GET['filter']);

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Export Coveralls Status : $filter.xls");

?>

<div class="table-layout">
    <table class="table-style">
        <thead>
            <tr>
                <th>#</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Ukuran</th>
                <th><?= ($filter == "In Use/Damaged") ? "Jumlah" : "Tersedia"; ?></th>
                <th>Status</th>
                <th>User</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
                    
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1; 
                if(trim(strip_tags($filter)) == "In Store"){
                    foreach($getData->getDataAll('_tb_coveralls','_id') as $row){ ?>
                        <tr>
                            <td><?= $no++.'.'; ?></td>
                            <td><?= $row['_merk']; ?></td>
                            <td><?= $row['_jenis']; ?></td>
                            <td><?= $row['_ukuran']; ?></td>
                            <td><?= $row['_stok']; ?></td>
                            <td>In Store</td>
                            <td>
                                <?php
                                    $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                    echo $namaUser['_nama'];
                                ?>
                            </td>
                            <td><?= $row['_created_at']; ?></td>
                            <td><?= $row['_updated_at']; ?></td>
                               
                        </tr>
              <?php } ?>
                        <tr>
                            <td colspan="9" style="text-align:center;font-weight:bold;">Total APD - Material : 
                                <?php
                                    $totalCoveralls = $getData->getSumData('_tb_coveralls');
                                    echo $totalCoveralls['stok'];
                                ?>
                            </td>
                        </tr>
          <?php }
                else {
                    if($cekData->cekDataFrNE('_tb_status_coveralls', '_status', 'Restocked') > 0){
                        foreach($getData->getDataAllDescNE('_tb_status_coveralls', '_status', 'Restocked', '_id') as $row){ 
                            $detailAPD = $getData->getDataFr('_tb_coveralls', '_id', $row['_id_coveralls']); ?>
                                <tr>
                                    <td><?= $no++.'.'; ?></td>
                                    <td><?= $detailAPD['_merk']; ?></td>
                                    <td><?= $detailAPD['_jenis']; ?></td>
                                    <td><?= $detailAPD['_ukuran']; ?></td>
                                    <td><?= $row['_jumlah']; ?></td>
                                    <td><?= $row['_status']; ?></td>
                                    <td>
                                        <?php
                                            $namaUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']);
                                            echo $namaUser['_nama'];
                                        ?>
                                    </td>
                                    <td><?= $row['_created_at']; ?></td>
                                    <td><?= $row['_updated_at']; ?></td>
                                                
                                </tr>
                <?php }
                    }
                    else { ?>
                        <tr>
                            <td colspan="9" style="text-align:center;color:#FF0000;font-size:12px;">Data tidak ditemukan !</td>
                        </tr>
              <?php }
                
                }
            ?>
        </tbody>
    </table>
</div>