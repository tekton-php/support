<?php require '../vendor/autoload.php';

$collection = new \Illuminate\Support\Collection;

if (starts_with('haystack', 'hay')) {
    echo "Success";
}
