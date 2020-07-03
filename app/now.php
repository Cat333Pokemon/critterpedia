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
$dbs = ["bugs","fish","sea"];
require_once("../includes/header.php"); 

?>
<p>Green rows with a <q>New</q> icon are new this month.<br />
    Yellow rows with a warning icon are leaving next month.
</p>
<p><strong>Month:</strong>
    <select disabled>
<?php
        for($i = 1; $i <= 12; $i++){
            echo '<option value="' . $i . '"' . ($i == date("n") ? ' selected' : '') . '>' . date("F", mktime(null, null, null, $i)) . "</option>\r\n";
        } ?>
    </select> (not added yet)</p>
<p><strong>Sort:</strong> <a href="#">Name</a> &bull; <a href="#">Location</a> &bull; <a href="#">New &amp; Leaving</a> (not added yet)</p>
<p><strong>Prices:</strong>
    <input type="radio" id="prhide" name="prices" checked onclick="var a=document.getElementsByClassName('price_col');for(var i=0;i<a.length;i++){a[i].style.display='none';}" /><label for="prhide"> Hidden</label> &nbsp;
    <input type="radio" id="prshow" name="prices" onclick="var a=document.getElementsByClassName('price_col');for(var i=0;i<a.length;i++){a[i].style.display='table-cell';}" /><label for="prshow"> Visible</label>
</p>
<?php
if (!isset($error_message)){
    //no error loading database
    foreach($rdb as $dname => $dlist){
        echo '<h3 id="' . $dname . '">' . strtoupper(substr($dname, 0, 1)) . substr($dname, 1) . '</h3>
            <table class="nowtable">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Time<br />Available</th>
                ' . (isset($dlist[0] -> movement) ? '<th>Movement</th>' : '') . '
                ' . (isset($dlist[0] -> location) ? '<th>Location</th>' : '') . '
                ' . (isset($dlist[0] -> shadow) ? '<th>Shadow<br />Size</th>' : '') . '
                ' . (isset($dlist[0] -> price) ? '<th class="price_col">Price</th>' : '') . '
            </tr>';
        
        foreach ($dlist as $dcritter){
            
            //Modulo is required to wrap around the Southern Hemisphere data.
            //The -1 and +1 mess is required because month 12 (December) mod 12 results in month 0, which doesn't exist.
            if (in_array(($hoffset + date("n") - 1) % 12 + 1, $dcritter -> months)){
                //available this month

                $hourstring = timeprint($dcritter -> hours);

                $dleaving = false;
                $dnew = false;
                if (!in_array(($hoffset + date("n")) % 12 + 1, $dcritter -> months)){
                    $dleaving = true;
                }
                if (!in_array(($hoffset + date("n") - 2) % 12 + 1, $dcritter -> months)){
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
                (isset($dcritter -> movement) ? '<td>' . htmlspecialchars($dcritter -> movement) . '</td>' : '') .
                (isset($dcritter -> location) ? '<td>' . htmlspecialchars($dcritter -> location) . '</td>' : '') .
                (isset($dcritter -> shadow) ? '<td>' . $shadowsizes[$dcritter -> shadow] . '</td>' : '') .
                (isset($dcritter -> price) ? '<td class="price_col">' . number_format($dcritter -> price) . '</td>' : '') .

                '</tr>';

                
            }
            
        }
        echo '</table>';
    }
}
?>

<?php require_once("../includes/footer.php"); ?>