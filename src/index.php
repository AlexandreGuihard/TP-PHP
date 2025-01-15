<?php
declare(strict_types=1);

require 'classes/AutoLoader.php';
AutoLoader::register();

use templates\Template;
use tools\type\Text;
use tools\type\Hidden;
use tools\type\Checkbox;
use tools\type\Textarea;
use provider\JSONLoader;
use quiz\Question;
use quiz\Questions;
use action\Answers;


$jsonLoader=new JSONLoader();
$quiz=$jsonLoader->parseJSON();
function question_text($q) {
    echo ($q["questionName"] . "<br><input type='text' name='$q[name]'><br>");
}

function question_radio($q) {
    $html = $q["questionName"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='radio' name='" . $q["name"] . "' value='" . $c["value"] . "' id='" . $q["name"] . "-$i'>";
        $html .= "<label for='" . $q["name"] . "-$i'>" . $c["name"] . "</label><br>";
    }
    echo $html;
}


function question_checkbox($q) {
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='checkbox' name='$q[name][]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
    }
    echo $html;
}

$question_handlers = array(
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
);

$answer_handlers = array(
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
);

$questions=new Questions();
// Affichage des questions dans une liste ordonnée

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<form method='POST' action='index.php'><ol>";
    foreach ($quiz as $q) {
        $name=$q["name"];
        $questionName = $q["questionName"];
        $questionType = $q["type"];
        $answer = $q["answer"];
        $questionScore=$q["score"];
        $choices = [];

        if ($q["type"] == "radio") {
            foreach ($q["choices"] as $choice) {
                $choices[$choice["value"]] = $choice["name"];
            }
        }

        // Créez un objet Question et ajoutez-le
        $question = new Question($name, $questionName, $questionType, $answer, $choices, $questionScore);
        $questions->addQuestion($question);

        // Affichage de la question
        $question_handlers[$q["type"]]($q);  // Appel de la fonction pour afficher la question
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
}
else{
    $answers=new Answers();
    $answers->checkAnswers($questions); 
}

$action=$_REQUEST['action']??false;
ob_start();
if($action=="submit"){
    include "classes/action/Answers.php";
}
$content=ob_get_clean();
?>



