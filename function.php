<?php
ini_set('display_errors', 1);
include_once __DIR__ .'/includeFile/DatabaseConnection.php';
function findAll($pdo, $table)  
{
    $result = query($pdo, 'SELECT * FROM `' . $table . '`');
    return $result->fetchAll();
}
function delete($pdo, $table, $primaryKey, $idjoke ) 
{
    $parameters = [':idjoke' => $idjoke];
    query($pdo, 'DELETE FROM `' . $table . '`WHERE `' . $primaryKey . '` = :idjoke',
         $parameters);
}
function insert($pdo, $table, $fields) 
{
    $query = 'INSERT INTO `' . $table . '` (';
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
    $fields = processDates($fields);
    query($pdo, $query, $fields);
}
function update($pdo, $table, $primaryKey, $fields) 
{
    $query = ' UPDATE `' . $table .'` SET ';
    foreach ($fields as $key => $value) 
    {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `' . $primaryKey . '` = :primaryKey';
    // Set the :primaryKey variable
    $fields['primaryKey'] = $fields['idjoke'];
    $fields = processDates($fields);
    query($pdo, $query, $fields);
}
function findById($pdo, $table, $primaryKey, $value) 
{
    $query = 'SELECT * FROM `' . $table . '`WHERE `' 
            . $primaryKey . '` = :value';
    $parameters = ['value' => $value];
    $query = query($pdo, $query, $parameters);
    return $query->fetch();
}
function total($pdo, $table) 
{
    $query = query($pdo, 'SELECT COUNT(*)FROM `' . $table . '`');
    $row = $query->fetch();
    return $row[0];
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
function allJokes($pdo) 
{
    $jokes =  query($pdo, 'SELECT `joke`.`idjoke`, `joketext`,`jokedate`,`name`
                FROM `joke` INNER JOIN `author`ON `authorid` = `author`.`id`');
    return $jokes->fetchAll();
}