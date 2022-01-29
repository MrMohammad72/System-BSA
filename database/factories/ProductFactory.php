<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\product;
use Faker\Generator as Faker;

$factory->define(product::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement([
		    'پروتکل های شبکه',
		    'پروتکل های رمزنگاری',
		    'الگوریتم های رمزنگاری',
		    'پروتکل های تبادل کلید',
		    'پروتکل های احراز هویت ',
		    'پروتکل های احراز هویت دو مرحله ای',
		    'پروتکل های احرارهویت سبک وزن',
		    'پروتکل های احراز هویت فوق سبک وزن',
		    'پروتکل صفر و یک',
		    'الگوریتم sh256',
		    'الگوریتم هش گذاری',
		    'کدینگ کانال',
		    
	    ]),
	    'description' => 'چک لیست های امنیتی برای هر بخش ارائه شده است تا فرایند ارزیابی امنیتی سیستم را تسهیل کند.',

	    'image' => 'https://via.placeholder.com/286x180?text=Image',
	    'price' => $faker->randomElement([
		150000 , 450000 , 252000 , 2521000 , 250000 , 150000 , 850000 , 650000, 450000 , 950000 , 410000 , 320000
	    ]),
	    'stock'=> $faker->randomDigitNotNull
    ];
});
