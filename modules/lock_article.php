<bearsimple id="bearsimple-images"></bearsimple>
<bearsimple id="bearsimple-images-readmode"></bearsimple>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
                    
                    <div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="exclamation triangle icon"></i>
    <?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
    <?php while ($categorys->next()): ?> <?php if ($this->category ==
$categorys->slug):?>
<?php $slug_name = $categorys->name; ?>
<?php $slug = $categorys->slug; ?>
<?php endif; ?>
<?php endwhile; ?>
    当前文章所属分类「<?php echo $slug_name; ?>」已被加密！
    <?php if(!empty(CategoryEncrypt(categeid($slug))['Cate_Encrypt_Note'])):?>
 <br>
   <small><i class="question circle large icon" style="display:inline-block;margin:auto"></i> <?php echo CategoryEncrypt(categeid($slug))['Cate_Encrypt_Note']; ?></small>  <?php endif; ?>
  </div>
  <div class="ui form">
  <div class="field">
    <label>请输入该分类的访问密码：</label>
    <input type="password" id="open_password" placeholder="请输入访问密码">
  </div>
  <div class="ui button" id="encryptsubmit">提交</div>
</div>
</div>
                    
                    </div></div>
                    
                    <script>
                        $('#encryptsubmit').on('click',function(){
                            $.ajax({
                        type: "POST",
                        url: "<?php getEncrypt(); ?>",
                        data: {
                            "action": 'open_lock',
                            "password": $('#open_password').val(),
                            "encryptpassword":'<?php echo $_POST['data']['md5_password']?>',
                            "type": '<?php echo $_POST['data']['type']?>',
                            "category": '<?php echo $_POST['data']['category']?>',
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
                            if (json.code == "1"){
               $('body')
										.toast({
							    title:'Ohhh~',
							    class: 'green',
							    message: '密码验证成功，两秒后自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
										});

                setTimeout(function (){
                    <?php if(Bsoptions('Pjax') == '1') :?>
                     $.pjax({ url: window.location.href, container: '#pjax', fragment: '#pjax',timeout: 50000});
                     <?php else:?>
                    window.location.reload();
                    <?php endif; ?>
                },2000);
            }else if (json.code == "-1"){
                $('body').toast({
							    title:'抱歉~',
							    class: 'warning',
							    message: '您输入的密码错误，请重试', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
            }else if (json.code == "-2"){
               $('body').toast({
							    title:'抱歉~',
							    class: 'warning',
							    message: '您尚未输入密码哦~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
            }
                        },
                        error: function() {
                            $('body')
							.toast({
							    title:'抱歉~',
							    class: 'warning',
							    message: '检测到您的网络环境异常，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
                        }
                    });
                        })
                    </script>