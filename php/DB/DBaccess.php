<?php

namespace DB;

class DBaccess{
    
    //Qui si mettono i valori del proprio DB
    private const DB_NAME = "example";
    private const USERNAME = "root";
    private const ADDRESS = "localhost";
    private const PSWD = "";
    private $connetion = null;

    //true se la connesione è andata a buon fine, false altrimenti
    public function createDBconnection(){
        //self accede alle variabili costanti della classe
        $this->connection = new mysqli(DBaccess::ADDRESS,
                                 DBaccess::USERNAME,
                                 DBaccess::PSWD,
                                 DBaccess::DB_NAME);

        return !mysqli_connect_errno();
    }

    public function closeDBconn(){
        mysqli_close($this->connetion);
    }

    public function getList(){
        $playerList = array();

        $inputQuery = "SELECT * FROM giocatori ORDER BY capitano DESC,nome ASC";
        $plrQuery = mysqli_query($this->connetion,$inputQuery);

        if(!$plrQuery){
            return false;
        }
        if($plrQuery->num_rows > 0){
            $playerList[] = mysqli_fetch_assoc($plrQuery);
        }

        $plrQuery->free();

        return $playerList;
    }
}

?>
