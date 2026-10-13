<?php
    // Activa el tipado estricto (se usa para que los parametros declarados en las funciones y los valores retornados coincidan con el tipo declarado).
    declare(strict_types = 1);


    // <========== Declarantes ==========>

    const longitudNombreMinima = 5;

    // Mensaje para saludo o error.
    $mensaje = "";

    // Indica si el mensaje es un error.
    $esError = true;


    // <========== Validaciones ==========>

    // Comprueba si un texto está o no vacío.
    function campoVacio(string $texto): bool{
        if ($nombre === ""){
            $mensaje = "ERROR: El campo \"Nombre\" está incompleto o vacío.\nPor favor, revise, todos los campos del formulario deben estar rellenos, no pueden estar vacíos.";
            return true;

        } else return false;

        if ($edad === ""){
            $mensaje = "ERROR: El campo \"Edad\" está incompleto o vacío.\nPor favor, revise, todos los campos del formulario deben estar rellenos, no pueden estar vacíos.";
            return true;

        } else return false;

        if ($email === ""){
            $mensaje = "ERROR: El campo \"Correo electrónico / E-mail\" está incompleto o vacío.\nPor favor, revise, todos los campos del formulario deben estar rellenos, no pueden estar vacíos.";
            return true;

        } else return false;
    }

    // Comprueba si un texto contiene únicamente letras (incluidas las acentuadas, la "ñ" y la "ü") y espacios.
    function soloLetras(string $texto): bool{
        // Caracteres permitidos (solo en minúscula: el texto se pasa a minúsculas antes de comprobarlo).
        $permitidos = "aábcdeéfghiíjklmnñoópqrstuúüvwxyz ";

        // Bucle para recorrer cada uno de los caracteres del texto.
            // "mb_str_split" separa el texto en un array de caracteres.
        foreach (mb_str_split(mb_strtolower($texto)) as $caracter){
            // Si el carácter actual no está en la lista de permitidos, el texto no es válido (se deja de comprobar).
            if (!str_contains($permitidos, $caracter)) return false;
        }

        return true;
    }

    // Comprueba si un texto contiene únicamente letras (incluidas las acentuadas, la "ñ" y la "ü") y espacios.
    function soloNumeros(int $texto): bool{
        // Caracteres permitidos (solo en minúscula: el texto se pasa a minúsculas antes de comprobarlo).
        $permitidos = "0123456789";

        // Bucle para recorrer cada uno de los caracteres del texto.
            // "mb_str_split" separa el texto en un array de caracteres.
        foreach (mb_str_split($texto) as $caracter){
            // Si el carácter actual no está en la lista de permitidos, el texto no es válido (se deja de comprobar).
            if (!str_contains($permitidos, $caracter)) return false;
        }

        return true;
    }

    // Comprueba si un texto contiene únicamente letras (incluidas las acentuadas, la "ñ" y la "ü") y espacios.
    function email (string $texto): bool{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true /* echo "Email válido" */;
        else return false /* echo "Email inválido" */;
    }


    // <========== Main ==========>

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
        $edad = trim($_POST["edad"] ?? "");
        $email = trim($_POST["email"] ?? "");

        if (campoVacio($nombre) || campoVacio($edad) || campoVacio($email)){
            echo $mensaje;
            
        } elseif (!soloLetras($nombre)){
            $mensaje = "ERROR: El nombre solo puede contener letras y espacios.";
            
        } elseif (!soloNumeros($edad)){
            $mensaje = "ERROR: La edad solo puede contener números.";
            
        } elseif (!email($email)){
            $mensaje = "ERROR: El valor introducido en el campo \"Correo electrónico / E-mail\" no es el esperado, no tiene un formato válido.";

        } else{
            // "htmlspecialchars" convierte los caracteres especiales de HTML (como "<" o ">") en texto normal, para que el usuario no pueda inyectar código en la página.
            $mensaje = "¡Hola, " . htmlspecialchars($nombre) . "!\nTienes " . htmlspecialchars($edad) . "años\nY tu correo electrónico es " . htmlspecialchars($email) . ".";
            $esError = false;
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario Personal</title>

        <!-- Bootstrap
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
        <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
        -->

        <!-- CSS ("../" sube un nivel: de la carpeta "PHP" a la carpeta principal, y desde ahí entra en "CSS"). -->
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