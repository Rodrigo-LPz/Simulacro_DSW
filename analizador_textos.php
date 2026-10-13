<?php
    $cadena = "Programar en PHP es divertido";
    
    // Caracteres.
    /**
     * $totalCaracteres = 0;
     * 
     * for ($letra = 0; $letra < strlen($cadena); $letra++){
     *     $totalCaracteres++;
     * }
     */
    $totalCaracteres = strlen($cadena);

    // Palabras.
    /**
     * $palabra = explode(" ", $cadena);
     * $totalPalabras = count($palabra);
     */
    $totalPalabras = str_word_count($cadena);

    // Primer carácter.
    /**
     * $primerCaracter = substr($cadena, 0, -28);
     */
    $primerCaracter = substr($cadena, 0, 1);

    // último carácter.
    /**
     * $ultimoCaracter = substr($cadena, 28);
     */
    $ultimoCaracter = substr($cadena, -1);

    // Trasposición de cadena.
    $cadenaInvertida = strrev($cadena);
    
    printf ("Resultado final:\n\t• Cantidad total de caracteres: %d\n\t\t◦ Cantidad total de palabras: %d\n\t• Primer carácter de la cadena: %s\n\t• Último carácter de la cadena: %s\n\t• Cadena de texto invertida: %s", $totalCaracteres, $totalPalabras, $primerCaracter, $ultimoCaracter, $cadenaInvertida);    