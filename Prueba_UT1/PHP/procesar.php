<?php
    // <========== Variables ==========>

    // Array de errores: cada clave es un campo y su valor el mensaje de error específico de ese campo.
    $errores = [];

    // Datos recibidos del formulario (se inicializan vacíos para que el HTML nunca use variables sin definir).
    $nombre = "";
    $telefono = "";
    $email = "";

    // Nombre de usuario transformado a mayúsculas.
    $nombreNormalizadoMayusculas = "";



    // <========== Constantes ==========>

    const telefonoLongitudMinima = 9, telefonoLongitudMaxima = 15;

    const nombreLongitudMinima = 5, nombreLongitudMaxima = 20;


    // <========== Expresiones regulares ==========>

    // Campo nombre en formato esperado (solo letras, números y guión bajo "_").
        /**
         * "[a-zA-Z]" es la primera letra, obligatoria (se fuerza a que el primer caracter sea una letra).
         * "\w" representa cualquier carácter de una palabra, (equivale al conjunto "[a-zA-Z0-9_]").
         * "{4,19}" representa la cantidad esperada, en este caso son entre 4 y 19 caracteres más.
         */
    //const patronNombre = '/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]\w{4,19}$/u';
        /**
         * "[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]" es la primera letra, obligatoria (se fuerza a que el primer carácter sea una letra, incluidas "ñ", vocales con tilde y "ü").
         * "[a-zA-Z0-9_áéíóúüñÁÉÍÓÚÜÑ]" representa el resto de caracteres permitidos: letras, números y guion bajo "_".
         * "/u" (modificador Unicode UTF-8) hace que PHP trate cada carácter especial ("ñ", "á", "ü"...) como una sola letra; sin él, los lee como 2 bytes sueltos y el patrón falla.
         *     No se usa "\w" porque, con "/u", provocamos que "/w" acepte o deje pasar cualquier letra de cualquier idioma, como por ejemplo "ç"; y el bucle de mayúsculas no sabría transformarla.
         */
    const patronNombre = '/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ][a-zA-Z0-9_áéíóúüñÁÉÍÓÚÜÑ]{' . (nombreLongitudMinima -1) . ',' . (nombreLongitudMaxima -1) . '}$/u';

    // Campo número de teléfono en formato esperado (solo números).
        /**
         * "\d" representa cualquier dígito numérico (equivalen al  conjunto "[0-9]").
         */
    const patronTelefono = '/^\d{9,15}$/';

    // Campo email en formato esperado.
        /**
         * "[\w\-\.]+" permite empezar con 1 o más caracteres del siguiente rango "[a-zA-Z0-9_]", además de añadir a dicho rango los giones "-" y los puntos ".".
         * "([\w\-]+\.)" permite empezar con 1 o más caracteres del siguiente rango "[a-zA-Z0-9_]", además de añadir a dicho rango los giones "-"; y todo esto seguido de un punto ".".
         *     "[\w\-\.]+@([\w\-]+\.)+" el grupo entero se repite 1 o más veces, así se admiten subdominios. Ejemplo: "...@mail.empresa...."
         * "[a-zA-Z]{2,7}" permite eacribir caracteres de tipo letra exactamente entre 2 y 7. Corresponde a la extensión final de un correo electrónico/e-mail, por ejemplo: "....es", "....com", etc.
         */
    const patronEmail = '/^[\w\-\.]+@([\w\-]+\.)+[a-zA-Z]{2,7}$/';


    // <========== Main ==========>

    // Condicional para comprobar que se ha llegado a esta página enviando/a través del formulario (y no escribiendo la dirección URL en el navegador).
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        $errores["formulario"] = "ERROR: Debes enviar el formulario para validar los datos.";
    
    } else{
        // Recoge el texto enviado al campo/etiqueta "nombre" por el formulario y lo normaliza eliminando los espacios del principio y del final.
        $nombre = trim($_POST["nombre"] ?? "");

        // Recoge el texto enviado al campo/etiqueta "telefono" por el formulario y lo normaliza eliminando los espacios del principio y del final.
        $telefono = trim($_POST["telefono"] ?? "");

        // Recoge el texto enviado al campo/etiqueta "email" por el formulario y lo normaliza eliminando los espacios del principio y del final.
        $email = trim($_POST["email"] ?? "");


        // <========== Validación del nombre de usuario y normalización a mayúsculas ==========>

        if ($nombre === "") $errores["nombre"] = "ERROR: El campo/etiqueta \"Nombre de usuario\" no puede estar vacío.";
        elseif (!preg_match(patronNombre, $nombre)) $errores["nombre"] = "ERROR: El nombre de usuario debe empezar por una letra y tener entre 5 y 20 caracteres (letras, números o \"_\").";

        
        // <========== Validación del número de teléfono ==========>

        if ($telefono  === "") $errores["telefono"] = "ERROR: El campo/etiqueta \"Número de teléfono\" no puede estar vacío.";
        elseif (!preg_match(patronTelefono, $telefono)) $errores["telefono"] = "ERROR: El número de teléfono solo puede contener dígitos y tener entre" . telefonoLongitudMinima . " y " . telefonoLongitudMaxima . " dígitos.";

        
        // <========== Validación del coreo electrónico ==========>

        if ($email === "") $errores["email"] = "ERROR: El campo/etiqueta \"Correo electrónico / E-mail\" no puede estar vacío.";
        elseif (!preg_match(patronEmail, $email)) $errores["email"] = "ERROR: El correo electrónico no tiene un formato válido/esperado para ser procesado por el sistema (ejemplo: nombre@dominio.com).";


        // <========== Transformación del nombre a mayúsculas ==========>

        // Solo si no hay ningún error, se hace la normalización del nombre de usuario.
        if (empty($errores)){
            // Abecedario en minúsculas y mayúsculas.
            /**
             * $letrasMinusculas = "abcdefghijklmnñopqrstuvwxyz";
             * $letrasMayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
             */
            $letrasMinusculas = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","ñ","o","p","q","r","s","t","u","v","w","x","y","z","á","é","í","ó","ú","ü"];
            $letrasMayusculas = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z","Á","É","Í","Ó","Ú","Ü"];


            // Toma el nombre del usuario original y crea una copia en donde guardar el proceso de transformación letra a letra.
            $nombreNormalizadoMayusculas = $nombre;

            // Bucle para normalizar (a mayúscula) la entrada del campo "nombre de usuario" del formulario.
            //for ($i = 0; $i < mb_strlen($letrasMinusculas); $i++){
            for ($i = 0; $i < count($letrasMinusculas); $i++){
                $nombreNormalizadoMayusculas = preg_replace("/" . $letrasMinusculas[$i] . "/", $letrasMayusculas[$i], $nombreNormalizadoMayusculas);
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario - Resultado</title>

        <!-- Icon -->
        <link rel="icon" href="../Images/Icono/formulario.png">

        <!-- CSS -->
        <link rel="stylesheet" href="../CSS/style.css">
    </head>
    <body>
        <header></header>
        <main>
            <div class="formularioResultado">
                <h1>Datos del formulario recibidos:</h1>
                <!-- Si no hay errores: se muestran los datos validados, con el nombre de usuario en mayúsculas.. -->
                <?php if (empty($errores)): ?>
                    <p class="exito">
                        <?php echo PHP_EOL . "Nombre de usuario: " . htmlspecialchars($nombreNormalizadoMayusculas); ?>
                        <br>
                        <?php echo PHP_EOL . "Número de teléfono: " . htmlspecialchars($telefono); ?>
                        <br>
                        <?php echo PHP_EOL . "Correo electrónico / Email: " . htmlspecialchars($email); ?>
                    </p>
                    
                <!-- Si hay errores: se muestra un párrafo por cada campo incorrecto. -->
                <?php else: ?>
                    <?php foreach ($errores as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Enlace para volver al formulario. -->
                <a href="../index.html">Volver al formulario</a>
            </div>
        </main>
        <footer></footer>
    </body>
</html>