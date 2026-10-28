<?php
    require_once "dataBase.php";

    class dataTable extends dataBase {
    
        protected $daftarTabel = ['_tb_activity', 
                                '_tb_borrow_coveralls', 
                                '_tb_borrow_other',
                                '_tb_borrow_safety_glasses',
                                '_tb_borrow_safety_gloves',
                                '_tb_borrow_safety_helmet',
                                '_tb_borrow_safety_shoes',
                                '_tb_category_apd',
                                '_tb_coveralls',
                                '_tb_other',
                                '_tb_rack',
                                '_tb_safety_glasses',
                                '_tb_safety_gloves',
                                '_tb_safety_helmet',
                                '_tb_safety_shoes',
                                '_tb_souvenir',
                                '_tb_request_coveralls',
                                '_tb_request_other',
                                '_tb_request_safety_glasses',
                                '_tb_request_safety_gloves',
                                '_tb_request_safety_helmet',
                                '_tb_request_safety_shoes',
                                '_tb_user_login',
                                '_tb_status_coveralls',
                                '_tb_status_other',
                                '_tb_status_safety_glasses',
                                '_tb_status_safety_gloves',
                                '_tb_status_safety_helmet',
                                '_tb_status_safety_shoes',
                                '_tb_status_souvenir',
                            '_tb_item_apd'];

    public function __construct() {
        //Wajib memanggil constructor induk (dataBase) agar koneksi $this->koneksi aktif
        parent::__construct();
    }

    public function getDaftarTabel() {
        //Digunakan untuk class yang bukan turunan dari dataTable, agar bisa mengakses daftar tabel
        return $this->daftarTabel;
    }
}