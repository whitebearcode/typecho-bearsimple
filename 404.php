<?php 
if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

?>

<?php $this->need('compoment/head.php');?>

  
 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if(Bsoptions('Animate') == "close" || Bsoptions('Animate') == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php echo Bsoptions('Animate') ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
              <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
              <center>
              <svg t="1619768611364" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1919" width="200" height="200"><path d="M841.554135 289.474752c-32.966703-13.322161-69.997795-24.386329-109.964278-32.966703-10.612569-113.351268-105.222492-202.316207-219.702757-202.316208-114.480265 0-209.090187 88.964939-219.702756 202.316208-39.966483 8.580375-76.997574 19.644542-109.964278 32.966703-97.093716 38.837486-150.382359 94.158324-150.382359 155.124145s53.514443 116.286659 150.382359 155.124146c88.513341 35.450496 205.703197 55.095039 329.667034 55.095039 123.963837 0 241.153693-19.644542 329.667035-55.095039 97.093716-38.837486 150.382359-94.158324 150.382359-155.124146s-53.288644-116.06086-150.382359-155.124145z m-329.441235-176.349283c78.35237 0 144.059978 57.127233 158.962734 132.544211-50.353252-7.451378-103.867696-11.289967-158.962734-11.289967-54.869239 0-108.383682 3.838589-158.736935 11.289967 14.676957-75.416979 80.158765-132.544212 158.736935-132.544211zM819.877398 545.531202c-81.739361 32.740904-191.02624 50.804851-307.764498 50.804851s-226.025138-18.063947-307.764499-50.804851c-71.126792-28.450717-113.577067-66.159206-113.577067-100.706505s42.450276-72.255788 113.577067-100.706505c81.739361-32.740904 191.02624-50.804851 307.764499-50.804851s226.025138 18.063947 307.764498 50.804851c71.126792 28.450717 113.577067 66.159206 113.577067 100.706505s-42.450276 72.029989-113.577067 100.706505z" p-id="1920" fill="#515151"></path><path d="M453.179272 135.931202c-27.547519 11.741566-50.804851 31.160309-67.514002 56.224035-5.419184 8.354576-3.161191 19.418743 4.967586 25.063727 3.161191 2.032194 6.548181 2.935391 9.93517 2.935391 5.870783 0 11.515766-2.935391 15.128556-8.128776 12.644763-19.192944 30.482911-34.0957 51.482249-43.127674 9.257773-3.838589 13.54796-14.451158 9.483573-23.70893-3.612789-8.806174-14.225358-13.096362-23.483132-9.257773zM516.403087 690.268578c-43.579272 0-74.513782 13.322161-94.384123 40.643881-17.838148 24.386329-25.741125 57.804631-25.741125 108.835281s7.902977 84.448953 25.741125 108.835281c19.870342 27.32172 50.804851 40.643881 94.384123 40.643881 43.579272 0 74.513782-13.322161 94.384124-40.643881 17.838148-24.386329 25.741125-57.804631 25.741124-108.835281s-7.902977-84.448953-25.741124-108.835281c-19.870342-27.32172-50.804851-40.643881-94.384124-40.643881z m0 240.250496c-37.031092 0-61.41742-6.322381-61.41742-90.771334 0-84.448953 24.386329-90.771334 61.41742-90.771334s61.41742 6.322381 61.41742 90.771334c-0.225799 84.448953-24.386329 90.771334-61.41742 90.771334zM333.054024 884.230209H305.280706v-164.607717-0.903198-1.580595c0-0.451599 0-0.903197-0.2258-1.354796 0-0.451599-0.225799-0.903197-0.225799-1.354796 0-0.451599-0.225799-1.128997-0.451599-1.580595 0-0.451599-0.225799-0.903197-0.225799-1.128997-0.225799-0.451599-0.225799-1.128997-0.451599-1.580595-0.225799-0.451599-0.225799-0.677398-0.451598-1.128997l-0.677398-1.354796-0.677398-1.354796c-0.225799-0.451599-0.451599-0.903197-0.677398-1.128997-0.225799-0.451599-0.451599-0.903197-0.903198-1.354796-0.225799-0.451599-0.451599-0.677398-0.677398-1.128997-0.225799-0.451599-0.677398-0.903197-0.903197-1.354796-0.225799-0.225799-0.451599-0.677398-0.903198-0.903197-0.451599-0.451599-0.677398-0.903197-1.128996-1.128997l-0.903198-0.903197c-0.451599-0.225799-0.677398-0.677398-1.128996-0.903197-0.451599-0.451599-0.903197-0.677398-1.354796-1.128997-0.225799-0.225799-0.451599-0.451599-0.677398-0.451599 0 0-0.225799 0-0.2258-0.225799-0.451599-0.451599-1.128997-0.677398-1.580595-0.903198-0.225799-0.225799-0.677398-0.451599-0.903197-0.451598-0.451599-0.225799-1.128997-0.451599-1.580596-0.903198-0.451599-0.225799-0.677398-0.451599-1.128996-0.451598-0.451599-0.225799-0.903197-0.451599-1.580596-0.677398-0.451599-0.225799-0.903197-0.225799-1.354796-0.451599-0.451599-0.225799-0.903197-0.225799-1.354796-0.451599-0.451599-0.225799-0.903197-0.225799-1.580595-0.451598-0.451599 0-0.677398-0.225799-1.128997-0.2258-0.677398 0-1.128997-0.225799-1.806395-0.225799H275.475193h-2.709592c-0.451599 0-0.903197 0-1.354796 0.225799-0.451599 0-0.903197 0.225799-1.354796 0.2258-0.451599 0-1.128997 0.225799-1.580596 0.451598-0.451599 0-0.903197 0.225799-1.128996 0.2258-0.451599 0.225799-1.128997 0.225799-1.580596 0.451598-0.451599 0.225799-0.677398 0.225799-1.128996 0.451599l-1.354796 0.677398c-0.451599 0.225799-0.903197 0.451599-1.128997 0.677398-0.451599 0.225799-0.903197 0.451599-1.128997 0.677398-0.451599 0.225799-0.903197 0.451599-1.354796 0.903198-0.451599 0.225799-0.677398 0.451599-1.128996 0.677398-0.451599 0.225799-0.903197 0.677398-1.354796 0.903197-0.225799 0.225799-0.677398 0.451599-0.903198 0.903197l-1.128997 1.128997-0.903197 0.903197c-0.225799 0.451599-0.677398 0.677398-0.903197 1.128997-0.451599 0.451599-0.677398 0.903197-1.128997 1.354796-0.225799 0.225799-0.451599 0.451599-0.451599 0.677398l-137.737596 193.961632c-6.322381 9.031974-7.225579 20.773539-2.257993 30.48291s15.128556 15.805954 26.192723 15.805954h108.383682v16.934951c0 16.257552 13.096362 29.353914 29.353914 29.353914s29.353914-13.096362 29.353914-29.353914V942.938037h27.773319c16.257552 0 29.353914-13.096362 29.353914-29.353914s-12.870562-29.353914-29.128115-29.353914z m-137.963396 0l51.48225-72.481587V884.230209H195.090628zM885.810805 884.230209H858.037486v-164.607717-0.903198-1.580595c0-0.451599 0-0.903197-0.225799-1.354796 0-0.451599-0.225799-0.903197-0.225799-1.354796 0-0.451599-0.225799-1.128997-0.451599-1.580595 0-0.451599-0.225799-0.903197-0.225799-1.128997-0.225799-0.451599-0.225799-1.128997-0.451599-1.580595-0.225799-0.451599-0.225799-0.677398-0.451599-1.128997l-0.677398-1.354796-0.677398-1.354796c-0.225799-0.451599-0.451599-0.903197-0.677398-1.128997-0.225799-0.451599-0.451599-0.903197-0.903197-1.354796-0.225799-0.451599-0.451599-0.677398-0.677398-1.128997-0.225799-0.451599-0.677398-0.903197-0.903198-1.354796-0.225799-0.225799-0.451599-0.677398-0.903197-0.903197-0.451599-0.451599-0.677398-0.903197-1.128997-1.128997l-0.903197-0.903197c-0.451599-0.225799-0.677398-0.677398-1.128997-0.903197-0.451599-0.451599-0.903197-0.677398-1.354796-1.128997-0.225799-0.225799-0.451599-0.451599-0.677398-0.451599 0 0-0.225799 0-0.225799-0.225799-0.451599-0.451599-1.128997-0.677398-1.580595-0.903198-0.225799-0.225799-0.677398-0.451599-0.903198-0.451598-0.451599-0.225799-1.128997-0.451599-1.580595-0.677398-0.451599-0.225799-0.677398-0.451599-1.128997-0.451599-0.451599-0.225799-0.903197-0.451599-1.354796-0.451599-0.451599-0.225799-0.903197-0.225799-1.354796-0.451598-0.451599-0.225799-0.903197-0.225799-1.354796-0.451599-0.451599-0.225799-1.128997-0.225799-1.580595-0.451599-0.451599 0-0.677398-0.225799-1.128997-0.225799-0.677398 0-1.128997-0.225799-1.806395-0.225799h-2.935391-2.709592c-0.451599 0-0.903197 0-1.354796 0.225799-0.451599 0-0.903197 0.225799-1.354796 0.225799-0.451599 0-1.128997 0.225799-1.580596 0.2258-0.451599 0-0.903197 0.225799-1.128996 0.225799-0.451599 0.225799-1.128997 0.225799-1.580596 0.451599-0.451599 0.225799-0.903197 0.225799-1.128996 0.451598l-1.354796 0.677398-1.354796 0.677398c-0.451599 0.225799-0.903197 0.451599-1.128997 0.677398-0.451599 0.225799-0.903197 0.451599-1.354796 0.903198-0.451599 0.225799-0.677398 0.451599-1.128997 0.677398-0.451599 0.225799-0.903197 0.677398-1.354796 0.903197-0.225799 0.225799-0.677398 0.451599-0.903197 0.903198-0.451599 0.451599-0.903197 0.677398-1.128997 1.128996l-0.903197 0.903198c-0.225799 0.451599-0.677398 0.677398-0.903198 1.128996-0.451599 0.451599-0.677398 0.903197-1.128996 1.354796-0.225799 0.225799-0.451599 0.451599-0.451599 0.677398l-137.737596 193.961632c-6.322381 9.031974-7.225579 20.773539-2.257994 30.482911 4.967585 9.709372 15.128556 15.805954 26.192723 15.805954h108.383683v16.93495c0 16.257552 13.096362 29.353914 29.353914 29.353914s29.353914-13.096362 29.353914-29.353914V942.938037h27.773319c16.257552 0 29.353914-13.096362 29.353914-29.353914s-12.870562-29.353914-29.128115-29.353914z m-138.189195 0l51.482249-72.481587V884.230209h-51.482249z" p-id="1921" fill="#515151"></path><path d="M512.1129 344.118192m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1922" fill="#515151"></path><path d="M291.281147 373.472106m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1923" fill="#515151"></path><path d="M291.281147 499.016538m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1924" fill="#515151"></path><path d="M512.1129 541.241014m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1925" fill="#515151"></path><path d="M732.718853 373.472106m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1926" fill="#515151"></path><path d="M732.718853 499.016538m-29.353914 0a29.353914 29.353914 0 1 0 58.707828 0 29.353914 29.353914 0 1 0-58.707828 0Z" p-id="1927" fill="#515151"></path></svg>
              <div class="error-page">
            <h2 class="post-title">404 - <?php _e('页面没找到'); ?></h2>
            <p><?php _e('你想查看的页面已被转移或删除了, 要不要搜索看看: '); ?></p>
            <form method="post" class="ui form">
     
   <div class="ui big icon input">
  <input type="text"  name="s" placeholder="输入关键词">
  <i class="search icon"></i>
</div>
                <p>
                <button  class="ui primary button" type="submit" class="submit" >
  搜索
</button></p>
                
            </form>
        </div>
              
  </center>
</div></div>



 
  
<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>