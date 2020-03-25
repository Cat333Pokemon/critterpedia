<?php
//Load databases if specified
if (isset($dbs)){
    $error_message = "";
    $rdb = []; //databases to be returned
    foreach($dbs as $db){ //Iterate DBs
        $lfile = file_get_contents(__DIR__ . "/../db/" . $db . ".json");
        if ($lfile === false){
            $error_message .= "Database '$db' not found";
        }else{
            //File loaded fine, so parse it
            $lobj = json_decode($lfile);
            if ($lobj === null){
                $error_message .= "Could not parse database '$db'";
            }else{
                //Looks like a JSON object
                $rdb[$db] = $lobj; //add new database to array
    
            }
        }
    }
    //Clean up
    if (isset($lobj)) unset($lobj);
    if (count($rdb) == 0) unset($rdb);
    if (strlen($error_message) == 0) unset($error_message);
}


?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pagetitle) ?> &ndash; Critterpedia</title>
    <link rel="stylesheet" href="/style/main.css" />

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="manifest" href="/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff" />
</head>
<body>
    <header>
        <h1><a href="/">Critterpedia</a></h1>
        <div>
            <div class="alert">
                This site is under construction and may not work properly.
            </div>
        </div>
        <?php
            if (isset($error_message)){
                echo '<div class="alert">' . htmlspecialchars($error_message) . '</div>';
            }
        ?>
    </header>
    <article>
        <h2><?= htmlspecialchars($pagetitle) ?></h2>