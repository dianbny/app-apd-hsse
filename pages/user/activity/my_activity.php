<?php
    if(!isset($_SESSION['status-login'])){ 
        require_once "../../../config/const.php";
        header('location:'.BASEURL);
    }
    elseif($_SESSION['level'] != "user"){
        header('location:'.BASEURL.'/logout');
    }

    $dataUser = $getData->getDataFr('_tb_user_login', '_id', $_SESSION['id_user']);
?>
<div class="title-page">
    <img src="<?= BASEURL; ?>/assets/img/task.png" alt="">Activity
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/my-activity" method="POST">
        
        <input type="date" name="start" class="date-filter" value="<?= (isset($_POST['start'])) ? $_POST['start'] : ""; ?>" required>
        <input type="date" name="end" class="date-filter" value="<?= (isset($_POST['end'])) ? $_POST['end'] : ""; ?>" required>
    
        <input type="submit" name="search" class="button-search" value="Cari">
    </form>

    <div class="top">
        <h5>Aktivitas Saya</h5>
        <div>
            <a href="<?= BASEURL; ?>/my-activity" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Level Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Dibuat</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataFrND('_tb_activity', '_id_user', $_SESSION['id_user']) > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $start = filterInput($_POST['start']);
                            $end = filterInput($_POST['end']);

                            if($cekData->cekDataBWUsr('_tb_activity', '_id_user', $_SESSION['id_user'], '_created_at', $start, $end) > 0){
                                foreach($getData->getDataAllBWUsr('_tb_activity', '_id_user', $_SESSION['id_user'], '_created_at', $start, $end, '_id') as $row){ ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td>
                                            <?php
                                                echo $dataUser['_nama'];
                                            ?>
                                        </td>
                                        <td>
                                            <div class="status" style="background-color:<?= ($dataUser['_level'] == "admin") ? "#90EE90" : "#FFA07A" ?>">
                                                <?= ucwords($dataUser['_level']); ?>
                                            </div>
                                        </td>
                                        <td><?= $row['_activity']; ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        
                                    </tr>
                          <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="5" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                </tr>
                      <?php }
                            
                        }
                        else {
                            if($cekData->cekDataThMYND('_tb_activity', '_created_at',date('m'), date('Y'), '_id_user', $_SESSION['id_user'])){
                                foreach($getData->getDataAllDescMYNDUsr('_tb_activity', '_id_user', $_SESSION['id_user'], '_created_at', date('m'), date('Y'), '_id') as $row){ ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td>
                                            <?php
                                                echo $dataUser['_nama'];
                                            ?>
                                        </td>
                                        <td>
                                            <div class="status" style="background-color:<?= ($dataUser['_level'] == "admin") ? "#90EE90" : "#FFA07A" ?>">
                                                <?= ucwords($dataUser['_level']); ?>
                                            </div>
                                        </td>
                                        <td><?= $row['_activity']; ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        
                                    </tr>
                        <?php }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="5" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                </tr>
                      <?php }
                        }
                    }
                    else { ?>
                        <tr>
                            <td colspan="5" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                        </tr>
              <?php }
                ?>
            </tbody>
        </table>
    </div>
    
</div>