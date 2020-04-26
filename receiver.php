<?php
require_once 'common.php';

$username = $_POST['username'] ?? null;
$message = $_POST['message'] ?? null;

if (empty($username) || empty($message)) {
    echo json(500, 'username and message is required');
    die;
}

if(mb_strlen($username) > 20){
    echo json(500, 'username length must be within 20 characters');
    die;
}

if(mb_strlen($message) > 200){
    echo json(500, 'message length must be within 200 characters');
    die;
}

$pdo = DB::instance();

$sql = 'insert into messages(username,message) values(?,?)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $username);
$stmt->bindValue(2, $message);
$stmt->execute();

$errcode = $stmt->errorCode();
if ($errcode == '00000') {
    echo json(0, 'success');
} else {
    echo json(500, 'insert error:'.$errcode);
}
