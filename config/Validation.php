<?php
namespace config;

class Validation
{
    public static function val_action($action)
    {
        if (!isset($action)) {
            throw new \Exception('pas d\'action');
            //on pourrait aussi utiliser
            //$action = $_GET['action'] ?? 'no';
            // This is equivalent to:
            //$action =  if (isset($_GET['action'])) $action=$_GET['action']  else $action='no';
        }
    }

    public static function val_form(string &$nom, string &$age, &$dVueEreur)
    {
        if (!isset($nom) || $nom == '') {
            $dVueEreur[] = 'pas de nom';
            $nom         = '';
        }

        if (strlen(htmlspecialchars($nom, ENT_QUOTES) === 0)) {
            $dVueEreur[] = "testative d'injection de code (attaque sécurité)";
            $nom         = '';
        }

        if (!isset($age) || $age == '' || !filter_var($age, FILTER_VALIDATE_INT)) {
            $dVueEreur[] = "pas d'age ";
            $age         = 0;
        }
    }
}
