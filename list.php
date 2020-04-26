<?php
require_once 'common.php';

//接口类型
$action = $_GET['action'] ?? null;

$startId = intval($_GET['startId'] ?? 0);
//查询条数
$limit = intval($_GET['limit'] ?? 0) ?? 10;

switch ($action) {
    case 'getList':
        getList($startId, $limit);
        break;
    case 'news':
        news($startId, $limit);
        break;
    default:
        return json('500', 'Unexpected action-type');
}

function getList($startId, $limit)
{

    $pdo = DB::instance();
    if ($startId == 0) {
        $sql = "select id,username,message,created_time from messages order by id desc limit ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    } else {
        $sql = "select id,username,message,created_time from messages where id < ? order by id desc limit ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $startId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    }


    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
        echo json(1043, '没有更多历史消息');
    } else {
        echo json(0, 'success', $data);
    }
}

function news($startId, $limit)
{
    if(empty($startId)){
        echo json(500,'startId is required');
    }

    $pdo = DB::instance();
    $sql = "select id,username,message,created_time from messages where id > ? order by id ASC limit ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $startId, PDO::PARAM_INT);
    $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = array_reverse($data);
    if (empty($data)) {
        echo json(1043, '暂时没有新消息');
    } else {
        echo json(0, 'success', $data);
    }
}