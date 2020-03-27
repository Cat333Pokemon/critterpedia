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
        echo '<ul>';
        foreach ($rdb["bugs"] as $bug){
            echo '<li class="critterlist">
                <img src="/images/';
                    if (file_exists('../images/bugs/' . $bug -> name . '.png')){
                        echo 'bugs/' . rawurlencode($bug -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($bug -> name) . '" />
                <h3>' . htmlspecialchars($bug -> name) . '</h3>
            </li>';
        }
        echo '</ul>';
    }else if (isset($rdb["fish"])){
        echo '<ul>';
        foreach ($rdb["fish"] as $fish){
            echo '<li class="critterlist">
                <img src="/images/';
                    if (file_exists('../images/fish/' . $fish -> name . '.png')){
                        echo 'fish/' . rawurlencode($fish -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($fish -> name) . '" />
                <h3>' . htmlspecialchars($fish -> name) . '</h3>
            </li>';
        }
        echo '</ul>';
    }else if (isset($rdb["fossils"])){
        echo '<ul>';
        foreach ($rdb["fossils"] as $fossil){
            if (file_exists('../images/fossils/' . $fossil -> name . '.jpg')){
                echo '<li>
                    <a class="critterlist" style="max-width: none;" href="/images/fossils/full/' .
                        rawurlencode($fossil -> name) . '.jpg" target="_blank" id="' . preg_replace("/[^a-z]/", '', strtolower($fossil -> name)) . '">
                        <img src="/images/fossils/' . rawurlencode($fossil -> name) . '.jpg" alt="' . htmlspecialchars($fossil -> name) . '" />
                        <h3>' . htmlspecialchars($fossil -> name) . '</h3>
                    </a>
                </li>';
            }else{
                echo '<li>
                    <a class="critterlist" style="max-width: none;" id="' . preg_replace("/[^a-z]/", '', strtolower($fossil -> name)) . '">
                        <img src="/images/noimage.png" alt="' . htmlspecialchars($fossil -> name) . '" />
                        <h3>' . htmlspecialchars($fossil -> name) . '</h3>
                    </a>
                </li>';
            }
        }
        echo '</ul>';
    }else if (isset($rdb["reactions"])){
        echo '<ul>';
        foreach ($rdb["reactions"] as $reaction){
            echo '<li class="critterlist">
                <img src="/images/';
                    if (file_exists('../images/reactions/' . $reaction -> name . '.png')){
                        echo 'reactions/' . rawurlencode($reaction -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($reaction -> name) . '" />
                <h3>' . htmlspecialchars($reaction -> name) . '</h3>
            </li>';
        }
        echo '</ul>';
    }else if (isset($rdb["songs"])){
        echo '<ul>';
        foreach ($rdb["songs"] as $song){
            echo '<li>
                <a class="critterlist" href="/images/songs/512/' .
                    rawurlencode($song -> name) . '.png" target="_blank">
                    <img width="150" height="150" src="/images/';
                        if (file_exists('../images/songs/' . $song -> name . '.jpg')){
                            echo 'songs/' . rawurlencode($song -> name) . '.jpg';
                        }else{
                            echo 'noimage.png';
                        }
                    echo '" alt="' . htmlspecialchars($song -> name) . '" />
                    <h3>' . htmlspecialchars($song -> name) . '</h3>
                </a>
            </li>';
        }
        echo '</ul>';
    }else if (isset($rdb["villagers"])){
        echo '<ul>';
        foreach ($rdb["villagers"] as $villager){
            echo '<li class="critterlist">
                <img src="/images/noimage.png" alt="' . htmlspecialchars($villager -> name) . '" />
                <h3>' . htmlspecialchars($villager -> name) . '</h3>
                <p>' . htmlspecialchars(
                    ($villager -> gender == 'm' ? 'Male ' : 'Female ') .
                    $villager -> personality . ' ' .
                    $villager -> species) .
                '</p>
            </li>';
        }
        echo '</ul>';
    }
}




require_once("../includes/footer.php"); ?>