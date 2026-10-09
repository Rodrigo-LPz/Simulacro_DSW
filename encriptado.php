<?php
    $cadena = "¡Programar en PHP es divertidísimo, Ñandú!";

    // Desplazamiento que se aplicará a cada letra del alfabeto.
    $k = 7;

    $alfabeto = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
    $longitudAlfabeto = mb_strlen($alfabeto, 'UTF-8');


    // Normalizar textos.
        // Se crea una copia de la cadena original que será normalizada.
    $cadenaNormalizada = $cadena;
    /**
     * $cadenaNormalizada = str_replace('Á', 'A', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('É', 'E', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('Í', 'I', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('Ó', 'O', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('Ú', 'U', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('Ü', 'U', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('á', 'a', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('é', 'e', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('í', 'i', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('ó', 'o', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('ú', 'u', $cadenaNormalizada);
     * $cadenaNormalizada = str_replace('ü', 'u', $cadenaNormalizada);
     */
    $vocalesConTildes = 'ÁÉÍÓÚÜáéíóúü';
    $vocalesSinTildes = 'AEIOUUaeiouu';

    // Recorre las vocales con signo de puntuación para sustituirlas por su equivalente sin puntuar.
    for ($i = 0; $i < mb_strlen($vocalesConTildes, 'UTF-8'); $i ++){
        // Obtiene la vocal con tilde correspondiente a la posición actual.
        $vocalConTilde = mb_substr($vocalesConTildes, $i, 1, 'UTF-8');

        // Obtiene la vocal sin tilde que ocupará la misma posición.
        $vocalSinTilde = mb_substr($vocalesSinTildes, $i, 1, 'UTF-8');

        // Sustituye todas las apariciones de la vocal con tilde por la vocal correspondiente sin tilde.
        $cadenaNormalizada = str_replace($vocalConTilde, $vocalSinTilde, $cadenaNormalizada);
    }


    // Normalizar el desplazamiento.
        // Calcula el desplazamiento equivalente dentro del tamaño del alfabeto mediante el resto de la división.
    $desplazamiento = $k % $longitudAlfabeto;

    // Condicional para comprobar/verificar que si el desplazamiento es negativo, se suma la longitud del alfabeto para obtener un desplazamiento equivalente positivo.
    if ($desplazamiento < 0){
        $desplazamiento += $longitudAlfabeto;
    }


    // Cifrar.
        // Variable donde se almacenará la cadena cifrada.
    $cifrado = '';

    // Recorre todos los caracteres de la cadena normalizada.
    for ($i = 0; $i < mb_strlen($cadenaNormalizada, 'UTF-8'); $i ++){
        // Obtiene el carácter que corresponde a la posición actual.
        $caracter = mb_substr($cadenaNormalizada, $i, 1, 'UTF-8');

        // Convierte temporalmente el carácter a mayúscula para poder buscarlo dentro del alfabeto.
        $mayuscula = mb_strtoupper($caracter, 'UTF-8');

        // Busca la posición que ocupa el carácter dentro del alfabeto (si no se encuentra, devuelve "false").
        $posicion = mb_strpos($alfabeto, $mayuscula, 0, 'UTF-8');

        // Condicional para comprobar/verificar que el carácter realmente pertenece al alfabeto.
        if ($posicion !== false){
            // Calcula la nueva posición del carácter sumando el desplazamiento.
            $nuevaPosicion = ($posicion + $desplazamiento) % $longitudAlfabeto;

            // Obtiene del alfabeto el carácter correspondiente a la nueva posición.
            $nuevoCaracter = mb_substr($alfabeto, $nuevaPosicion, 1, 'UTF-8');

            // Condicional para comprobar/verificar si el carácter original estaba escrito en minúscula.
            if ($caracter == mb_strtolower($caracter, 'UTF-8')){
                $nuevoCaracter = mb_strtolower($nuevoCaracter, 'UTF-8');
            }

            // Añade el nuevo carácter a la cadena cifrada.
            $cifrado .= $nuevoCaracter;
        } else{
            // Si el carácter no pertenece al alfabeto, se mantiene sin cambios (espacios, números, signos de puntuación, etc.).
            $cifrado .= $caracter;
        }
    }


    // Descifrar.
        // Variable donde se almacenará la cadena cifrada.
    $descifrado = '';

    // Se utiliza el mismo desplazamiento que en el bloque de código "Cifrar".
    $desplazamientoDescifrado = $desplazamiento;

    // Recorre todos los caracteres de la cadena cifrada.
    for ($i = 0; $i < mb_strlen($cifrado, 'UTF-8'); $i ++){
        // Obtiene el carácter que corresponde a la posición actual.
        $caracter = mb_substr($cifrado, $i, 1, 'UTF-8');

        // Convierte temporalmente el carácter a mayúscula para poder buscarlo dentro del alfabeto.
        $mayuscula = mb_strtoupper($caracter, 'UTF-8');

        // Busca la posición que ocupa el carácter cifrado dentro del alfabeto.
        $posicion = mb_strpos($alfabeto, $mayuscula, 0, 'UTF-8');

        // Condicional para comprobar/verificar que el carácter realmente pertenece al alfabeto.
        if ($posicion !== false){
            // Para descifrar se realiza el desplazamiento contrario al utilizado durante el bloque de código "Cifrar".
            $nuevaPosicion = ($posicion - $desplazamientoDescifrado) % $longitudAlfabeto;

            // Condicional para comprobar/verificar si el resultado de la nueva posición es negativo, se suma la longitud del alfabeto para obtener un desplazamiento equivalente positivo.
            if ($nuevaPosicion < 0){
                $nuevaPosicion += $longitudAlfabeto;
            }

            // Obtiene del alfabeto el carácter correspondiente a la nueva posición.
            $nuevoCaracter = mb_substr($alfabeto, $nuevaPosicion, 1, 'UTF-8');

            // Condicional para comprobar/verificar si el carácter original estaba escrito en minúscula.
            if ($caracter == mb_strtolower($caracter, 'UTF-8')){
                $nuevoCaracter = mb_strtolower($nuevoCaracter,'UTF-8');
            }

            // Añade el nuevo carácter a la cadena descifrada.
            $descifrado .= $nuevoCaracter;
        } else{
            // Si el carácter no pertenece al alfabeto, se mantiene sin cambios.
            $descifrado .= $caracter;
        }
    }

    echo "• Cadena de texto original: {$cadena}.\n• Cadena de texto normalizada: {$cadenaNormalizada}.\n• Cadena de texto cifrada (donde el desplazamiento 'k' es igual a {$k}): {$cifrado}.\n• Cadena de texto descifrada: {$descifrado}";