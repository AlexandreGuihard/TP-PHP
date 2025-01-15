<?php
namespace quiz;

class Questions{
    private array $questions;

    public function __construct(){
        $this->questions=[];
    }

    public function getQuestions():array{
        return $this->questions;
    }

    public function addQuestion(Question $question):void{
        array_push($this->questions, $question);
    }
}
?>