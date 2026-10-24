<?php
    session_start();
    require_once '../../config/_const.php';

    //Cek Jika Session Belum Ada
    if(!isset($_SESSION['status-login']) || !isset($_SESSION['level'])){ 
        header('location:'.BASEURL);
    }

    //Cek Jika Data Session Sudah Ada
    if($_SESSION['status-login'] != "success"){
        header('location:'.BASEURL.'/logout');
    }
    elseif($_SESSION['level'] != "administrator"){
        header('location:'.BASEURL.'/logout');
    }

    $folder = '../../uploads/foto/';

    $nama_file = basename($_GET['file']); 

    $path_lengkap = $folder . $nama_file;

    //Cek File
    if (file_exists($path_lengkap)) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($path_lengkap);
        header("Content-Type: " . $mime_type);
    
        //Ambil Gambar
        readfile($path_lengkap);
        exit;
    }
    else { ?>
        <script>    
            window.location.href = "<?= BASEURL; ?>/logout";
        </script>
<?php } 
?>