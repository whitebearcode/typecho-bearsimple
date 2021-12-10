<?php
function AssetsDir(){
    $options = Helper::options();
    if($options->Assets == '1' || $options->Assets == null){
        $dir = $options->themeUrl.'/';
    }
    else if($options->Assets == '2'){
        $dir = 'https://cdn.jsdelivr.net/gh/whitebearcode/bearspace/';
    }
    else{
        $dir = $options->Assets_Custom;
    }
    echo $dir;
}

function AssetsDir2(){
   $options = Helper::options();
        $dir = $options->themeUrl.'/';
   
    echo $dir;
}