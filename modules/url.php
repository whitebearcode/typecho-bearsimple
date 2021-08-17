<?php 
    $url = [];
foreach (getLink() as $key=>$Links){
    $url[$Links[0]]=$Links[1];
}
return $url;
?>
