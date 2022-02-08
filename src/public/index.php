<?php

namespace Tapir;

require_once '../vendor/autoload.php';

$pdo = (new PDOFactory)->getPDO();

$filterRequest = new FilterCarsMapRequest($_GET);
$condition = implode(' AND ', $filterRequest->getSqlFilterConditions());
$pagination = $filterRequest->getPagination();

// если не выбрали поля по котрым фильтровать, то выводим все машины
if ($condition !== ""){
    $condition = 'WHERE ' . $condition;
}

// считаем количество записей в таблице (для пагинации)
$stmt = $pdo->prepare("SELECT count(*) FROM cars $condition");
$stmt->execute($filterRequest->getSqlFilterParameters());
$totalRows = $stmt->fetch()['count'];

// делаем запрос в базу данных
$stmt = $pdo->prepare("SELECT * FROM cars $condition LIMIT $pagination->limit OFFSET $pagination->offset");
$stmt->execute($filterRequest->getSqlFilterParameters());
$cars = $stmt->fetchAll();

// подготовливаем результат
$result = [
    'pagination' => [
        'current_page' =>$pagination->page,
        'total_pages' => $pagination->getTotalPages($totalRows),
    ],
    'cars' => $cars
];

// отдаём ответ
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json');
echo json_encode($result);
