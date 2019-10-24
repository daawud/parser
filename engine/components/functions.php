<?php

function getAllMatchData($url)
{
    $html_data = file_get_contents($url);

    $pqobj = phpQuery::newDocument($html_data);

    $match_data = $pqobj->find('.category-container');

    phpQuery::unloadDocuments();

    return $match_data;
}

function eventInBase($match_id)
{

    $prepared_sql = DB::getInstance()->prepare("SELECT id FROM matches_data WHERE match_id = :match_id");
    $prepared_sql->bindParam(':match_id', $match_id);

    $prepared_sql->execute();
    $qresult = $prepared_sql->fetch(PDO::FETCH_NUM);

    if ($qresult) {
        return true;
    } else {
        return false;
    }
}
