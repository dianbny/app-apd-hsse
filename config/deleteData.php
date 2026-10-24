<?php
    require_once "dataBase.php";
    
    class deleteData extends dataBase {

        public function softDeleteData($table, $col, $dtcol, $deleteAt){
            mysqli_query($this->koneksi, "UPDATE $table SET _deleted_at = '$deleteAt' WHERE $col = '$dtcol' ");
        }

    }