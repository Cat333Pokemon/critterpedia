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
    case "sea":
        $dbs = ["sea"];
        $listtitle = "Sea Creatures";
        break;
    case "fossils":
        $dbs = ["fossils"];
        $listtitle = "Fossils";
        break;
    case "art":
        $dbs = ["art"];
        $listtitle = "Art";
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

    if (isset($rdb["bugs"]) || isset($rdb["fish"])){
        //Hemisphere selector
        echo '<p><strong>Hemisphere:</strong><br />
            <input type="radio" id="nhem" name="hemi" checked /><label for="nhem"> Northern Hemisphere</label><br />
            <input type="radio" id="shem" name="hemi" disabled /><label for="shem"> Southern Hemisphere</label><br />
            (S.H. not added yet)
        </p>';
    }

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
                <p class="cdata">&#128197; ' . $monthstring . '<br />&#128343; ' .
                    $hourstring . '<br />' .
                    (isset($bug -> location) ? '&#128027; ' . htmlspecialchars($bug -> location) . '<br />' : '') .
                    (isset($bug -> price) ? '&#128176; ' . number_format($bug -> price) . ' Bells<br />' : '') . '
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
                <p class="cdata">&#128197; ' . $monthstring . '<br />&#128343; ' .
                    $hourstring . '<br />' .
                    (isset($fish -> location) ? '&#127907; ' . htmlspecialchars($fish -> location) . '<br />' : '') .
                    (isset($fish -> price) ? '&#128176; ' . number_format($fish -> price) . ' Bells<br />' : '') .
                    (isset($fish -> shadow) ? '&#128207; ' . $shadowsizes[$fish -> shadow] . '<br />' : '') . '
                </p>
            </a>';
        }
    }else if (isset($rdb["sea"])){
        foreach ($rdb["sea"] as $sea){
            $monthstring = timeprint($sea -> months, false);
            $hourstring = timeprint($sea -> hours);

            echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($sea -> name)) . '">
                <img src="/images/';
                    if (file_exists('../images/sea/' . $sea -> name . '.png')){
                        echo 'sea/' . rawurlencode($sea -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                echo '" alt="' . htmlspecialchars($sea -> name) . '" />
                <h3>' . htmlspecialchars($sea -> name) . '</h3>
                <p class="cdata">&#128197; ' . $monthstring . '<br />&#128343; ' .
                    $hourstring . '<br />' .
                    (isset($sea -> movement) ? '&#127946; ' . htmlspecialchars($sea -> movement) . '<br />' : '') .
                    (isset($sea -> price) ? '&#128176; ' . number_format($sea -> price) . ' Bells<br />' : '') .
                    (isset($sea -> shadow) ? '&#128207; ' . $shadowsizes[$sea -> shadow] . '<br />' : '') . '
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
    }else if (isset($rdb["art"])){
        foreach ($rdb["art"] as $art){
            if (file_exists('../images/art/' . $art -> name . '.jpg')){
                echo '<a class="critterlist" href="/images/art/full/' .
                        rawurlencode($art -> name) . '.png" target="_blank" id="' . preg_replace("/[^a-z]/", '', strtolower($art -> name)) . '">
                        <img src="/images/art/' . rawurlencode($art -> name) . '.jpg" alt="' . htmlspecialchars($art -> name) . '" />
                        <h3>' . htmlspecialchars($art -> name) . '</h3>' .
                        (isset($art -> parts) ? '<p>' . nl2br(htmlspecialchars(implode("\n", $art -> parts))) . '</p>' : '') .
                    '</a>';
            }else{
                echo '<a class="critterlist" id="' . preg_replace("/[^a-z]/", '', strtolower($art -> name)) . '">
                        <img src="/images/noimage.png" alt="' . htmlspecialchars($art -> name) . '" />
                        <h3>' . htmlspecialchars($art -> name) . '</h3>
                    </a>';
            }
        }
    }else if (isset($rdb["reactions"])){
        echo '<p>Four reactions are initially available after learning to use reactions. The other 40 are randomly taught by villagers of the specified personalities,
            five per personality. Ones requiring high friendship may be learned after becoming close friends with a villager; they are not necessarily the last ones
            learned for that personality.</p>';
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
                <p>' . (isset($reaction -> personality) ? htmlspecialchars($reaction -> personality) : '<em>Initial set</em>') .
                    (isset($reaction -> friends) && $reaction -> friends ? '<br />(High friendship)' : '') .
                '</p>
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
                '<br />&#127874; ' . date("M j", mktime(null, null, null, $villager -> birthmonth, $villager -> birthday)) .
                '</p>
            </a>';
        }
    }
}




require_once("../includes/footer.php"); ?>