<?php
function convertCurrency($amount, $currency)
{
    $error = '';
    $result = '';
 
    if (!is_numeric($amount) || $amount <= 0) {
        $error = 'Ingrese una cantidad válida.';
    } else {
        $apiUrl = "https://api.exchangerate-api.com/v4/latest/PEN";
        $response = file_get_contents($apiUrl);
 
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['rates'][$currency])) {
                $rate = $data['rates'][$currency];
                $convertedAmount = $amount * $rate;
                $result = "PEN $amount = $currency " . number_format($convertedAmount, 2);
            } else {
                $error = 'Moneda seleccionada no válida.';
            }
        } else {
            $error = 'No se pudieron obtener los tipos de cambio.';
        }
    }
 
    return ['result' => $result, 'error' => $error];
}