<?php

namespace provider;
class JSONLoader{
    public function parseJSON(){
        $filePath="static/data/quiz.json";
        if (!file_exists($filePath)) {
            die("Erreur : Le fichier JSON '$filePath' est introuvable.");
        }
        $dataString=file_get_contents("static/data/quiz.json");
        return json_decode($dataString, true)["quiz"];
    }
}
?>