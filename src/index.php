<?php

namespace TaskForce;

require_once __DIR__ . '../../vendor/autoload.php';

use TaskForce\Classes\Exceptions\FileFormatException;
use TaskForce\Classes\Exceptions\SourceFileException;
use TaskForce\Classes\Translation\CSVToSQLConverter;

$importerCategories = new CSVToSQLConverter("./data/categories.csv", ['name', 'icon']);
try {
    $importerCategories->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}

$importerCities = new CSVToSQLConverter("./data/cities.csv", ['name', 'lat', 'long']);
try {
    $importerCities->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}
