<?php  
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
ob_clean();
error_reporting(0);
$options = Typecho_Widget::widget('Widget_Options');
$str = explode(",",$options->cutimage_domain);
$domain = parse_url($_GET['img']);
if(in_array($domain['host'],$str)){ 
    $phtypes=array('img/gif', 'img/jpg', 'img/jpeg', 'img/bmp', 'img/pjpeg', 'img/x-png'); 
    function compressImg($Image,$Dw,$Dh,$Type){  
                $Img =@imagecreatefromstring($Image);  

    IF(Empty($Img)){  
        return false;  
    }  
    IF($Type==1){  
        $w=ImagesX($Img);  
        $h=ImagesY($Img);  
        $width = $w;  
        $height = $h;  
        IF($width>$Dw){  
            $Par=$Dw/$width;  
            $width=$Dw;  
            $height=$height*$Par;  
            IF($height>$Dh){  
                $Par=$Dh/$height;  
                $height=$Dh;  
                $width=$width*$Par;  
            }  
        } ElseIF($height>$Dh) {  
            $Par=$Dh/$height;  
            $height=$Dh;  
            $width=$width*$Par;  
            IF($width>$Dw){  
                $Par=$Dw/$width;  
                $width=$Dw;  
                $height=$height*$Par;  
            }  
        } Else {  
            $width=$width;  
            $height=$height;  
        }  
        $nImg =ImageCreateTrueColor($width,$height);
        ImageCopyReSampled($nImg,$Img,0,0,0,0,$width,$height,$w,$h);
        ImageJpeg($nImg);
        return true;  
    } Else {
        $w=ImagesX($Img);  
        $h=ImagesY($Img);  
        $width = $w;  
        $height = $h;  
        $nImg =ImageCreateTrueColor($Dw,$Dh);  
        IF($h/$w>$Dh/$Dw){
            $width=$Dw;  
            $height=$h*$Dw/$w;  
            $IntNH=$height-$Dh;  
            ImageCopyReSampled($nImg, $Img, 0, -$IntNH/1.8, 0, 0, $Dw, $height, $w, $h);  
        } Else {
            $height=$Dh;  
            $width=$w*$Dh/$h;  
            $IntNW=$width-$Dw;  
            ImageCopyReSampled($nImg, $Img,-$IntNW/1.8,0,0,0, $width, $Dh, $w, $h);  
        }  
        ImageJpeg($nImg);  
        return true;  
    }  
};  

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

$imgPath = $_GET["img"]; 
header('Content-Type: image/jpeg');  
$bigImg=file_get_contents($imgPath, false , stream_context_create($arrContextOptions));
compressImg($bigImg,547,230,2);
} 
else{
$message['code'] = 0;
$message['message'] = 'Error';
exit(json_encode($message));
}