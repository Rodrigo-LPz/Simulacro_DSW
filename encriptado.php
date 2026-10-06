<?php
    $texto = "¡Programar en PHP es divertidísimo, Ñandú!";
    $k = 7;

    $alfabeto = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
    $longitudAlfabeto = strlen($alfabeto);

    // // Normalizar textos.
    // $textoNormalizado = $texto;
    // $textoNormalizado = str_replace('Á', 'A', $textoNormalizado);
    // $textoNormalizado = str_replace('É', 'E', $textoNormalizado);
    // $textoNormalizado = str_replace('Í', 'I', $textoNormalizado);
    // $textoNormalizado = str_replace('Ó', 'O', $textoNormalizado);
    // $textoNormalizado = str_replace('Ú', 'U', $textoNormalizado);
    // $textoNormalizado = str_replace('Ü', 'U', $textoNormalizado);
    // $textoNormalizado = str_replace('á', 'a', $textoNormalizado);
    // $textoNormalizado = str_replace('é', 'e', $textoNormalizado);
    // $textoNormalizado = str_replace('í', 'i', $textoNormalizado);
    // $textoNormalizado = str_replace('ó', 'o', $textoNormalizado);
    // $textoNormalizado = str_replace('ú', 'u', $textoNormalizado);
    // $textoNormalizado = str_replace('ü', 'u', $textoNormalizado);

    $vocales_tildes = 'ÁÉÍÓÚÜáéíóúü';
    $vocales_sinTildes = 'AEIOUaeiou';

    $textoNormalizado = $texto;
    for ($i = 0; $i < strlen($vocales_tildes); $i ++){ 
        $vocal_tilde = $vocales_tildes[i];
        $vocal_sinTilde = $vocales_sinTildes[$i];

        $textoNormalizado = str_replace($vocal_tilde, $vocal_sinTilde, $textoNormalizado);
    }


    // Normalizar el desplazamiento.
    $desplazamiento = $k % $longitudAlfabeto;

    if ($desplazamiento < 0){
        $desplazamiento += $longitudAlfabeto;
    }


    // Cifrar.
    $cifrado = '';

    for ($i = 0; $i < strlen($textoNormalizado); $i ++){ 
        $caracter = substr($textoNormalizado, $i, 1);
        $mayuscula = strtoupper($caracter);

        $posicion = strpos($alfabeto, $mayuscula);

        if ($posicion !== null){
            $nuevaPosicion = ($posicion + $desplazamiento) % $longitudAlfabeto;

            $nuevoCaracter = substr($alfabeto, $nuevaPosicion, 1);

            if ($caracter == strtolower($caracter)){
                $nuevoCaracter = strtolower($nuevoCaracter);
            }

            $cifrado .= $nuevoCaracter;
        } else{
            $cifrado .= $caracter;
        }
    }

    echo "La frase cifrada de \"{$texto}\" es la siguiente: \"{$cifrado}\"";


    // Cifrar.
    $descifrado = '';

    $desplazamientoDescifrado = $desplazamiento;

    for ($i = 0; $i < strlen($cifrado); $i ++){ 
        $caracter = substr($cifrado, $i, 1);
        $mayuscula = strtoupper($caracter);

        $posicion = strpos($alfabeto, $mayuscula);

        if ($posicion !== null){
            $nuevaPosicion = ($posicion + $desplazamientoDescifrado) % $longitudAlfabeto;

            $nuevoCaracter = substr($alfabeto, $nuevaPosicion, 1);

            if ($nuevaPosicion < 0){
                $nuevaPosicion += $longitudAlfabeto;
            }

            if ($caracter == strtolower($caracter)){
                $nuevoCaracter = mb_strtolower($nuevoCaracter,'UTF-8');
            }

            $descrifrado .= $nuevoCaracter;
        } else{
            $descifrado .= $caracter;
        }
    }

    echo "<br /> El texto, descifrado es: <b>{$descrifrado}</b>";