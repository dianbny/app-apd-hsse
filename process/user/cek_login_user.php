<?php
    error_reporting(0);

    //Require
    require_once "../../config/const.php";
    require_once "../../config/cekData.php";
    
    //Inisialisasi
    $cekData = new cekData();

    //Waktu 
    date_default_timezone_set("Asia/Kuala_Lumpur");
    setlocale(LC_ALL, 'id-ID', 'id_ID');

    //Filter Data
    function filterInput($data){
        $data = trim($data);
        $data = strip_tags($data);
        $data = addslashes($data);
        return $data;
    }

    //Cek Login Administrator
    if($_GET['action'] == 'cek-login-user'){

        //Jika Submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            session_start();
            $username = filterInput($_POST['username']);
            $password = hash('sha256', $_POST['password']);

            if($cekData->cekLogin($username, $password, 'user') == TRUE){

                $_SESSION['status-login'] = "success";
                $_SESSION['level'] = "user";
                $_SESSION['username'] = $username;

                header('location:'.BASEURL.'/dashboard-user');
            }
            else {
                $_SESSION['status'] = "error";
                $_SESSION['msg'] = "Nama pengguna atau sandi salah !";

                header('location:'.BASEURL.'/login');
            }
        }
        else {
            
            header('location:'.BASEURL.'/landing-page');
        }


    }