<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* vuephp1.html */
class __TwigTemplate_2ce784f5b9085065b66af58be97997ff169e0f0d71d95a1d280acea4a24fd4e6 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<html>
<head><title>Personne - formulaire</title>

<script type=\"text/javascript\">
function clearForm(oForm) {
    
  var elements = oForm.elements; 
    
  oForm.reset();

  for(i=0; i<elements.length; i++) {
      
\tfield_type = elements[i].type.toLowerCase();
\t
\tswitch(field_type) {
\t
\t\tcase \"text\": 
\t\tcase \"password\": 
\t\tcase \"textarea\":
\t        case \"hidden\":\t
\t\t\t
\t\t\telements[i].value = \"\"; 
\t\t\tbreak;
        
\t\tcase \"radio\":
\t\tcase \"checkbox\":
  \t\t\tif (elements[i].checked) {
   \t\t\t\telements[i].checked = false; 
\t\t\t}
\t\t\tbreak;

\t\tcase \"select-one\":
\t\tcase \"select-multi\":
            \t\telements[i].selectedIndex = -1;
\t\t\tbreak;

\t\tdefault: 
\t\t\tbreak;
\t}
    }
}

</script>
</head>

<body>


// on vérifie les données provenant du modèle
";
        // line 50
        if (array_key_exists("dVue", $context)) {
            // line 51
            echo "<div align=\"center\">


 ";
            // line 54
            if ((array_key_exists("dVueEreur", $context) && (twig_length_filter($this->env, ($context["dVueEreur"] ?? null)) > 0))) {
                // line 55
                echo " <h2>ERREUR !!!!!</h2>
 ";
                // line 56
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["dVueEreur"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                    // line 57
                    echo " ";
                    echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                    echo "<br>
 ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 59
                echo " ";
            }
            // line 60
            echo "
<h2>Personne - formulaire</h2>
<hr>

<!-- affichage de données provenant du modèle --> 
";
            // line 65
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["dVue"] ?? null), "data", [], "any", false, false, false, 65), "html", null, true);
            echo "


<form method=\"post\" name=\"myform\" id=\"myform\">
<table> <tr>
<td>Nom</td>
<td><input name=\"txtNom\" value=\"";
            // line 71
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["dVue"] ?? null), "nom", [], "any", false, false, false, 71), "html", null, true);
            echo "\" type=\"text\" size=\"20\"></td>
 </tr>
<tr><td>Age</td>
<td><input name=\"txtAge\" value=\"";
            // line 74
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["dVue"] ?? null), "age", [], "any", false, false, false, 74), "html", null, true);
            echo "\" type=\"text\" size=\"3\" required></td>
</tr>
<tr>
</table>
<table> <tr>
<td><input type=\"submit\" value=\"Envoyer\"></td>
<td><input type=\"reset\" value=\"Rétablir\"></td>
<td><input type=\"button\" value=\"Effacer\" onclick=\"clearForm(this.form);\">
</td> </tr> </table>

<!-- action !!!!!!!!!! --> 
<input type=\"hidden\" name=\"action\" value=\"validationFormulaire\">
</form></div>

";
        } else {
            // line 89
            echo "erreur !!<br>
utilisation anormale de la vuephp
";
        }
        // line 92
        echo "
<p>Essayez de mettre du code html dans nom -> Correspond à une attaque de type injection</p>
</body> </html> ";
    }

    public function getTemplateName()
    {
        return "vuephp1.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  161 => 92,  156 => 89,  138 => 74,  132 => 71,  123 => 65,  116 => 60,  113 => 59,  104 => 57,  100 => 56,  97 => 55,  95 => 54,  90 => 51,  88 => 50,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "vuephp1.html", "/Applications/MAMP/htdocs/phptwig/templates/vuephp1.html");
    }
}
