<?php
    // Activa el tipado estricto (se usa para que los parametros declarados en las funciones y los valores retornados coincidan con el tipo declarado).
    declare(strict_types = 1);


    // <========== Variables ==========>

    // Mensaje para saludo o error.
    $mensaje = "";

    // Indica si el mensaje es un error.
    $esError = true;


    // <========== Constantes ==========>

    const longitudNombreMaxima = 100;

    const edadMinima = 0, edadMaxima = 123;


    // <========== Validaciones ==========>
    // Cuenta los caracteres de un texto.
    function longitudTexto(string $texto): int{ return mb_strlen($texto); }

    // Comprueba si un texto está o no vacío.
    function campoVacio(string $texto): bool{ return $texto === ""; }

    // Comprueba si un texto contiene únicamente letras (incluidas las acentuadas, las que tienen diéresis ("ü") y la "ñ") y espacios.
    function soloLetras(string $texto): bool{
        $permitidos =
            [
                "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "Ñ", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
                "á",                "é",                "í",                               "ó",                          "ú", "ü",
                "Á",                "É",                "Í",                               "Ó",                          "Ú", "Ü",
                " "
            ];

        /**
         * if (str_replace($permitidos, "", $texto) === "") return true;
         * else return false;
         */
        // Borra del texto todos los caracteres permitidos: si no queda nada, es que todos lo eran.
        return str_replace($permitidos, "", $texto) === "";

        return true;
    }

    // Comprueba si un texto contiene únicamente números (dígitos del 0 al 9).
    function soloNumeros(string $texto): bool{
        $permitidos = "0123456789";

        // Bucle para recorrer cada uno de los caracteres del texto.
            // "mb_str_split" separa el texto en un array de caracteres.
        foreach (str_split($texto) as $caracter){ /* No se necesita la librería "mb_" ya que no es necesario hacer una comprobación UTF-8. */
            if (!str_contains($permitidos, $caracter)) return false;
        }

        return true;
    }

    // Comprueba si un texto contiene los parámetro válidos para que este sea tratado como un correo electrónico en vez de como un valor normal.
    function email (string $texto): bool{
        /**
         * if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
         * else return false;
         */
        // "filter_var" devuelve el correo electrónico si es válido, en caso de no serlo, retornará "false".
        return filter_var($texto, FILTER_VALIDATE_EMAIL) !== false;
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

        /**
         * "=>" es para los arrays asociativos. Sirve para darle un nombre a cada posición de un array.
         *     "[$nombre, $edad, $email];" → [0, 1, 2] ← posiciones automáticas.
         *     "["Nombre" => $nombre, "Edad" => $edad, "Correo electrónico / E-mail" => $email];" → ["Nombre", "Edad", "Correo electrónico"] ← posiciones personalizadas (clave - valor).
         */
        $campos = ["Nombre" => $nombre, "Edad" => $edad, "Correo electrónico / E-mail" => $email];

        foreach ($campos as $nombreCampo => $valor){
            if (campoVacio($valor)){
                $mensaje = "ERROR: El campo \"$nombreCampo\" está vacío.";

                // Finaliza el bucle en el primer campo vacío (se avisa del primero que falte).
                break;
            }
        }

        // Condicional para comprobar únicamente el formato de los campos si ninguno está vacío (si no, se sobrescribiría el mensaje de error anterior).
        if ($mensaje === ""){
            if (!soloLetras($nombre)){
                $mensaje = "ERROR: El valor introducido en el campo \"Nombre\" solo puede contener letras y espacios.";
                
            } elseif (longitudTexto($nombre) > longitudNombreMaxima){
                $mensaje = "ERROR: El nombre no puede tener más de " . longitudNombreMaxima . " caracteres.";

            } elseif (!soloNumeros($edad)){
                $mensaje = "ERROR: El valor introducido en el campo \"Edad\" solo puede contener números.";
                
            } elseif ((int) $edad < edadMinima || (int) $edad > edadMaxima){
                $mensaje = "ERROR: La edad debe estar comprendida entre " . edadMinima . " y " . edadMaxima . " años.";

            } elseif (!email($email)){
                $mensaje = "ERROR: El valor introducido en el campo \"Correo electrónico / E-mail\" no es el esperado, no tiene un formato válido.";

            } else{
                // "htmlspecialchars" convierte los caracteres especiales de HTML (como "<" o ">") en texto normal, para que el usuario no pueda inyectar código en la página.
                $mensaje = "¡Hola, " . htmlspecialchars($nombre) . "! Tienes " . (int) $edad . " años y tu correo electrónico es " . htmlspecialchars($email) . ".";
                $esError = false;
            }
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