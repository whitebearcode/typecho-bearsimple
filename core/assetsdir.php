<?php
function AssetsDir(){
    $options = Helper::options();
    if($options->Assets == '1' || $options->Assets == null){
        $dir = '/usr/themes/bearsimple/';
    }
    else{
        $dir = $options->Assets_Custom;
    }
    echo $dir;
}
