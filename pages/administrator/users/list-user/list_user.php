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
    <img src="<?= BASEURL; ?>/assets/img/users.png" alt="">List User
</div>
<div class="container-nd">
    <form action="<?= BASEURL; ?>/list-user" method="POST">

        <input type="text" name="name" value="<?= (isset($_POST['name'])) ? $_POST['name'] : ""; ?>" placeholder="Type Name/Username" required>

        <input type="submit" name="search" class="button-search" value="Search">
    </form>

    <div class="top">
        <h5>List User</h5>
        <div>
            <a href="<?= BASEURL; ?>/add-user" class="link-crud" style="background-color:#008000;"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?= BASEURL; ?>/list-user" class="link-crud" style="background-color:#FF4500;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
           
        </div>
    </div>
    <div class="table-layout">
        <table class="table-style">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Level User</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th style="text-align:center;" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($cekData->cekDataAll('_tb_user_login') > 0){
                        $no = 1; 
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $nama = filterInput($_POST['name']);
                            
                            if($cekData->cekDataLikeFr('_tb_user_login', '_nama', $nama) > 0){
                                foreach($getData->getDataAllLikeFr('_tb_user_login', '_nama', $nama, '_id') as $row){ ?>
                                    <tr>
                                        <td><?= $no++.'.'; ?></td>
                                        <td><?= $row['_nama']; ?></td>
                                        <td><?= $row['_email']; ?></td>
                                        <td><?= $row['_username']; ?></td>
                                        <td>
                                            <div class="status" style="background-color:<?= ($row['_level'] == "admin") ? "#90EE90" : "#FFA07A" ?>">
                                                <?= ucwords($row['_level']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>">
                                                <?= $row['_status']; ?>
                                            </div>
                                        </td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                        <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/edit-user/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                                        <td style="text-align:center;"><a href="<?= BASEURL; ?>/edit-password-user/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-key" aria-hidden="true"></i></a></td>
                                        <td style="text-align:center;">
                                            <?php
                                                if($row['_id'] != $_SESSION['id_user']){ ?>
                                                    <a href="javascript:void(0)" class="link-edit-detail delete-user" data-id="<?= $row['_id']; ?>" style="background-color:#800000"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                                    <td colspan="11" style="text-align:center;color:#FF0000;font-size:12px;">Data not found !</td>
                                </tr>
                      <?php }
                            
                        }
                        else {
                            foreach($getData->getDataAll('_tb_user_login', '_id') as $row){ ?>
                                <tr>
                                    <td><?= $no++.'.'; ?></td>
                                    <td><?= $row['_nama']; ?></td>
                                    <td><?= $row['_email']; ?></td>
                                    <td><?= $row['_username']; ?></td>
                                    <td>
                                        <div class="status" style="background-color:<?= ($row['_level'] == "admin") ? "#90EE90" : "#FFA07A" ?>">
                                            <?= ucwords($row['_level']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="status" style="background-color:<?php if($row['_status'] == "Approved") { echo "#90EE90"; } elseif($row['_status'] == "Pending") { echo "#FFA07A"; } else { echo "#F08080"; } ?>">
                                            <?= $row['_status']; ?>
                                        </div>
                                    </td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_created_at'])); ?></td>
                                    <td><?= strftime('%d %B %Y, %H:%M:%S', strtotime($row['_updated_at'])); ?></td>
                                    <td style="text-align:center;"><a href="<?= BASEURL; ?>/edit-user/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                                    <td style="text-align:center;"><a href="<?= BASEURL; ?>/edit-password-user/<?= $row['_id']; ?>" class="link-edit-detail" style="background-color:#FF4500;"><i class="fa fa-key" aria-hidden="true"></i></a></td>
                                    <td style="text-align:center;">
                                        <?php
                                            if($row['_id'] != $_SESSION['id_user'] && $row['_status'] != "Approved"){ ?>
                                                <a href="javascript:void(0)" class="link-edit-detail delete-user" data-id="<?= $row['_id']; ?>" style="background-color:#800000"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                      <?php }
                                            else {
                                                echo "-";
                                            }
                                        ?>
                                    </td>
                            
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