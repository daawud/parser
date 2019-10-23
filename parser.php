<?php
require_once("vendor/autoload.php");

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

    $matchesArray[] = array(
        "match-name" => $pqmatch->attr('data-event-name'),
        "match-href" => $prefix . $pqmatch->attr('data-event-path')
    );
}

phpQuery::unloadDocuments();

echo json_encode($matchesArray);
