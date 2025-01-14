<?php

namespace provider;
class JSONLoader{
    private String $filePath;

    public function __construct(String $filePath){
        $this->$filePath=$filePath;
    }

    public function getFilePath(){
        return $this->$filePath;
    }

    public function setFilePath(String $newFilePath){
        $this->$filePath=$newFilePath;
    }

    public function parseJSON(){
        $dataString=file_get_contents("data/quiz.json");
        return json_decode($dataString, true);
    }
}
?>