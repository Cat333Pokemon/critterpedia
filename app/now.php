<?php

//If Northern Hemisphere, offset 0
//If Southern Hemisphere, offset 6
if (isset($_GET['hemisphere']) && $_GET['hemisphere'] == 'south'){
    $hoffset = 6;
    $hemi = "Southern";
}else{
    $hoffset = 0;
    $hemi = "Northern";
}

$pagetitle = "What's Available Now? ($hemi Hemisphere)";
$dbs = ["bugs","fish"];
require_once("../includes/header.php"); 

?>
<p>The current month is <strong><?= date("F") ?></strong>. The green <q>New</q> is new this month. The yellow warning symbol is leaving next month.</p>
<?php
if (!isset($error_message)){
    //no error loading database
    foreach($rdb as $dname => $dlist){
        echo '<h3 id="' . $dname . '">' . strtoupper(substr($dname, 0, 1)) . substr($dname, 1) . '</h3>
            <table class="nowtable">';
        
        foreach ($dlist as $dcritter){
            
            
            //Modulo is required to wrap around the Southern Hemisphere data.
            //The -1 and +1 mess is required because month 12 (December) mod 12 results in month 0, which doesn't exist.
            if (in_array($hoffset + (date("n") - 1) % 12 + 1, $dcritter -> months)){
                //available this month

                $hourstring = timeprint($dcritter -> hours);

                $dleaving = false;
                $dnew = false;
                if (!in_array($hoffset + date("n") % 12 + 1, $dcritter -> months)){
                    $dleaving = true;
                }
                if (!in_array($hoffset + (date("n") - 2) % 12 + 1, $dcritter -> months)){
                    $dnew = true;
                }


                echo '<tr class="' . ($dleaving ? 'nowleaving' : '') . ' ' . ($dnew ? 'nownew' : '') . '">
                    <td style="position: relative;">';
                if ($dleaving){
                    //leaving next month
                    echo '<img class="nowicon" src="/images/icon-leaving.png" alt="Leaving" title="Leaving next month" />';
                }
                if ($dnew && !$dleaving){
                    //new this month (unless this is the ONLY month of availability)
                    echo '<img class="nowicon" src="/images/icon-new.png" alt="New" title="New this month" />';
                }

                echo '<img src="/images/';
                    if (file_exists('../images/' . $dname . '/' . $dcritter -> name . '.png')){
                        echo rawurlencode($dname) . '/' . rawurlencode($dcritter -> name) . '.png';
                    }else{
                        echo 'noimage.png';
                    }
                    echo '" alt="' . htmlspecialchars($dcritter -> name) . '" class="nowpic" />
                </td>
                <td><strong>' . htmlspecialchars($dcritter -> name) . '</strong></td>
                <td style="white-space: nowrap;">' . $hourstring . '</td>' .
                (isset($dcritter -> location) ? '<td>' . htmlspecialchars($dcritter -> location) . '</td>' : '') .
                (isset($dcritter -> shadow) ? '<td>' . $shadowsizes[$dcritter -> shadow] . '</td>' : '') .
                //(isset($dcritter -> price) ? '<td style="text-align: right;">' . number_format($dcritter -> price) . '</td>' : '') .

                '</tr>';

                
            }
            
        }
        echo '</table>';
    }
}
?>

<?php require_once("../includes/footer.php"); ?>