<?php

use DB\DBaccess;

require_once("." . DIRECTORY_SEPARATOR . "DB" . DIRECTORY_SEPARATOR . "DBaccess.php");

$page = file_get_contents(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "squadraDB");
$connection = new DBaccess();

$finalResult = "";
if(!$connection->createDBconnection()){
    $finalResult .= "<dt>Impossibile accedere al database, ci scusiamo per il disagio :C</dt>";
}
else{
    $players = $connection->getList();
    //SOLO PER SCOPO DIDATTICO LMAO
    $auxArray = array("Data di nascita" => "dataNascita",
        "Luogo" => "luogo",
        "Squadra" => "squadra",
        "Ruolo" => "ruolo",
        "Altezza" => "altezza",
        "Maglia" => "maglia",
        "Maglia in nazionale" => "magliaNazionale",
        "Punti" => "punti",
        "Riconoscimenti" => "riconoscimenti",
        "Note" => "note");

    if($players){
        if(count($players) > 0){
            foreach ($players as $player){
                $finalResult.= "<dt>". $player["nome"];
                if($player["capitano"] == 1){
                    $finalResult.= "- L'ULTIMO ARRIVATO";
                }
                $finalResult.=  "</dt>\n";
                $imgString = ".." . DIRECTORY_SEPARATOR . $player["immagine"];
                $imgString = str_replace("images","assets",$imgString);

                $finalResult .= "<img src=" . $imgString . 'width= "100" height="150"/>\n';
                $finalResult .= '<dl class="giocatore">\n';

                foreach ($auxArray as $key => $value) {
                    $finalResult .= "<dt>$key</dt>\n";
                    $finalResult .= "<dd>" . $player[$value] . "</dd>\n";
                }
                $finalResult .= "</dl>";
            }
        }
        else{
            $finalResult .= "<p>Il database sembra vuoto, se il problema persiste contattare l'amministratore</p>";
        }
    }
}


$connection->closeDBconn();

$page = str_replace("<playerList />",$finalResult,$page);

?>
