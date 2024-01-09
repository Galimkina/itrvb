<?php
include "src/main/Product.php";
include "src/main/PhysicalProduct.php";
include "src/main/DigitalProduct.php";
include "src/main/WeightProduct.php";

echo "<h1><b>Цифровой товар</b></h1>";
$digitalProduct = new DigitalProduct("Apple iCloud", 149);
$digitalProduct->view();
echo "<p>";

echo "<h1><b>Штучный физический товар</b></h1>";
$physicalProduct = new PhysicalProduct("Наушники Apple AirPods", 13799, 2);
$physicalProduct->view();
echo "<p>";

echo "<h1><b>Товар на вес</b></h1>";
$weightProduct = new WeightProduct("Яблоки", 50, 5);
$weightProduct->view();

$productsSum = array($physicalProduct , $digitalProduct , $weightProduct);
$sum = 0;
foreach ($productsSum as $product)
{
    $sum = $sum + $product->finalCost();
}
echo "<h1>Общий доход от продаж: " . $sum . " рублей</h1>";