<?php
/*
 * Plugin Name: Final project
 */

function getExchangeRates() {
    $url = "https://api.exchangeratesapi.io/latest?base=CAD";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    return json_decode($result, true)['rates'];
}

function displayPriceInUSD() {
    $price = auto_listings_meta('price');
    $exchangeRates = getExchangeRates();
    $cadToUsd = $exchangeRates['USD'];
    echo '<div style="text-align: right; margin-top: -20px; font-size: 17px;">';
    echo '<strong>Price in USD: $' . number_format(round($price * $cadToUsd)) . '</strong>';
    echo '</div>';
}

add_action('auto_listings_single_content', 'displayPriceInUSD');
