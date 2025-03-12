<?php
    /**
    * Steam
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$loader = Bsoptions('Lazyload_style');?>
<?php $this->need('compoment/head.php');?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/css/modules/steam/style.css?v=<?php echo themeVersion(); ?>">
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
               <div class="page-card">
                <h2><i class="steam icon"></i><?php $this->title() ?></h2><br>   

  <div class="loading-sticks positioning" id="simpleLoading" style="display:none">
  <div class="loading"></div>
  <div class="loading"></div>
  <div class="loading"></div>
</div>


  <div class="steamContainer" style="display:none">

 <div class="userProf">
<div class="leftSide">
  <div class="avatar_b">
   <span></span>
   <badge></badge>
   <div class="wrapp">
    <img src="" alt="">
   </div>
  </div>
  <div class="userTitle">
   <h1><a target="_blank"></a>
</h1>
   <div class="userDesc">
           <div class="userlevel"></div>
    <div class="userhave"></div>
 
   </div>

  </div>
	</div>

 </div>
	<div class="userGames">
		<div class="gamesTitle">
				<h3><i class="gamepad icon"></i> 游戏库 ¬</h3>
		</div>
	 <div class="steamgames-container games">
		</div>
		
	
	</div>

</div></div>
      <script>
let steamId = "<?php echo Bsoptions('steamId');?>";
let userProf = $(".userProf");
let userImg = $(".avatar_b");
let userDesc = $(".userDesc");
let userTitle = $(".userTitle");
let gamesList = $('.games');
let badge = $('.avatar_b badge');
$("#simpleLoading").show();
$.getJSON("https://steam.typecho.co.uk/steam/api?type=profile&steamid=" + steamId, function (resp) {
    userImg.children(".wrapp").children("img").attr("src", resp.avatarfull);
    userTitle.children("h1").children("a").attr("href", resp.profileurl);
    userTitle.children("h1").children("a").html(resp.personaname);
    if(resp.personastate == 1){
     badge.css('background-color', 'green');   
    }
    else if(resp.personastate == 2){
     badge.css('background-color', 'yellow');   
    }
    else{
     badge.css('background-color', 'gray');   
    }
});

$.getJSON("https://steam.typecho.co.uk/steam/api?type=level&steamid=" + steamId, function (resp) {
    userDesc.children(".userlevel").html("Lv"+resp.response.player_level);    
});
$.getJSON("https://steam.typecho.co.uk/steam/api?type=games&steamid=" + steamId, function (resp) {
     $("#simpleLoading").fadeOut();
      $(".steamContainer").fadeIn();
    if(!resp.response.game_count){
    userDesc.children(".userhave").html("共拥有 0 款游戏");    
    }
    else{
    userDesc.children(".userhave").html("共拥有 "+resp.response.game_count+" 款游戏");
    }
    for (let i = 0;i<9999;i++) {
      let games = resp.response.games[i];
      if(games){
      if(games.playtime_forever == 0){
       games.playtime_forever = "还没玩过";   
      }
      else{
        games.playtime_forever = '玩了'+games.playtime_forever+'分钟';
      }
      gamesList.append('<div class="steamgames-card"><div class="image-wrapper"><img src="https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/'+games.appid+'/header.jpg" onerror="loadDefaultImage(this)" loading="lazy"></div><div class="details"><div><a class="title">'+games.name+'</a></div><div><a class="sub-title">'+games.playtime_forever+'</a></div></div></div>');
 
    
    }
}
});
function loadDefaultImage(imgElement) {
  imgElement.src = '<?php AssetsDir();?>assets/css/modules/steam/nocover.jpg';
}
    </script>


       </div> 
</div>


<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>