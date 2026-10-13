<?php
    // Activa el tipado estricto (se usa para que los parametros declarados en las funciones y los valores retornados coincidan con el tipo declarado).
    declare(strict_types = 1);

    const longitudNombreMinima = 5;

    // Mensaje para saludo o error.
    $mensaje = "";

    // Indica si el mensaje es un error.
    $esError = true;

    // Comprueba si un texto contiene únicamente letras (incluidas las acentuadas, la "ñ" y la "ü") y espacios.
    function soloLetras(string $texto): bool{
        // Caracteres permitidos (solo en minúscula: el texto se pasa a minúsculas antes de comprobarlo).
        $permitidos = "aábcdeéfghiíjklmnñoópqrstuúüvwxyz ";

        //$texto = mb_strtolower($texto);

        // Bucle para recorrer cada uno de los caracteres del texto.
            // "mb_str_split" separa el texto en un array de caracteres.
        foreach (mb_str_split(mb_strtolower($texto)) as $caracter){
            // Si el carácter actual no está en la lista de permitidos, el texto no es válido (se deja de comprobar).
            if (!str_contains($permitidos, $caracter)) return false;
        }

        return true;
    }

    // Condicional para comprobar que se ha llegado a esta página enviando/a través del formulario (y no escribiendo la dirección URL en el navegador).
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        $mensaje = "ERROR: Debes enviar el formulario para ver el resultado del saludo.";

    } else{
        // Normaliza la entrada recogiendo el valor enviado al formulario y eliminando espacios.
            /**
             * "??" evita el aviso si el campo no ha llegado.
             * " ?? "" " significa que si "$_POST["nombre"]" no existe, usa en su lugar " "" " (texto vacío) como valor a poner.
             */
        $nombre = trim($_POST["nombre"] ?? "");

        if ($nombre === ""){
            $mensaje = "ERROR: El nombre no puede estar vacío.";
            
        } elseif (!soloLetras($nombre)){
            $mensaje = "ERROR: El nombre solo puede contener letras y espacios.";
            
        } elseif (mb_strlen($nombre) < longitudNombreMinima){
            $mensaje = "ERROR: El nombre debe tener al menos " . longitudNombreMinima . " caracteres.";

        } else{
            // "htmlspecialchars" convierte los caracteres especiales de HTML (como "<" o ">") en texto normal, para que el usuario no pueda inyectar código en la página.
            $mensaje = "¡Hola, " . htmlspecialchars($nombre) . "!";
            $esError = false;
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Nombres</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="../CSS/style.css">
    </head>
    <body>
        <header></header>
        <main>
            <!-- Muestra el mensaje (el saludo o el error). -->
            <p class="<?= $esError ? "error" : "saludo" ?>"><?= $mensaje ?></p>

            <!-- Enlace para volver al formulario ("../" sube a la carpeta principal, donde está "index.html"). -->
            <a href="../index.html">Volver al formulario</a>
        </main>
        <footer></footer>
    </body>
</html>

<!-- php -S localhost:8080 -->
