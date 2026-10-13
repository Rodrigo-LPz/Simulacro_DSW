<?php
    $cadena = "Programar en PHP es divertido";
    $cadenaNueva = strtolower($cadena);

    $vocales = ['a', 'e', 'i', 'o', 'u'];

    $totalLetras = 0;
    $totalvocales = 0;

    for ($letra = 0; $letra < strlen($cadenaNueva); $letra++){
        $totalLetras++;

        if (in_array($cadenaNueva[$letra], $vocales)){
            $totalvocales++;
        }
    }
    
    printf ("Resultado final:\n\t• Total de caracteres: %d\n\t\t- Cantidad total de vocales: %d ", $totalLetras, $totalvocales);