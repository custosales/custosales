<?php

include '../OpenChart/php-ofc-library/open-flash-chart.php';

$title = new title( 'Cows go mooo' );

$pie = new pie();
$pie->set_start_angle( 35 );
$pie->set_animate( true );
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_values( array(2,3,6,3,5,3) );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );


$chart->x_axis = null;

echo $chart->toPrettyString();

?>