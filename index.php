<?php
ini_set('display_errors', 1);
//include __DIR__.'/includeFile/layout.html.php';
$array = [
    'id' => 1,'joketext' => '!false - it\'s funny because it\'s true'];
$query = ' UPDATE `joke` SET ';
foreach ($array as $key => $value) 
{
    $query .= '`' . $key . '` = :' . $key . ',';
}
$query = rtrim($query, ',');
$query .= ' WHERE `id` = :primaryKey';
echo $query;
$query = ' UPDATE `joke` SET ';
$fields['primaryKey'] = $fields['idjoke'];    
foreach ($fields as $key => $value) 
    {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `idjoke` = :primaryKey';
    echo $query;
    // Set the :primaryKey variable
    $date = new DateTime();echo $date->format('d/m/Y H:i:s');