<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('safe_mode', 'off');

require 'opinion.class.php';
require 'inc/class/class.twittersearch.php';

/*sentiment shit*/
$op = new Opinion();
$op->addToIndex('opinion/rt-polaritydata/rt-polarity.neg', 'neg');
$op->addToIndex('opinion/rt-polaritydata/rt-polarity.pos', 'pos');


$twt = new TwitterSearch;

$param = array('lang' => 'en');
$s = $twt->search('redbull', $param);

foreach ($s as $item) {
    $sent = $op->classify($item->text);
    if ($sent == 'pos') {
        echo "Classifying '$item->text' - " . $sent  . "\n<br />";   
    }
}
/*$op = new Opinion();
$op->addToIndex('opinion/rt-polaritydata/rt-polarity.neg', 'neg', 5000);
$op->addToIndex('opinion/rt-polaritydata/rt-polarity.pos', 'pos', 5000);
$i = 0; $t = 0; $f = 0;
$fh = fopen('opinion/rt-polaritydata/rt-polarity.neg', 'r');
while($line = fgets($fh)) {
        if($i++ > 5001) {
                if($op->classify($line) == 'neg') {
                        $t++;
                } else {
                        $f++;
                }
        }
}
echo "Accuracy: " . ($t / ($t+$f));
*/




?>