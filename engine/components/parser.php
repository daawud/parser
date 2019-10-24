<?php
require_once("../config/config.php");
require_once(WWW_ROOT . "vendor/autoload.php");
require_once("functions.php");
require_once("DB.php");
$_POST = json_decode(file_get_contents('php://input'), true);
$page = ($_POST["page"]) ? $_POST["page"] : 0;

$query = "https://www.marathonbet.ru/su/events.htm?id=11&page=" . $page;

$html = file_get_contents($query);
$decod_html = stripslashes($html);

$pq = phpQuery::newDocument($decod_html);

$matchesArray = array();

$matches = $pq->find('.bg');

$prefix = 'https://www.marathonbet.ru/su/betting/';
foreach ($matches as $match) {

    $pqmatch = pq($match);
    $match_name = $pqmatch->attr('data-event-name');
    $match_id = $pqmatch->attr('data-event-path');
    $match_href = $prefix . $match_id;

    $matchesArray[] = array(
        "match-name" => $match_name,
        "match-id" => $match_id,
        "match-href" => $match_href
    );
}

phpQuery::unloadDocuments();

foreach ($matchesArray as $event) {
    $event_exists = eventInBase($event['match-id']);
    if (!$event_exists) {
        $id = $event["match-id"];

        $all_math_data = getAllMatchData($event['match-href']);

        $prepared_sql = DB::getInstance()->prepare("INSERT INTO matches_data (match_id, match_data) VALUES (:match_id, :match_data)");

        $prepared_sql->bindParam(':match_id', $event["match-id"]);
        $prepared_sql->bindParam(':match_data', $all_math_data);

        $prepared_sql->execute();
    }
}

echo json_encode($matchesArray);
