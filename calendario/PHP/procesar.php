<?php
    // <========== Variables ==========>

    // Mensaje de error (se queda vacío si todo va bien).
    $mensajeError = "";

    // Día, mes y año de la fecha encontrada (se quedan vacíos si no se encuentra ninguna).
    $dia = "";
    $mes = "";
    $anio = "";

    // Palabras que empiezan por mayúscula encontradas en el texto.
    $palabrasMayuscula = [];


    // <========== Expresiones regulares ==========>

    /**
     * Fecha en formato dd/mm/yyyy. Cada parte va entre paréntesis (grupo) para poder extraerla por separado.
     *     "\b"                         → Límite de palabra: la fecha no puede estar pegada a otros dígitos (evita aceptar "125/12/20234" → De aquí"patronFecha" no coge nada; si fuese sin "\b", partiendo del ejemplo "125/12/20234" solo leería y cogería "25/12/2023").
     *     "(0[1-9]|[12][0-9]|3[01])"   → Día: del 01 al 09 (se pone un cero delante para completar el formato de dos dígitos "dd/" → "01/"), del 10 al 29 (proceso que se dividie en dos partes, primero el "1" de "[12]" seguido de los números del "0" al "9" con "[0-9]". Y lo mismo para el número "2" de "[12]"), o 30 y 31.
     *     "|"                          → Equivale a la letra "O": separa opciones alternativas dentro de un grupo (basta con que se cumpla una de ellas).
     *     "\/"                         → Barra literal (se escapa con "\" porque "/" es el delimitador del patrón).
     *     "(0[1-9]|1[0-2])"            → Mes: del 01 al 09, o del 10 al 12.
     *     "(\d{4})"                    → Año: exactamente cuatro dígitos.
     *         "\d"                         → Equivale a "un dígito cualquiera" (a "[0-9]").
     *         "{4}"                        → Repite exactamente 4 veces lo que va justo antes ("\d{4}" → cuatro dígitos seguidos).
     */
    const patronFecha = '/\b(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4})\b/';

    /**
     * Palabra que empieza por mayúscula.
     *     "\b"             → Inicio de palabra.
     *     "[A-ZÁÉÍÓÚÑ]"    → Primera letra: una mayúscula (incluidas las acentuadas y la "Ñ").
     *     "\w*"            → Coge el resto de la palabra: cero o más caracteres de palabra (se detiene al encontrar un carácter distinto al de la palabra, espacios, comas, puntos, etc.).
     *         "*"              → Equivale a "cero o más veces lo que va justo antes".
     *     "u"              → Modificador UTF-8: sin él, las tildes y la "ñ" se rompen ("Señor" se cortaría en "Se").
     */
    const patronMayuscula = '/\b[A-ZÁÉÍÓÚÑ]\w*/u';


    // <========== Main ==========>

    // Condicional para comprobar que se ha llegado a esta página enviando/a través del formulario (y no escribiendo la dirección URL en el navegador).
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        $mensajeError = "ERROR: Debes enviar el formulario para analizar un texto.";

    } else{
        // Recoge el texto enviado por el formulario y lo normaliza eliminando los espacios del principio y del final.
            /**
             * "??" evita el aviso si el campo no ha llegado.
             * " ?? "" " significa que si "$_POST["texto"]" no existe, usa en su lugar " "" " (texto vacío) como valor a poner.
             */
        $texto = trim($_POST["texto"] ?? "");

        // Condicional para comprobar que se ha escrito algún texto.
        if ($texto === ""){
            $mensajeError = "ERROR: El texto no puede estar vacío.";

        } else{
            // <========== Validación y extracción de la fecha ==========>

            // "preg_match" busca la PRIMERA coincidencia: devuelve "1" si la encuentra y "0" si no. Lo que encuentra se guarda en "$coincidencias".
                /**
                 * $coincidencias[0] → La fecha completa (por ejemplo, "25/12/2023").
                 * $coincidencias[1] → Lo capturado por el primer grupo (el día).
                 * $coincidencias[2] → Lo capturado por el segundo grupo (el mes).
                 * $coincidencias[3] → Lo capturado por el tercer grupo (el año).
                 */
            if (preg_match(patronFecha, $texto, $coincidencias)){
                $dia = $coincidencias[1];
                $mes = $coincidencias[2];
                $anio = $coincidencias[3];

            } else $mensajeError = "No se encontró ninguna fecha con el correcto formato esperado: (dd/mm/yyyy).";


            // <========== Búsqueda de palabras que empiezan por mayúscula ==========>

            // "preg_match_all" busca TODAS las coincidencias (no solo la primera, no se detiene al encontrar la primera coincidencia, sigue hasta el final del texto en busca de más). En "$resultados[0]" quedan todas las palabras encontradas.
            preg_match_all(patronMayuscula, $texto, $resultados);
            $palabrasMayuscula = $resultados[0];
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendario - Resultado</title>

        <!-- Icon -->
        <link rel="icon" href="../Images/Icono/calendario.png">

        <!-- CSS -->
        <link rel="stylesheet" href="../CSS/style.css">
    </head>
    <body>
        <header></header>
        <main>
            <!-- Fecha encontrada: se muestra separada en día, mes y año. -->
            <?php if ($dia !== ""): ?>
                <p class="exito">
                    <?php echo "Fecha encontrada: $dia/$mes/$anio"; ?>
                    <br>
                    <?php echo "Día: $dia ·  Mes: $mes ·  Año: $anio"; ?>
                </p>
            <?php endif; ?>

            <!-- Mensaje de error (sin fecha válida, texto vacío o acceso sin formulario). -->
            <?php if ($mensajeError !== ""): ?>
                <p class="error"><?php echo $mensajeError; ?></p>
            <?php endif; ?>

            <!-- Palabras que empiezan por mayúscula ("implode" une los elementos del array en un texto, separados por comas). -->
            <?php if (count($palabrasMayuscula) > 0): ?>
                <br>
                <p class="informacion">
                    <!-- "htmlspecialchars" convierte los caracteres especiales de HTML (como "<" o ">") en texto normal, para que el usuario no pueda inyectar código en la página. -->
                    <!-- "implode" une los valores guardados (las palabras con mayúsculas) en el array "palabrasMayuscula" formando una cadena de texto, en este caso mediante el carácter coma "," seguido de un salto espaciador, espacio, " ". -->
                    <?php echo "Palabras que empiezan con letra mayúscula: " . htmlspecialchars(implode(", ", $palabrasMayuscula)); ?>
                </p>
            <?php endif; ?>

            <!-- Enlace para volver al formulario. -->
            <a href="../index.html">Volver al formulario</a>
        </main>
        <footer></footer>
    </body>
</html>