<?php
    // Activa el tipado estricto (se usa para que los parametros declarados en las funciones y los valores retornados coincidan con el tipo declarado).
    declare(strict_types = 1);

    
    // <========== Funciones de lógica ==========>

    // Saludar.
    function saludar(string $nombre = "invitado"): string{ return "Hola, $nombre"; }


    // Sumar.
    function sumar(int $a, int $b): int{ return $a + $b; }


    // Sumar todos los números.
    function sumarTodos(int ...$nums): int{ /* "...$nums" es igual a decir, números a sumar ("..." los agrupa todos en un array). */        
        $suma = 0;
        
        /**
         * for ($i = 0; $i < count($nums); $i++){
         *     $suma += $nums[$i];
         * }
         */
        foreach ($nums as $n){ $suma += $n; }
        
        return $suma;
    }


    // Número primo-no primo.
    function esPrimo(int $n): bool{
        if ($n < 2) return false;

        if ($n === 2) return true;
        
        if ($n % 2 === 0) return false;

        for ($i = 3; $i * $i <= $n; $i += 2)
            if ($n % $i === 0) return false;

        return true;
    }


    // Palabra más larga.
    function palabraMasLarga(string $texto): string{
        $signos = [".", ",", ";", ":", "¿", "?", "¡", "!", "\"", "'", "(", ")", "-"];

        $textoLimpio = str_replace($signos, "", $texto);

        $palabras = explode(" ", $textoLimpio);

        $masLarga = "";

        foreach ($palabras as $palabra) 
            if (mb_strlen($palabra) > mb_strlen($masLarga)) $masLarga = $palabra;
            
        return $masLarga;
    }


    // Estadísticas.
    function estadisticas(float ...$nums): array{
        /**
         * $min = 99999999999; // Se parte de un número grande ya que si ponemos como valor inicial cero, este será el más bajo de la cadena, aún no estando.
         * $max = 0;
         * $media = 0;
         */
        // Mínimo y máximo provisionales: se parte del primer número de la lista (así siempre son valores reales, sean positivos o negativos).
        $min = $nums[0];
        $max = $nums[0];
        $totalSuma = 0;

        foreach ($nums as $numero){
            $totalSuma += $numero;

            if ($numero < $min) $min = $numero;

            if ($numero > $max) $max = $numero;
        }

        //return ['min' => $min, 'max' => $max, 'media' => round($totalSuma / count($nums))];
        return ['min' => $min, 'max' => $max, 'media' => $totalSuma / count($nums)];
    }


    // <========== Funciones de apoyo ==========>

    // Separa los argumentos de la terminal en el comando y sus argumentos.
    function leerArgs(array $argv): array{
        // "array_slice" copia el array a partir de la posición indicada (aquí, desde la 2 hasta el final).
        return ['comando' => $argv[1] ?? null, 'args' => array_slice($argv, 2),];
    }

    // Muestra cómo se usa el programa (cuando falta el comando o no existe).
    function imprimirUso(): void{
        echo "Uso: php toolbox.php <comando> [args]" . PHP_EOL;
        echo "Comandos: saludar, sumar, sumarTodos, esPrimo, palabraMasLarga, estadisticas" . PHP_EOL;
        echo "Ejemplos:" . PHP_EOL;
        echo "    php toolbox.php saludar Ana" . PHP_EOL;
        echo "    php toolbox.php sumar 3 9" . PHP_EOL;
        echo "    php toolbox.php sumarTodos 1 2 3 4" . PHP_EOL;
        echo "    php toolbox.php esPrimo 17" . PHP_EOL;
        echo "    php toolbox.php palabraMasLarga \"Frase de ejemplo\"" . PHP_EOL;
        echo "    php toolbox.php estadisticas 10 2 8 4" . PHP_EOL;
    }

    // Comprueba si un texto representa un número entero.
    function esEntero(string $valor): bool{ return filter_var($valor, FILTER_VALIDATE_INT) !== false; }


    // <========== Dispatcher ==========>

    // Condicional para comprobar si el usuario ha escrito algún comando ($argc cuenta los elementos de $argv: si solo está el nombre del script, vale 1).
    if ($argc < 2){
        imprimirUso();
        exit(1); /* "exit(1)" detiene el programa indicando que ha terminado con un error ("exit(0)" indicaría que ha terminado bien). */
    }

    // Separa el comando y sus argumentos.
    $entrada = leerArgs($argv);
    $comando = $entrada['comando'];
    $args = $entrada['args'];

    $mensaje = PHP_EOL . "Se está realizando la función '$comando':" . PHP_EOL;

    switch ($comando){
        case 'saludar':
            echo $mensaje;

            // Si el usuario no ha escrito un nombre, se usa el valor por defecto ("invitado").
            $saludo = (count($args) === 0) ? saludar() : saludar($args[0]);

            echo "Resultado de la operación 'Saludar': $saludo" . PHP_EOL;

            break;
            
        case 'sumar':
            echo $mensaje;

            // Comprueba que se han escrito exactamente dos números.
            if (count($args) !== 2){
                echo "ERROR: El comando 'sumar' necesita dos números enteros (ejemplo: php toolbox.php sumar 5 7)." . PHP_EOL;
                exit(1);
            }

            // Comprueba que ambos sean enteros.
            if (!esEntero($args[0]) || !esEntero($args[1])){
                echo "ERROR: Los dos sumandos deben ser números enteros." . PHP_EOL;
                exit(1);
            }

            echo "Resultado de la operación 'Suma': " . sumar((int) $args[0], (int) $args[1]) . PHP_EOL;

            break;

        case 'sumarTodos':
            echo $mensaje;

            // Comprueba que se ha escrito al menos un número.
            if (count($args) === 0){
                echo "ERROR: El comando 'sumarTodos' necesita al menos un número entero (ejemplo: php toolbox.php sumarTodos 1 2 3)." . PHP_EOL;
                exit(1);
            }

            // Guarda los argumentos ya validados convertidos a entero.
            $numeros = [];

            // Valida cada argumento y los guarda ya convertidos a entero.
            $numeros = [];
 
            foreach ($args as $valor){
                if (!esEntero($valor)){
                    echo "ERROR: '$valor' no es un número entero." . PHP_EOL;
                    exit(1);
                }
 
                $numeros[] = (int) $valor; /* "$numeros[] = ..." añade el valor al final del array (como "push" en JS). */
            }
            
            echo "Resultado de la operación 'Suma de todos los números': " . sumarTodos(...$numeros) . PHP_EOL;

            break;
            
        case 'esPrimo':
            echo $mensaje;
            
            // Comprueba que se ha escrito exactamente un número entero.
            if (count($args) !== 1 || !esEntero($args[0])){
                echo "ERROR: El comando 'esPrimo' necesita un número entero (ejemplo: php toolbox.php esPrimo 29)." . PHP_EOL;
                exit(1);
            }
 
            echo "Resultado de la operación 'Número primo': " . (esPrimo((int) $args[0]) ? "true" : "false") . PHP_EOL;

            break;
            
        case 'palabraMasLarga':
            echo $mensaje;
 
            // Comprueba que se ha escrito algún texto.
            if (count($args) === 0){
                echo "ERROR: El comando 'palabraMasLarga' necesita un texto (ejemplo: php toolbox.php palabraMasLarga \"Hola, mundo\")." . PHP_EOL;
                exit(1);
            }
 
            // Une todos los argumentos en un único texto (por si el usuario no ha puesto la frase entre comillas y cada palabra ha llegado por separado).
            $palabra = palabraMasLarga(implode(" ", $args));
 
            // Comprueba que el texto contenía alguna palabra (si solo tenía signos o espacios, la función devuelve un texto vacío).
            if ($palabra === ""){
                echo "ERROR: El texto no contiene ninguna palabra." . PHP_EOL;
                exit(1);
            }
 
            echo "Resultado de la operación 'Palabra más larga': $palabra" . PHP_EOL;
            break;
 
        case 'estadisticas':
            echo $mensaje;
            
            // Comprueba que se ha escrito al menos un número.
            if (count($args) === 0){
                echo "ERROR: El comando 'estadisticas' necesita al menos un número (ejemplo: php toolbox.php estadisticas 10 2 8 4)." . PHP_EOL;
                exit(1);
            }
 
            // Valida cada argumento y los guarda ya convertidos a decimal (aquí se admiten decimales, por eso se usa "is_numeric" y no "esEntero").
            $numeros = [];
 
            foreach ($args as $valor){
                if (!is_numeric($valor)){
                    echo "ERROR: '$valor' no es un número." . PHP_EOL;
                    exit(1);
                }
 
                $numeros[] = (float) $valor;
            }
 
            $resultado = estadisticas(...$numeros);
 
            printf("Resultado de las estadísticas: min = %.2f, max = %.2f, media = %.2f" . PHP_EOL, $resultado['min'], $resultado['max'], $resultado['media']);

            break;
        default:
            echo "ERROR: El comando '$comando' no existe." . PHP_EOL . PHP_EOL;
            imprimirUso();
            exit(1);
    }