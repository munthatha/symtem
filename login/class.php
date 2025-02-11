<?php
    class myclass {
        function link() {
            $connect = new mysqli('localhost','root','','product');
            return $connect;
        }
        function insert($table,$fields,$values) {
            $count = count($fields);
            $sql = "INSERT INTO $table(";
            for($i = 0; $i < $count; $i++) {
                if($i==($count-1)){
                    $sql .= $fields[$i].")";
                } else {
                    $sql .= $fields[$i].",";
                }
            }
            $sql .= ") values(";
            for($i = 0; $i < $count; $i++) {
                if($i==($count-1)){
                    $sql .= "'".$values[$i]."'";
                } else {
                    $sql .= "'".$values[$i]."',";
                }
            }
            $sql .= ")";
            return $this->link()->query($sql);
        }
    }

?>