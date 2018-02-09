<?php

    $contenido = 'Aqui iria el contenido {jForm opt1="hola" opt2="test"} de prueba {jForm test} test.';

    $regex = '/{jForm\s(.*?)}/i';

    preg_match_all($regex, $contenido, $matches, PREG_SET_ORDER);

    if ($matches)
    {
        foreach ($matches as $match)
        {
            $matcheslist = explode(',', $match[1]);

            // We may not have a module style so fall back to the plugin default.
            if (!array_key_exists(1, $matcheslist))
            {
                $matcheslist[1] = $style;
            }

            $position = trim($matcheslist[0]);

            echo $position;

        }
    } else {

        echo "NAA";

    }

?>