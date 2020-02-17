<?php

/**
 * Tester des variables dans un terminal
 * @param string $name -> Nom de la variable
 * @param mixed $var -> Valeur de la variable
 * @param mixed $line -> Ligne du test (__LINE__)
 */
function debug($name, $var, $line)
{
    $type = gettype($var);
    $start = "\n\e[1mLigne du test\t:\e[0m \e[31m$line\e[0m\n\n\e[1mVariable"
        . "\e[0m\n\t- \e[1mNom\t:\e[0m \e[34m$name\e[0m\n\t- \e[1mType\t:\e[0m"
        . " \e[4m$type\e[0m\n\t";

    if (is_array($var)) {
        echo "$start- \e[1mIndex\e[0m\n";

        foreach ($var as $key => $value) {
            $type_value = gettype($value);

            if ($value === true) {
                $value = "true";
            } elseif ($value === false) {
                $value = "false";
            } elseif ($value === null) {
                $value = "null";
            }

            echo "\t\t° \e[1mClé\e[0m : [\e[32m$key\e[0m] => \e[31m$value\e[0m"
                . "\t(type : \e[4m$type_value\e[0m)\n";
        }

        echo "\n";
    } else {
        echo "$start- \e[1mValeur:\e[0m \e[31m$var\e[0m\n\n";
    }
    die();
}

/**
 * Tester des variables dans une page web
 * @param string $name -> Nom de la variable
 * @param mixed $var -> Valeur de la variable
 * @param mixed $line -> Ligne du test (__LINE__)
 */
function debug_html($name, $var, $line)
{
    $type = gettype($var);
    $start = "<br /><pre><strong>Ligne du test :</strong> <span class='red'>"
        . "$line</span><br /><br /><strong>Variable</strong><ul><li><strong>"
        . "Nom :</strong><span class='blue'> $name</span></li><li><strong>"
        . "Type : </strong><span class='underline'>$type</span></li><li>"
        . "<strong>";

    if (is_array($var)) {
        echo "$start Index</strong></li><ul>";

        foreach ($var as $key => $value) {
            $type_value = gettype($value);

            if ($value === true) {
                $value = "true";
            } elseif ($value === false) {
                $value = "false";
            } elseif ($value === null) {
                $value = "null";
            }

            echo "<li><strong> Clé :</strong> [<span class='green'>$key</span>"
                . "] => <strong>Valeur :</strong> <span class='red'>$value"
                . "</span> (type : <span class='underline'>$type_value</span>)"
                . "</li>";
        }
        echo "</ul></ul></pre>";

    } else {
        echo "$start Valeur :</strong><span class='red'> $var</span></li></ul>"
            . "</pre><br /><br />";
    }
    echo "<style>.underline { text-decoration: underline; } "
        . ".blue { color: blue; } .red { color: red; } "
        . ".green { color: green; }</style>";

    die();
}
