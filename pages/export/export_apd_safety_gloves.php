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
    header("Content-Disposition: attachment; filename=Export Safety gloves Status : $filter.xls");

?>

<div class="table-layout">
    <table class="table-style">
        <thead>
            <tr>
                <th>#</th>
                <th>Merk</th>
                <th>Type</th>
                <th><?= ($filter == "In Use/Damaged") ? "Amount" : "Stock"; ?></th>
                <th>Status</th>
                <th>User</th>
                <th>Created At</th>
                <th>Updated At</th>

            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1; 
                if(trim(strip_tags($filter)) == "In Store"){
                    foreach($getData->getDataAll('_tb_safety_gloves','_id') as $row){ ?>
                        <tr>
                            <td><?= $no++.'.'; ?></td>
                            <td><?= $row['_merk']; ?></td>
                            <td><?= $row['_jenis']; ?></td>
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
                            <td colspan="8" style="text-align:center;font-weight:bold;">Total Material - APD : 
                                <?php
                                    $totalsafety_gloves = $getData->getSumData('_tb_safety_gloves');
                                    echo $totalsafety_gloves['stok'];
                                ?>
                            </td>
                        </tr>
          <?php }
                else {
                    if($cekData->cekDataFrNE('_tb_status_safety_gloves', '_status', 'Restocked') > 0){
                        foreach($getData->getDataAllDescNE('_tb_status_safety_gloves', '_status', 'Restocked', '_id') as $row){ 
                            $detailAPD = $getData->getDataFr('_tb_safety_gloves', '_id', $row['_id_safety_gloves']); ?>
                                <tr>
                                    <td><?= $no++.'.'; ?></td>
                                    <td><?= $detailAPD['_merk']; ?></td>
                                    <td><?= $detailAPD['_jenis']; ?></td>
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
                            <td colspan="8" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                        </tr>
              <?php }
                
                }
            ?>
        </tbody>
    </table>
</div>