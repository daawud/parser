<?php

if (!isset($_GET['id'])) {
    die("Не корректный запрос.");
}

$id = str_replace(" ", "+", $_GET['id']);

require_once('DB.php');
require_once("../config/config.php");

$prepared_sql = DB::getInstance()->prepare("SELECT match_data FROM matches_data WHERE match_id = :match_id");
$prepared_sql->bindParam(':match_id', $id);

$prepared_sql->execute();
$qresult = $prepared_sql->fetch(PDO::FETCH_NUM);

if ($qresult) {
    require("template.php");
} else {
    die("Отсутствуют данные в базе.");
}
