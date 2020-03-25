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
<p>The current month is <strong><?= date("F") ?></strong>. Green is new this month. Red is leaving next month.</p>
<?php
if (!isset($error_message)){
    //no error loading database
    //print_r($rdb);
    foreach($rdb as $dname => $dlist){
        echo '<div class="critterlist"><h3>' . $dname . '</h3>';
        foreach ($dlist as $dcritter){

            //Modulo is required to wrap around the Southern Hemisphere data.
            //The -1 and +1 mess is required because month 12 (December) mod 12 results in month 0, which doesn't exist.
            if (in_array($hoffset + (date("n") - 1) % 12 + 1, $dcritter -> months)){
                //available this month
                echo '<span style="';
                if (!in_array($hoffset + date("n") % 12 + 1, $dcritter -> months)){
                    //leaving next month
                    echo 'color: #F00; ';
                }
                if (!in_array($hoffset + (date("n") - 2) % 12 + 1, $dcritter -> months)){
                    //new this month (unless this is the ONLY month of availability)
                    echo 'background-color: #7F7; ';
                }
                //still in next month
                echo '">' . htmlspecialchars($dcritter -> name) . '</span><br />';

                
            }
        }
        echo '</div>';
    }
}
?>

<?php require_once("../includes/footer.php"); ?>