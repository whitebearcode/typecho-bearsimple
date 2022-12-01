<?php
function AssetsDir(){
    $options1 = bsOptions::getInstance()::get_option( 'bearsimple' );
    $options = Helper::options();
    if($options1['Assets'] == '1' || $options1['Assets'] == null){
        $dir = $options->themeUrl.'/';
    }
    else if($options1['Assets'] == '2'){
        $dir = 'https://deliver.application.pub/gh/whitebearcode/typecho-bearsimple@v'.themeVersion().'/';
    }
    else{
        $dir = $options1['Assets_Custom'];
    }
    echo $dir;
}

function AssetsDir2(){
   $options = Helper::options();
        $dir = $options->themeUrl.'/';
   
    echo $dir;
}

function AssetsDir_Backend(){
    $options1 = bsOptions::getInstance()::get_option( 'bearsimple' );
    $options = Helper::options();
    if($options1['Assets'] == '1' || $options1['Assets'] == null){
        $dir = $options->themeUrl.'/';
    }
    else if($options1['Assets'] == '2'){
        $dir = 'https://deliver.application.pub/gh/whitebearcode/typecho-bearsimple@v'.themeVersion().'/';
    }
    else{
        $dir = $options1['Assets_Custom'];
    }
    return $dir;
}