<?php
declare(strict_types=1);

use App\AutoLoader;
use App\Views\Template;
use tools\type\Text;
use tools\type\Hidden;
use tools\type\Checkbox;
use tools\type\Textarea;
use provider\JSONLoader;
use App\Controllers\Questions;
use App\Controllers\Question;
use action\Answers;

AutoLoader::register();
session_start();

$jsonLoader = new JSONLoader();
$quiz = $jsonLoader->parseJSON();

function question_text($q) {
    echo ($q["questionName"] . "<br><input type='text' name='$q[name]'><br>");
}

function question_radio($q) {
    $html = $q["questionName"] . "<br>";
    foreach ($q["choices"] as $i => $c) {
        $id = $q["name"] . "-$i";
        $html .= "<input type='radio' name='{$q["name"]}' value='{$c["value"]}' id='$id'>";
        $html .= "<label for='$id'>{$c["name"]}</label><br>";
    }
    echo $html;
}

function question_checkbox($q) {
    $html = $q["questionName"] . "<br>";
    foreach ($q["choices"] as $i => $c) {
        $id = $q["name"] . "-$i";
        $html .= "<input type='checkbox' name='{$q["name"]}[]' value='{$c["value"]}' id='$id'>";
        $html .= "<label for='$id'>{$c["name"]}</label>";
    }
    echo $html;
}

$question_handlers = [
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
];

$questions = new Questions();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<form method='POST' action='index.php'><ol>";
    foreach ($quiz as $q) {
        $name = $q["name"];
        $questionName = $q["questionName"];
        $questionType = $q["type"];
        $answer = $q["answer"];
        $questionScore = $q["score"];
        $choices = [];
        if ($questionType == "radio") {
            foreach ($q["choices"] as $choice) {
                $choices[$choice["value"]] = $choice["name"];
            }
        }
        $question = new Question($name, $questionName, $questionType, $answer, $choices, $questionScore);
        $questions->addQuestion($question);
        $question_handlers[$questionType]($q);
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
    $_SESSION['questions'] = serialize($questions); // Sérialisation explicite
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['questions'])) {
        $serializedQuestions = $_SESSION['questions'];
        if (is_string($serializedQuestions)) {
            $questions = unserialize($serializedQuestions);
            if ($questions instanceof Questions) {
                $answers = new Answers();
                $answers->checkAnswers($questions);
            } else {
                echo "Erreur : Les questions désérialisées ne sont pas valides.";
            }
        } else {
            echo "Erreur : Les données des questions sont corrompues.";
        }
    } else {
        echo "Erreur : Aucune question trouvée dans la session.";
    }
}

?>
