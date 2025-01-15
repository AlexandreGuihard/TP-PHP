<?php
declare(strict_types=1);


use App\AutoLoader;

use App\Views\Template;
use tools\type\Text;
use tools\type\Hidden;
use tools\type\Checkbox;
use tools\type\Textarea;
use provider\JSONLoader;


//foreach($form as $field) {
//    $className = "tools\\type\\".ucfirst($field['type']);
//    echo new $className($field['name'], $field['required']).PHP_EOL;
//}
//die();
//
//$text = new Text('myinput', false, 'coucou');
//echo $text->render().PHP_EOL;
//
//$checkbox = new Checkbox('mycheckbox', true);
//echo $checkbox->render().PHP_EOL;
//
//$hidden = new Hidden('myhidden');
//echo $hidden->render().PHP_EOL;
//
//echo new Text('mytexttostring').PHP_EOL;
//
//echo new Textarea('mytextarea', true, 'default value').PHP_EOL;

$quiz=[
    [
        'type' => 'radio',
        'name' => 'q1',
        'text' => 'Combien font 1+1?',
        'choices' =>[
            [
                'text' => '42',
                'value' => 'q1Ans1'
            ],
            [
                'text' => '2',
                'value' => 'q1Ans2'
            ],
            [
                'text' => '8',
                'value' => 'q1Ans3'
            ]
        ],
        'answer' => '2',
        'score' => 1,
        'required' => true
    ],
    [
        'type' => 'radio',
        'name' => 'q2',
        'text' => 'Quel est le meilleur?',
        'choices' =>[
            [
                'text' => 'le H',
                'value' => 'q2Ans1'
            ],
            [
                'text' => 'le S',
                'value' => 'q2Ans2'
            ],
            [
                'text' => 'Moi',
                'value' => 'q2Ans3'
            ]
        ],
        'answer' => 'le S',
        'score' => 2,
        'required' => true
    ],
    [
        'type' => 'text',
        'text' => 'Quel est la dizaine dans le nombre 6942',
        'answer' => '4',
        'score' => 10,
        'required' => true
    ],
    [
        'type' => 'text',
        'text' => 'Quoi',
        'answer' => 'feur',
        'score' => 3,
        'required' => true
    ]
];

function question_text($q) {
    echo ($q["text"] . "<br><input type='text' name='$q[name]'><br>");
}

function answer_text($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

function question_radio($q) {
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='radio' name='$q[name]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
    }
    echo $html;
}

function answer_radio($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
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

function answer_checkbox($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    $diff1 = array_diff($q["answer"], $v);
    $diff2 = array_diff($v, $q["answer"]);
    if (count($diff1) == 0 && count($diff2) == 0) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
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

// Affichage des questions dans une liste ordonnée
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<form method='POST' action='index.php'><ol>";
    foreach ($quiz as $q) {
        echo "<li>";
        $question_handlers[$q["type"]]($q);
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
} else {
    $question_total = 0;
    $question_correct = 0;
    $score_total = 0;
    $score_correct = 0;
    $reponse_correct=false;
    $i=1;
    foreach ($quiz as $q) {
        $question_total += 1;
        $answer_handlers[$q["type"]]($q, $_POST[$q["name"]] ?? NULL);
        echo "Réponse à la question ".$i.": ".$q['answer']."<br>";
        switch($q["type"]){
            case "radio":
                $score_correct+=answer_radio($q, $q[""]);
                $reponse_correct=true;
                break;
            case "text":
                $score_correct+=answer_text($q, $q["value"]);
                $reponse_correct=true;
                break;
            case "checkbox":
                $score_correct+=answer_checkbox($q, $q["value"]);
                $reponse_correct=true;
                break;
        }
        if($reponse_correct){
            $question_correct++;
        }
        $i++;
    }
    echo "Réponses correctes: " . $question_correct . "/" . $question_total . "<br>";
    echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
}

$questions=[];
//ob_start();
foreach($form as $field){
    $className="tools\\type\\".ucfirst($field['type']);
    //$tmp=new $className($field['name'],$field['required']);
    //echo $tmp->render().PHP_EOL;
    //$questions.add(new $className($field['name'],$field['required']));
}
//$content=ob_get_clean();



// Démarrage de la capture de sortie
ob_start();

// Récupération des variables dynamiques
$action = $_REQUEST['action'] ?? false;

// Chargement du contenu dynamique
switch ($action) {
    case "submit":
        include_once 'action/answer.php';
        break;
    default:
        include_once "action/form.php";
        break;
}

// Capture et stockage du contenu
$content = ob_get_clean();



// Configuration et rendu du template
$template = new Template('templates');
$template->setLayout('main');

$template->setContent($content);
$template->setTitle('Quiz');
$template->setCssFiles(['index.css']);




//phpinfo(INFO_VARIABLES);
?>



