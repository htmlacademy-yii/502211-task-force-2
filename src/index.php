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

$importerUsers = new CSVToSQLConverter("./data/users.csv", ['email', 'name', 'password', 'dt_add', 'last-visit']);
try {
    $importerUsers->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}

$importerTasks = new CSVToSQLConverter("./data/tasks.csv", ['dt_add', 'category_id', 'description', 'expire', 'name', 'address', 'budget', 'lat', 'long']);
try {
    $importerTasks->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}

$importerOpinions = new CSVToSQLConverter("./data/opinions.csv", ['dt_add', 'rate', 'description']);
try {
    $importerOpinions->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}

$importerReplies = new CSVToSQLConverter("./data/replies.csv", ['dt_add', 'rate', 'description']);
try {
    $importerReplies->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}

$importerReviews = new CSVToSQLConverter("./data/reviews.csv", [ 'rate', 'description']);
try {
    $importerReviews->import();
} catch (SourceFileException $e) {
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    error_log("Неверный формат файла импорта: " . $e->getMessage());
}
