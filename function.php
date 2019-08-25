<?php
ini_set('display_errors', 1);
include_once __DIR__ .'/includeFile/DatabaseConnection.php';
function totalJokes($pdo) 
{
    $query = query($pdo,'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}
function getJoke($pdo, $idjoke) 
{
    $parameters =[':idjoke' =>$idjoke];
    $query = query($pdo,'SELECT * FROM `joke`WHERE `idjoke` = :idjoke',$parameters);
    return $query->fetch();
}
function query($pdo, $sql, $parameters=[]) 
{
    $query = $pdo->prepare($sql);
    foreach ($parameters as $name => $value ) 
    {
        $query->bindValue($name, $value);
    }
    $query->execute();
    return $query;
}
function processDates($fields) 
{
    foreach ($fields as $key => $value) 
    {
        if ($value instanceof DateTime) 
        {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
}
function insertJoke($pdo, $fields) 
{
    $query = 'INSERT INTO `joke` (';
    foreach ($fields as $key => $value) 
    {
        $query .= '`' . $key . '`,';
    }
    $query = rtrim($query, ',');
    $query .= ') VALUES (';
    foreach ($fields as $key => $value) 
    {
        $query .= ':' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ')';
    foreach ($fields as $key => $value) 
    {
        if ($value instanceof DateTime) 
        {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    query($pdo, $query,$fields);
}
function updateJoke($pdo, $fields) 
{
    $query = ' UPDATE `joke` SET ';
    foreach ($fields as $key => $value) 
    {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `idjoke` = :primaryKey';
    foreach ($fields as $key => $value) 
    {
        if ($value instanceof DateTime) 
        {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    // Set the :primaryKey variable
    $fields['primaryKey'] = $fields['idjoke'];
    query($pdo, $query, $fields);
}
function deleteJoke($pdo, $idjoke) 
{
    $parameters = [':idjoke' => $idjoke];
    query($pdo, 'DELETE FROM `joke`WHERE `idjoke` = :idjoke', $parameters);
}
function allJokes($pdo) 
{
    $jokes =  query($pdo, 'SELECT `joke`.`idjoke`, `joketext`,`jokedate`,`name`
                FROM `joke` INNER JOIN `author`ON `authorid` = `author`.`id`');
    return $jokes->fetchAll();
}