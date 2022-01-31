<?php
require '../vendor/autoload.php';

$muxconvert = new \askuri\MuxConvert\MuxConvert(file_get_contents('input.mux'));
file_put_contents('output.ogg', $muxconvert->mux2ogg());
