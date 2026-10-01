<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Photos live in public/models (cow1-8, cew1-4) and public/clothes (cowo1-4, cewe1-4).
        // Names and descriptions below are still samples. Replace them with the real data.
        $tee = ['material' => 'Combed cotton, washed black', 'colors' => ['Black'], 'sizes' => 'S – XL'];

        $products = [
            ['image' => 'models/cow1.png', 'name' => 'Crowd Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Concert crowd print with the Thream logo on the chest. The back reads Pop Punk Rock Metal.'] + $tee,
            ['image' => 'models/cow2.png', 'name' => 'Built From Chaos Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Statue print with the words Built From Chaos. The back features a compass and Not Perfect Just Real.'] + $tee,
            ['image' => 'models/cow3.png', 'name' => 'Broken Dreams Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Print of an angel wrapped in barbed wire, with the words Broken Dreams Stronger Soul.'] + $tee,
            ['image' => 'models/cow4.png', 'name' => 'No Pain No Glory Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Skull print inside a circle of barbed wire, with a small emblem on the sleeve.'] + $tee,
            ['image' => 'models/cow5.png', 'name' => 'Fake People Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Hooded figure print with the words Fake People Real Pain. The back features a crown of thorns.'] + $tee,
            ['image' => 'models/cow6.png', 'name' => 'Same Soul Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Masked figure print with the words Same Soul Different Day. The back reads No Fear No Rules Just Music.'] + $tee,
            ['image' => 'models/cow7.png', 'name' => 'Louder Faster Stronger Tee', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'Skeleton print with red accents and the words Louder Faster Stronger.'] + $tee,
            ['image' => 'models/cow8.png', 'name' => 'Crowd Tee Red Print', 'category' => 'Models', 'for' => 'Men',
             'desc' => 'The same concert crowd print as the Crowd Tee, with red Louder Faster Stronger lettering.'] + $tee,
        ];

        // Other photos: generic names and descriptions until replaced with the real data.
        // Every item gets the same detail fields ($tee) so no card has an empty dialog row.
        $sets = [
            ['models/cew', 4, 'Models', 'Women', "Women's Model", "Women's look from the Thream collection, worn by a model."],
            ['clothes/cowo', 4, 'Clothes', 'Men', "Men's Clothing", "Thream clothing for men, photographed on its own."],
            ['clothes/cewe', 4, 'Clothes', 'Women', "Women's Clothing", "Thream clothing for women, photographed on its own."],
        ];
        foreach ($sets as [$path, $count, $category, $for, $name, $desc]) {
            for ($i = 1; $i <= $count; $i++) {
                $products[] = ['image' => "$path$i.png", 'name' => "$name $i", 'category' => $category,
                               'for' => $for, 'desc' => $desc] + $tee;
            }
        }

        return view('pages.home', compact('products'));
    }
}
