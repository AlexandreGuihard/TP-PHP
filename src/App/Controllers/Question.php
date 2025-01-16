<?php
namespace App\Controllers;

class Question{
    private String $name;
    private String $questionName;
    private String $questionType;
    private String $answer;
    private array $choices;
    private int $score;

    public function __construct(String $name, String $questionName, String $questionType, String $answer, array $choices, int $score){
        $this->name=$name;
        $this->questionName=$questionName;
        $this->questionType=$questionType;
        $this->answer=$answer;
        $this->choices=$choices;
        $this->score=$score;
    }

    public function getName():String{
        return $this->name;
    }
    public function getQuestionName():String{
        return $this->questionName;
    }

    public function getQuestionType():String{
        return $this->questionType;
    }

    public function getAnswer():String{
        return $this->answer;
    }

    public function getChoices():array{
        return $this->choices;
    }

    public function getScore():int{
        return $this->score;
    }

    public function setName(String $name):void{
        $this->name=$name;
    }
    public function setQuestionName(String $questionName):void{
        $this->questionName=$questionName;
    }

    public function setQuestionType(String $questionType):void{
        $this->questionType=$questionType;
    }

    public function setAnswer(String $answer):void{
        $this->answer=$answer;
    }

    public function setChoices(array $choices):void{
        $this->choices=$choices;
    }

    public function setScore(int $score):void{
        $this->score=$score;
    }
}
?>