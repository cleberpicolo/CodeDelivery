<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(CodeDelivery\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeDelivery\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(CodeDelivery\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->numberBetween(10, 50)
    ];
});

$factory->define(CodeDelivery\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode
    ];
});

$factory->define(CodeDelivery\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'total' => $faker->numberBetween(10,500),
        'status' => $faker->numberBetween(0,2)
    ];
});

$factory->define(CodeDelivery\Models\OrderItem::class, function (Faker\Generator $faker) {
    return [
        'price' => $faker->numberBetween(10,50),
        'qtd' => $faker->numberBetween(1,3)
    ];
});

$factory->define(CodeDelivery\Models\Cupom::class, function (Faker\Generator $faker) {
    return [
        'code' => rand(100, 1000),
        'value' => rand(50, 100)
    ];
});

$factory->define(CodeDelivery\Models\OAuthClient::class, function (Faker\Generator $faker) {
    return [

    ];
});