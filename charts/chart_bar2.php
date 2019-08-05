<?php
require_once '../data/db.php';
require_once '../OpenChart/php-ofc-library/open-flash-chart.php';
require_once "../lang/no_nb.php";


$title = new title(utf8_encode($_GET['title']));
$data_0 = explode(",", $_GET['values']);
$data_2 = explode(",", utf8_encode($_GET['x_axis']));

if($_GET['reverse']!="no") {
$data_0 = array_reverse($data_0);
$data_2 = array_reverse($data_2);
}


foreach ($data_0 as $i => $value) {
    $data_1[$i] = intval($data_0[$i]);
 }


//$hol = new hollow_dot();
//$hol->size(3)->halo_size(1)->tooltip('#x_label#<br>#val#');

$line_1 = new bar();
//$line_1->set_default_dot_style($hol); 
$line_1->set_values($data_1);

$y = new y_axis();
$y->set_range(0, round((max($data_1)+max($data_1)/10),0), 0 );

$x = new x_axis();
$x->steps(1);
//$x->set_colour( '#000080' );
//$x->set_grid_colour( '#86BF83' );
$x->set_labels_from_array( $data_2 );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line_1 );
$chart->set_y_axis( $y );
$chart->set_x_axis( $x );

echo $chart->toPrettyString();
?>
