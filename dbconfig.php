<?php
require('config.php');

function db_connect($db_constr)
{
    $db_conn = mysqli_connect($db_constr);
    if (!$db_conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $db_conn;
}

function db_set_encoding($db_conn, $db_encstr)
{
    if (!mysqli_set_charset($db_conn, $db_encstr)) {
        die("Error setting character set: " . mysqli_error($db_conn));
    }
}

function db_exec($db_conn, $query)
{
    $result = mysqli_query($db_conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($db_conn));
    }
    return $result;
}

function db_fetch_row($result)
{
    return mysqli_fetch_row($result);
}

function db_fetch_assoc($result)
{
    return mysqli_fetch_assoc($result);
}

function db_freeresult($result)
{
    mysqli_free_result($result);
}

function db_NumRows($result)
{
    return mysqli_num_rows($result);
}

function db_NumFields($result)
{
    return mysqli_num_fields($result);
}

function db_close($db_conn)
{
    mysqli_close($db_conn);
}

?>
