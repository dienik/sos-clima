<?php

$filename = "exemplo_abrigados.csv";

$headers = [
    'nome',
    'sobrenome',
    'cidade_origem',
    'abrigo'
];


header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . $filename . '"');


$output = fopen('php://output', 'w');


fputcsv($output, $headers);


fclose($output);

exit;
?>
