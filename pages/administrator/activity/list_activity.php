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
    <img src="<?= BASEURL; ?>/assets/img/task.png" alt="">Activity
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/list-activity" method="POST">
        
        <input type="date" name="start" class="date-filter" value="<?= (isset($_POST['start'])) ? $_POST['start'] : ""; ?>" required>
        <input type="date" name="end" class="date-filter" value="<?= (isset($_POST['end'])) ? $_POST['end'] : ""; ?>" required>
    
        <input type="submit" name="search" class="button-search" value="Search">
    </form>

    <div class="top">
        <h5>List Activity</h5>
        <div>
            <a href="<?= BASEURL; ?>/list-activity" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Level</th>
                    <th>Activity</th>
                    <th>Created At</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAllND('_tb_activity') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $start = filterInput($_POST['start']);
                            $end = filterInput($_POST['end']);

                            if($cekData->cekDataBW('_tb_activity', '_created_at', $start, $end) > 0){
                                foreach($getData->getDataAllBW('_tb_activity', '_created_at', $start, $end, '_id') as $row){ 
                                    $dataUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']); ?>
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
                            if($cekData->cekDataScMYND('_tb_activity', '_created_at',date('m'), date('Y'))){
                                foreach($getData->getDataAllDescMYND('_tb_activity', '_created_at', date('m'), date('Y'), '_id') as $row){ 
                                    $dataUser = $getData->getDataFr('_tb_user_login', '_id', $row['_id_user']); ?>
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