<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = [
        ['name' => 'Amp Fever Tee',      'genre' => 'rock',   'price' => 189000, 'color' => '#1c1a1f', 'ink' => '#ff2e7e', 'mark' => 'AMP'],
        ['name' => 'Bubblegum Doom Tee', 'genre' => 'pop',    'price' => 179000, 'color' => '#ff2e7e', 'ink' => '#121014', 'mark' => 'POP'],
        ['name' => 'Iron Choir Hoodie',  'genre' => 'metal',  'price' => 429000, 'color' => '#2a2a30', 'ink' => '#b9bcc4', 'mark' => 'IRON'],
        ['name' => 'Back Alley Crewneck','genre' => 'street', 'price' => 359000, 'color' => '#efe8da', 'ink' => '#121014', 'mark' => 'ALLEY'],
        ['name' => 'Feedback Longsleeve','genre' => 'rock',   'price' => 249000, 'color' => '#5b1414', 'ink' => '#efe8da', 'mark' => 'LOUD'],
        ['name' => 'Chrome Skull Tee',   'genre' => 'metal',  'price' => 199000, 'color' => '#121014', 'ink' => '#b9bcc4', 'mark' => 'SKULL'],
    ];

    $collections = [
        ['name' => 'Pop',    'desc' => 'Warna nyala, grafis manis yang sengaja dibuat rusak.', 'from' => 179000],
        ['name' => 'Rock',   'desc' => 'Potongan longgar, cetak tebal, cocok buat gigs.',       'from' => 189000],
        ['name' => 'Metal',  'desc' => 'Hitam pekat, logo tajam, bahan berat.',                'from' => 199000],
        ['name' => 'Street', 'desc' => 'Basic harian yang tetap punya suara.',                 'from' => 359000],
    ];

    return view('home', compact('products', 'collections'));
});
