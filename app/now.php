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
    //print_r($rdb);
    foreach($rdb as $dname => $dlist){
        echo '<h3>' . $dname . '</h3>
            <ul>';
        
        //echo '<div class="critterlist"><h3>' . $dname . '</h3>';
        foreach ($dlist as $dcritter){
            
            
            //Modulo is required to wrap around the Southern Hemisphere data.
            //The -1 and +1 mess is required because month 12 (December) mod 12 results in month 0, which doesn't exist.
            if (in_array($hoffset + (date("n") - 1) % 12 + 1, $dcritter -> months)){
                //available this month

                $hourstring = timeprint($dcritter -> hours);


                echo '<li class="critterlist" style="position: relative;">';
                if (!in_array($hoffset + date("n") % 12 + 1, $dcritter -> months)){
                    //leaving next month
                    echo '<span style="position: absolute; right: -8px; top: -10px;"><img src="/images/icon-leaving.png" alt="Leaving" title="Leaving next month" /></span>';
                }
                if (!in_array($hoffset + (date("n") - 2) % 12 + 1, $dcritter -> months)){
                    //new this month (unless this is the ONLY month of availability)
                    echo '<span style="position: absolute; left: -8px; top: -10px;"><img src="/images/icon-new.png" alt="New" title="New this month" /></span>';
                }

                echo '<img src="/images/';
                if (file_exists('../images/' . $dname . '/' . $dcritter -> name . '.png')){
                    echo rawurlencode($dname) . '/' . rawurlencode($dcritter -> name) . '.png';
                }else{
                    echo 'noimage.png';
                }
                echo '" alt="' . htmlspecialchars($dcritter -> name) . '" />
                    <h3>' . htmlspecialchars($dcritter -> name) . '</h3>
                    <p>' . $hourstring . '</p>';

                //echo '<span style="';

                //still in next month
                //echo '">' . htmlspecialchars($dcritter -> name) . '</span><br />';

                echo '</li>';

                
            }
            
        }
        echo '</ul>';
        //echo '</div>';
    }
}
?>

<?php require_once("../includes/footer.php"); ?>