<?php

namespace Website\controllers;

use \Exception;

//use \PDOException;
//use models\PlayerModel;
//use models\AdminModel;
//use \DateTime;

class UserController
{
    //private PlayerModel $mdPlayer;
    //private AdminModel $mdAdministrator;
    private $twig;
    private $vues;

    function __construct()
    {
        global $vues, $twig;
        session_start();
        try {
            $this->twig = $twig;
            $this->vues = $vues;

            //$this->mdPlayer = new PlayerModel();
            //$this->mdAdministrator = new ModelAdministrator();
        } catch (PDOException $e) {
            $dVueErreur[] = "Unexpected error";
            require(__DIR__.'/../templates/error.twig');
        } catch (Exception $e2) {
            // $dataVueEreur[] = "Erreur inattendue!!! ";
            // require ($rep.$vues['erreur']);
        }
    }

    function home()
    {
        echo $this->twig->render($this->vues["home"], [
            'idPlayerConnected' => $_SESSION["idPlayerConnected"]
        ]);
    }

    function error()
    {
        echo $this->twig->render($this->vues["error"]);
    }

    function themeChoice()
    {
        $chapters = array();
        $chapters = $this->mdChapter->getChapters();
        echo $this->twig->render($this->vues["themeChoice"], [
            'chapters' => $chapters,
        ]);
    }

    function singleplayer()
    {
        echo $this->twig->render($this->vues["singleplayer"]);
    }

    function multiplayer()
    {
        echo $this->twig->render($this->vues["multiplayer"]);
    }

    function loginAdmin()
    {
        if ($_SESSION["idAdminConnected"] != null) {
            $this->launchBlazor();
        }

        echo $this->twig->render($this->vues["loginAdmin"], [
            'error' => $_SESSION["error"],
        ]);

        $_SESSION["error"] = "";
    }

    function loginPlayer()
    {
        if ($_SESSION["idPlayerConnected"] != null) {
            header("Location:/userStatus");
        }

        echo $this->twig->render($this->vues["loginPlayer"], [
            'error' => $_SESSION["error"],
        ]);

        $_SESSION["error"] = "";
    }

    function userStatus()
    {
        if ($_SESSION["idPlayerConnected"] != null) {
            $this->mdPlayer = new PlayerModel();
            $player = $this->mdPlayer->getPlayerByID($_SESSION["idPlayerConnected"]);
            $maxscores = $this->mdPlayer->getMaxScoresWithChapter($player);
            //foreach ($maxscores as &$maxscore) {
            //    $maxscore["chapter"] = $this->mdChapter->getChapterByID($maxscore["idchapter"])->getName();
            //}
            echo $this->twig->render(
                $this->vues["userStatus"],
                [
                    'player' => $player,
                    //'maxscores' => $maxscores,
                    'error' => $_SESSION["error"],
                ]
            );
            $_SESSION["error"]=null;
        } else {
            header("Location:/loginPlayer");
        }
    }

    function verifyAdmin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $Administrator = [
            'username' => $username,
            'password' => $password,
        ];

        $AdministratorIsOk = $this->mdAdministrator->verifyAdministrator($Administrator);
        if ($AdministratorIsOk != null) {
            $_SESSION["idAdminConnected"] = $AdministratorIsOk;
            $this->launchBlazor();

        } else {
            $_SESSION["error"] = "utilisateur introuvable.";
            header("Location:/loginAdmin");
        }
    }

    function verifyPlayer()
    {
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];

        $Player = [
            'nickname' => $nickname,
            'password' => $password,
        ];

        $PlayerIsOk = $this->mdPlayer->verifyPlayer($Player);
        if ($PlayerIsOk != null) {
            $_SESSION["idPlayerConnected"] = $PlayerIsOk;
            header("Location:/userStatus");
        } else {
            $_SESSION["error"] = "utilisateur introuvable.";
            header("Location:/loginPlayer");
        }
    }

    function verifySingleplayer()
    {
        $_SESSION["Score"] = 0;
        $difficulty = $_POST['difficulty'];
        $chapter = $_POST['chapter'];
        $_SESSION['idChapter'] = $_POST['chapter'];

        $difficultyIsOk = TRUE;
        $chapterIsOk = TRUE;
        if (!($difficulty == 1 or $difficulty == 2 or $difficulty == 3)) {
            $difficultyIsOk = FALSE;
        }

        if ($this->mdChapter->verifyChapter($chapter) == NULL) {
            $chapterIsOk = FALSE;
        }

        if ($difficultyIsOk and $chapterIsOk) {
            $_SESSION["PrevTime"] = new DateTime('now');
            $_SESSION["Questions"] = $this->mdQuestion->getQuestionsByChapterAndDifficulty($chapter, $difficulty);
            $_SESSION["Answers"] = array();
            foreach ($_SESSION["Questions"] as $question) {
                $answers = $this->mdAnswer->getAnswersByIDQuestions($question->getId());
                $_SESSION["Answers"][] = $answers;
            }
            echo $this->twig->render($this->vues["singleplayer"], [
                'questions' => $_SESSION["Questions"],
                'numQuestion' => 0,
                'answerss' => $_SESSION["Answers"],
            ]);
        } else {
            $chapters = $this->mdChapter->getChapters();
            $_SESSION["error"] = "Valeur de choix de thème invalide";
            echo $this->twig->render($this->vues["themeChoice"], [
                'error' => $_SESSION["error"],
                'chapters' => $chapters,
            ]);
            $_SESSION["error"] = "";
        }
    }

    function verifQuestion()
        //Only Handdle solo game
    {
        $_SESSION["CurrTime"] = new DateTime('now');
        $answerNumber = $_POST["answer"];
        $numQuestion = $_POST["numQuestion"];
        if (!($answerNumber == 1 or $answerNumber == 2 or $answerNumber == 3 or $answerNumber == 4)) {
            $_SESSION["error"] = "Valeur de choix de réponse invalide";
            echo $this->twig->render($this->vues["singleplayer"], [
                'questions' => $_SESSION["Questions"],
                'numQuestion' => $numQuestion,
                'answerss' => $_SESSION["Answers"],
                'error' => $_SESSION["error"],
            ]);
            $_SESSION["error"] = "";
        } else {
            $answerNumber = $answerNumber - 1;
            $answerContent = $_SESSION["Answers"][$numQuestion][$answerNumber]->getContent();
            $_SESSION["playerAnswersContent"][$numQuestion] = $answerContent;
            if ($_SESSION["Questions"][$numQuestion]->getIdAnswerGood() == $_SESSION["Answers"][$numQuestion][$answerNumber]->getId()) {
                $time = $_SESSION["PrevTime"]->diff($_SESSION["CurrTime"]);
                $_SESSION["Score"] = $_SESSION["Score"] + 80 + 40 * ((30 - $time->s) / 100 * 10 / 3);
                if ($_SESSION["Questions"][$numQuestion]->getDifficulty() > 1) {
                    $_SESSION["Questions"][$numQuestion]->setDifficulty($_SESSION["Questions"][$numQuestion]->getDifficulty() - 1);
                    $this->mdQuestion->updateDifficulty($_SESSION["Questions"][$numQuestion]);
                }
            } else {
                $_SESSION["Questions"][$numQuestion]->setNbFails($_SESSION["Questions"][$numQuestion]->getNbFails() + 1);
                $this->mdQuestion->updateNbFails($_SESSION["Questions"][$numQuestion]);
            }

            if ($_SESSION["Questions"][$numQuestion]->getNbFails() >= 25) {
                if ($_SESSION["Questions"][$numQuestion]->getDifficulty() < 3) {
                    $_SESSION["Questions"][$numQuestion]->setDifficulty($_SESSION["Questions"][$numQuestion]->getDifficulty() + 1);
                }
                $_SESSION["Questions"][$numQuestion]->setNbFails(0);
                $this->mdQuestion->updateDifficulty($_SESSION["Questions"][$numQuestion]);
                $this->mdQuestion->updateNbFails($_SESSION["Questions"][$numQuestion]);
            }

            if ($numQuestion <= 8) {
                $_SESSION["PrevTime"] = $_SESSION["CurrTime"];
                echo $this->twig->render($this->vues["singleplayer"], [
                    'questions' => $_SESSION["Questions"],
                    'numQuestion' => $numQuestion + 1,
                    'answerss' => $_SESSION["Answers"],
                ]);
            } else {
                $Final = array();
                $Final[]["Question"] = array();
                $Final[]["goodAnswer"] = array();
                $Final[]["PlayerAnswer"] = array();
                $c = 0;
                foreach ($_SESSION["Questions"] as &$question) {
                    $answer = $this->mdAnswer->getAnswerByID($question->getIdAnswerGood());
                    $Final[$c]["goodAnswer"] = $answer->getContent();
                    $c = $c + 1;
                }
                $c = 0;
                foreach ($_SESSION["Questions"] as $question) {
                    $Final[$c]["Question"] = $question->getContent();
                    $c = $c + 1;
                }
                $c = 0;
                foreach ($_SESSION["playerAnswersContent"] as $answer) {
                    $Final[$c]["PlayerAnswer"] = $answer;
                    $c = $c + 1;
                }

                $jouer = [
                    'idchapter' => $_SESSION["idChapter"],
                    'idplayer' => $_SESSION["idPlayerConnected"],
                    'maxscore' => $_SESSION["Score"]
                ];

                if($_SESSION["idPlayerConnected"] != null){
                    if ($this->mdPlayer->verifyJouer($jouer) == null) {
                        $this->mdPlayer->addJouer($jouer);
                    } else if ($jouer['maxscore'] <= $this->mdPlayer->getMaxScoreByPlayerAndChapter($jouer)) {
                        $this->mdPlayer->updateJouer($jouer);
                    }
                }

                echo $this->twig->render($this->vues["viewScore"], [
                    'score' => (int) $_SESSION["Score"],
                    'Final' => $Final,
                ]);
            }
        }
    }

    function passer()
    {
        $numQuestion = $_POST["numQuestion"];
        $_SESSION["playerAnswersContent"][$numQuestion] = "Pas de réponse";
        $_SESSION["Questions"][$numQuestion]->setNbFails($_SESSION["Questions"][$numQuestion]->getNbFails() + 1);
        if ($numQuestion <= 8) {
            $_SESSION["PrevTime"] = $_SESSION["CurrTime"];
            echo $this->twig->render($this->vues["singleplayer"], [
                'questions' => $_SESSION["Questions"],
                'numQuestion' => $numQuestion + 1,
                'answerss' => $_SESSION["Answers"],
            ]);
        } else {
            $Final = array();
            $Final[]["Question"] = array();
            $Final[]["goodAnswer"] = array();
            $Final[]["PlayerAnswer"] = array();
            $c = 0;
            foreach ($_SESSION["Questions"] as &$question) {
                $answer = $this->mdAnswer->getAnswerByID($question->getIdAnswerGood());
                $Final[$c]["goodAnswer"] = $answer->getContent();
                $c = $c + 1;
            }
            $c = 0;
            foreach ($_SESSION["Questions"] as $question) {
                $Final[$c]["Question"] = $question->getContent();
                $c = $c + 1;
            }
            $c = 0;
            foreach ($_SESSION["playerAnswersContent"] as $answer) {
                $Final[$c]["PlayerAnswer"] = $answer;
                $c = $c + 1;
            }
            $_SESSION["Score"] = (int) $_SESSION["Score"];

            $jouer = [
                'idchapter' => $_SESSION["idChapter"],
                'idplayer' => $_SESSION["idPlayerConnected"],
                'maxscore' => $_SESSION["Score"]
            ];

            if($_SESSION["idPlayerConnected"] != null){
                if ($this->mdPlayer->verifyJouer($jouer) == null) {
                    $this->mdPlayer->addJouer($jouer);
                } else if ($jouer['maxscore'] <= $this->mdPlayer->getMaxScoreByPlayerAndChapter($jouer)) {
                    $this->mdPlayer->updateJouer($jouer);
                }
            }

            echo $this->twig->render($this->vues["viewScore"], [
                'score' => $_SESSION["Score"],
                'Final' => $Final,
            ]);
        }
    }
}
