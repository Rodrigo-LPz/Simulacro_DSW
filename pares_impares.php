<?
    $limite = 14;
    $totalPares = 0;
    $totalImpares = 0;

    for ($i = 1; $i < $limite; $i++){ 
        /**
         *if ($i % 2 === 0){
         *    $totalPares += 1;
         *} else{
         *    $totalImpares += 1;
         *}
         */

        ($i % 2 === 0) ? $totalPares++ : $totalImpares++;
    }

    /**
     * echo "Cantidad total de números pares: " . $totalPares;
     * echo "Cantidad total de números impares: " . $totalImpares);
     */

    printf ("Resultado final:\n\t- Cantidad total de números impares: %d \n\t-Cantidad total de números impares: %d", $totalPares, $totalImpares);
?>