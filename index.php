<?php

    error_reporting(0);

    if (session_status() === PHP_SESSION_ACTIVE){

        session_destroy();
        
    }
    
    header("location:landing-page");
    exit();
