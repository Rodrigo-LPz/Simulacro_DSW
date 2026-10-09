<?php
    // Saludar.
    function saludar(string $nombre = "invitado"): string{
        return "Hola, $nombre\n";
    }


    // Sumar.
    function sumar(int $a = 0, int $b = 0): int{
        return $a + $b;
    }


    // Sumar todos los números.
    function sumarTodos(int ...$nums): int{
        $suma = 0;
        
        foreach ($nums as $n){
            $suma += $n;
        }
        
        return $suma;
    }


    // Número primo-no primo.
    function esPrimo(int $n): bool{       
        if ($n <= 1){
            echo "Debe introducir un número superior a uno";
            return false;
        }
        
        if ($n < 2){
            return false;
        }

        if ($n === 2){
            return true;
        }
        
        if ($n % 2 === 0){
            return false;
        }

        for ($i = 3; $i * $i <= $n; $i += 2){ 
            if ($n % $i === 0){
                return false;
            }
        }

        return true;
    }


    // Estadísticas.
    function estadisticas(float ...$nums): array{
        if (empty($nums)){
            return ['min' => 0.0, 'max' => 0.0, 'media' => 0.0];
        }


        $min = min($nums);
        $max = max($nums);
        $media = array_sum($nums) / count($nums);
    }


$mensaje = "Se está realizando la función " . $argv[1] . "\n";
/**
 * if ($argv[1] === "saludar"){
 *     print "Salida predefinida: " . saludar().  "Salida con nombre: " . saludar("Rodrigo") . "\n";
 * } elseif (argv[1] === "sumar"){
 *     print "Resultado de la operación 'Suma': " . sumar(5, 7) . "\n";
 * } elseif (argv[1] === "sumarTodos"){
 *     print "Resultado de la operación 'Suma de todos los números': " . sumarTodos(1, 2, 3, 4, 5). "\n";
 * } elseif (argv[1] === "esPrimo"){
 *     print "Resultado de la operación 'Números primos-no primos': " . (esPrimo(29) ? 'TRUE' : 'FALSE') . "\n";
 * } elseif (argv[1] === "estadisticas"){
 *     vprintf("Resultado de las estadísticas:\n\tNúmero mínimo: %.2f\n\tNúmero mínimo: %.2f\n\tNúmero mínimo: %.2f" . estadisticas (10, 2, 8, 4) . "\n");
 * }
 */
switch ($argv[1]){
    case 'saludar':
        echo $mensaje;

        /**
         * if (empty($argv[2])) echo "Hola, invitado";
         * esle echo "Hola, {$argv[2]}";
         */
        print "Salida predefinida: " . saludar().  "Salida con nombre: " . saludar($nombre == $argv[2]) . "\n";
        break;
    case 'sumar':
        echo $mensaje;
        
        /**
         * if (empty($argv[2]) || empty($argv[3])) echo "Hay que indicar, los dos sumandos". PHP_EOL;
         */
        print "Resultado de la operación 'Suma': " . sumar(5, 7) . "\n";
        break;
    case 'sumarTodos':
        echo $mensaje;
        
        print "Resultado de la operación 'Suma de todos los números': " . sumarTodos(1, 2, 3, 4, 5). "\n";
        break;
    case 'esPrimo':
        echo $mensaje;
        
        print "Resultado de la operación 'Números primos-no primos': " . (esPrimo(29) ? 'TRUE' : 'FALSE') . "\n";
        break;
    case 'estadisticas':
        echo $mensaje;
        
        vprintf("Resultado de las estadísticas:\n\tNúmero mínimo: %.2f\n\tNúmero mínimo: %.2f\n\tNúmero mínimo: %.2f" . estadisticas (10, 2, 8, 4) . "\n");
        break;
    default:
        echo $mensaje;
        
        # code...
        break;
}