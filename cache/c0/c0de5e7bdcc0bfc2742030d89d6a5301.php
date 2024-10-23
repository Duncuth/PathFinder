<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* vuephp1.html */
class __TwigTemplate_603811847beb521678db1b353459a9b0 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
  <head>
    <meta charset=\"UTF-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    <title>Personne - formulaire</title>
    <script type=\"text/javascript\">
      function clearForm(oForm) {
        const elements = oForm.elements;
        oForm.reset();

        for (i = 0; i < elements.length; i++) {
          field_type = elements[i].type.toLowerCase();

          switch (field_type) {
            case \"text\":
            case \"password\":
            case \"textarea\":
            case \"hidden\":
              elements[i].value = \"\";
              break;

            case \"radio\":
            case \"checkbox\":
              if (elements[i].checked) {
                elements[i].checked = false;
              }
              break;

            case \"select-one\":
            case \"select-multi\":
              elements[i].selectedIndex = -1;
              break;

            default:
              break;
          }
        }
      }
    </script>
  </head>

  <body>
    <!-- on vérifie les données provenant du modèle -->
    ";
        // line 45
        if (array_key_exists("dVue", $context)) {
            // line 46
            yield "      <div align=\"center\">
        ";
            // line 47
            if ((array_key_exists("dVueEreur", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["dVueEreur"] ?? null)) > 0))) {
                // line 48
                yield "          <h2>ERREUR !!!!!</h2>
          ";
                // line 49
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["dVueEreur"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                    // line 50
                    yield "            <p>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
                    yield "</p>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['value'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 52
                yield "        ";
            }
            // line 53
            yield "
        <h2>Personne - formulaire</h2>
        <hr />
        <!-- affichage de données provenant du modèle -->
        ";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["dVue"] ?? null), "data", [], "any", false, false, false, 57), "html", null, true);
            yield "

        <form method=\"post\" name=\"myform\" id=\"myform\">
          <table>
            <tr>
              <td>Nom</td>
              <td>
                <input name=\"txtNom\" value=\"";
            // line 64
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["dVue"] ?? null), "nom", [], "any", false, false, false, 64), "html", null, true);
            yield "\" type=\"text\" size=\"20\" />
              </td>
            </tr>
            <tr>
              <td>Age</td>
              <td>
                <input
                  name=\"txtAge\"
                  value=\"";
            // line 72
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["dVue"] ?? null), "age", [], "any", false, false, false, 72), "html", null, true);
            yield "\"
                  type=\"text\"
                  size=\"3\"
                  required
                />
              </td>
            </tr>
            <tr></tr>
          </table>
          <table>
            <tr>
              <td><input type=\"submit\" value=\"Envoyer\" /></td>
              <td><input type=\"reset\" value=\"Rétablir\" /></td>
              <td>
                <input
                  type=\"button\"
                  value=\"Effacer\"
                  onclick=\"clearForm(this.form);\"
                />
              </td>
            </tr>
          </table>
          <!-- action !!!!!!!!!! -->
          <input type=\"hidden\" name=\"action\" value=\"validationFormulaire\" />
        </form>
      </div>
    ";
        } else {
            // line 99
            yield "      <p>Erreur !!<br />utilisation anormale de la vuephp</p>
    ";
        }
        // line 101
        yield "    <p>
      Essayez de mettre du code html dans nom -> Correspond à une attaque de type injection
    </p>
  </body>
</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "vuephp1.html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  175 => 101,  171 => 99,  141 => 72,  130 => 64,  120 => 57,  114 => 53,  111 => 52,  102 => 50,  98 => 49,  95 => 48,  93 => 47,  90 => 46,  88 => 45,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "vuephp1.html", "/home/www/tobiard/public_html/PathFinder/templates/vuephp1.html");
    }
}
