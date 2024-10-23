<?php
namespace controleur;

class Controleur
{
    public function __construct()
    {
        global $twig; // nécessaire pour utiliser variables globales
        // on démarre ou reprend la session pas utilisée ici
        session_start();

        //debut

        //on initialise un tableau d'erreur
        $dVueEreur = [];

        try {
            $action = $_REQUEST['action'] ?? null;

            switch($action) {
                //pas d'action, on réinitialise 1er appel
                case null:
                    $this->Reinit();
                    break;

                case 'validationFormulaire':
                    $this->ValidationFormulaire($dVueEreur);
                    break;

                    //mauvaise action
                default:
                    $dVueEreur[] = "Erreur d'appel php";
                    echo $twig->render('vuephp1.html', ['dVueEreur' => $dVueEreur]);
                    break;
            }
        } catch (\PDOException $e) {
            //si erreur BD, pas le cas ici
            $dVueEreur[] = 'Erreur inattendue!!! ';
        } catch (\Exception $e2) {
            $dVueEreur[] = 'Erreur inattendue!!! ';
            echo $twig->render('erreur.html', ['dVueEreur' => $dVueEreur]);
        }

        //fin
        exit(0);
    }//fin constructeur

    public function Reinit()
    {
        global $twig; // nécessaire pour utiliser variables globales

        $dVue = [
            'nom' => '',
            'age' => 0,
        ];
        echo $twig->render('vuephp1.html', [
            'dVue' => $dVue
        ]);
    }

    public function ValidationFormulaire(array $dVueEreur)
    {
        global $twig; // nécessaire pour utiliser variables globales

        //si exception, ca remonte !!!
        $nom = $_POST['txtNom']; // txtNom = nom du champ texte dans le formulaire
        $age = $_POST['txtAge'];
        \config\Validation::val_form($nom, $age, $dVueEreur);

        $model = new \modeles\Simplemodel();
        $data  = $model->get_data();

        $dVue = [
            'nom'  => $nom,
            'age'  => $age,
            'data' => $data,
        ];

        echo $twig->render('vuephp1.html', ['dVue' => $dVue, 'dVueEreur' => $dVueEreur]);
    }
}//fin class
