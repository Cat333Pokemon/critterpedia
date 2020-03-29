<?php

//If you get here without a list, just redirect to the main page
if (!isset($_GET['uselist'])){
    header("Location: /");
    die();
}
switch($_GET['uselist']){
    case "bugs":
        $dbs = ["bugs"];
        $listtitle = "Bugs";
        break;
    case "fish":
        $dbs = ["fish"];
        $listtitle = "Fish";
        break;
    case "fossils":
        $dbs = ["fossils"];
        $listtitle = "Fossils";
        break;
    case "reactions":
        $dbs = ["reactions"];
        $listtitle = "Reactions";
        break;
    case "songs":
        $dbs = ["songs"];
        $listtitle = "K.K. Slider Songs";
        break;
    case "villagers":
        $dbs = ["villagers"];
        $listtitle = "Animal Villagers";
        break;
    default:
        //Redirect to the main page if invalid list
        header("Location: /");
        die();
}

$pagetitle = "List of " . $listtitle;
require_once("../includes/header.php");

if (isset($rdb)){
    //database loaded
    if (isset($rdb["bugs"])){
        foreach ($rdb["bugs"] as $bug){
            $monthstring = timeprint($bug -> months, false);
            $hourstring = timeprint($bug -> hours);
            echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($bug -> name)) . '">
                <img src="/images/';
                    if (file_exists('../images/bugs/' . $bug -> name . '.png')){
                        echo 'bugs/' . rawurlencode($bug -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($bug -> name) . '" />
                <h3>' . htmlspecialchars($bug -> name) . '</h3>
                <p>' . $monthstring . '<br />' .
                    $hourstring . '<br />' .
                    (isset($fish -> location) ? htmlspecialchars($bug -> location) . '<br />' : '') .
                    (isset($fish -> price) ? number_format($bug -> price) . '<br />' : '') . '
                </p>
            </a>';
        }
    }else if (isset($rdb["fish"])){
        foreach ($rdb["fish"] as $fish){
            $monthstring = timeprint($fish -> months, false);
            $hourstring = timeprint($fish -> hours);

            echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($fish -> name)) . '">
                <img src="/images/';
                    if (file_exists('../images/fish/' . $fish -> name . '.png')){
                        echo 'fish/' . rawurlencode($fish -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($fish -> name) . '" />
                <h3>' . htmlspecialchars($fish -> name) . '</h3>
                <p>' . $monthstring . '<br />' .
                    $hourstring . '<br />' .
                    (isset($fish -> location) ? htmlspecialchars($fish -> location) . '<br />' : '') .
                    (isset($fish -> price) ? number_format($fish -> price) . '<br />' : '') .
                    (isset($fish -> shadow) ? $shadowsizes[$fish -> shadow] . '<br />' : '') . '
                </p>
            </a>';
        }
    }else if (isset($rdb["fossils"])){
        foreach ($rdb["fossils"] as $fossil){
            if (file_exists('../images/fossils/' . $fossil -> name . '.jpg')){
                echo '<a class="critterlist" href="/images/fossils/full/' .
                        rawurlencode($fossil -> name) . '.jpg" target="_blank" id="' . preg_replace("/[^a-z]/", '', strtolower($fossil -> name)) . '">
                        <img src="/images/fossils/' . rawurlencode($fossil -> name) . '.jpg" alt="' . htmlspecialchars($fossil -> name) . '" />
                        <h3>' . htmlspecialchars($fossil -> name) . '</h3>' .
                        (isset($fossil -> parts) ? '<p>' . nl2br(htmlspecialchars(implode("\n", $fossil -> parts))) . '</p>' : '') .
                    '</a>';
            }else{
                echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($fossil -> name)) . '">
                        <img src="/images/noimage-fossil.png" alt="' . htmlspecialchars($fossil -> name) . '" />
                        <h3>' . htmlspecialchars($fossil -> name) . '</h3>
                    </a>';
            }
        }
    }else if (isset($rdb["reactions"])){
        foreach ($rdb["reactions"] as $reaction){
            echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($reaction -> name)) . '">
                <img src="/images/';
                    if (file_exists('../images/reactions/' . $reaction -> name . '.png')){
                        echo 'reactions/' . rawurlencode($reaction -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($reaction -> name) . '" />
                <h3>' . htmlspecialchars($reaction -> name) . '</h3>
            </a>';
        }
    }else if (isset($rdb["songs"])){
        foreach ($rdb["songs"] as $song){
            echo '<a class="critterlist" href="/images/songs/512/' .
                    rawurlencode($song -> name) . '.png" target="_blank" id="' . preg_replace("/[^a-z]/", '', strtolower($song -> name)) . '">
                    <img width="150" height="150" src="/images/';
                        if (file_exists('../images/songs/' . $song -> name . '.jpg')){
                            echo 'songs/' . rawurlencode($song -> name) . '.jpg';
                        }else{
                            echo 'noimage.png';
                        }
                    echo '" alt="' . htmlspecialchars($song -> name) . '" />
                    <h3>' . htmlspecialchars($song -> name) . '</h3>
                </a>';
        }
    }else if (isset($rdb["villagers"])){
        foreach ($rdb["villagers"] as $villager){
            echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($villager -> name)) . '">
                <img src="/images/noimage.png" alt="' . htmlspecialchars($villager -> name) . '" />
                <h3>' . htmlspecialchars($villager -> name) . '</h3>
                <p>' . htmlspecialchars(
                    ($villager -> gender == 'm' ? 'Male ' : 'Female ') .
                    $villager -> personality . ' ' .
                    $villager -> species) .
                '</p>
            </a>';
        }
    }
}




require_once("../includes/footer.php"); ?>