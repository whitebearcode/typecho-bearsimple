<?php
/**
 * SecretComments私密评论插件，启动后请点开插件设置阅读必要手动配置
 * 
 * @package 隐私评论
 * @author 泽泽社长
 * @version 2.1.0
 * @link http://qqdie.com/
 */
class SecretComments_Plugin implements Typecho_Plugin_Interface
{ 
 public static function activate()
	{
        Typecho_Plugin::factory('Widget_Archive')->header = array('SecretComments_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Feedback')->comment = array('SecretComments_Plugin', 'Secret');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('SecretComments_Plugin', 'SecretText');
        return '插件启用成功，请点开插件设置阅读必要手动配置';
    }
	/* 禁用插件方法 */
	public static function deactivate(){
    return '已禁用，私密评论失去保护！！！';
    }
    public static function config(Typecho_Widget_Helper_Form $form){ 
      ?>
插件启动成功后，请将下面的代码放置到模板评论表单部分，一般放置在评论按钮前面即可，样式需要自行美化！
<xmp style="
    width: auto;
    margin: 5px 0;
    color: red;
    white-space: normal;
    background: #e8e8e8;
    padding: 10px;
    border-radius: 5px;
">
<input type="checkbox" name="is-private" id="PrivateComments"><label for="PrivateComments" class="PrivateCommentsLable">
隐私评论</label>
</xmp>
<?php
      
      
      	$style = new Typecho_Widget_Helper_Form_Element_Textarea('style', NULL, '', '自定义相关样式', '
        <div><b>为隐私评论提示书写样式</b>：只需为span.SecretComments书写对应css即可，如：<br>
        1，渐变样式
        <pre><code>span.SecretComments { display: block; background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%); padding: 8px; color: #fff; border-radius: 2px; margin: auto 0; text-align: center;}</code></pre>
        2，仿handsome提示样式<pre><code>span.SecretComments { background: repeating-linear-gradient(145deg,#f2f2f2,#f2f2f2 15px,#fff 0,#fff 30px); display: block; padding: 8px; color: #777; border-radius: 5px; margin: auto 0; text-align: center;}</code></pre></div>');
        $form->addInput($style);
    }
    
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    public static function header(){
      $ys=Typecho_Widget::widget('Widget_Options')->plugin('SecretComments')->style;
if($ys){    
?>
<style><?php echo $ys; ?></style>
<?php
    }
    }
  
  
    public static function Secret($comment, $post){
      if(!$_POST['is-private'])return $comment;
      $comment['text']='$私密$'.$comment['text'];//给隐私评论添加标记
      return $comment;
    }
   public static function SecretText($data, $obj,$last){
     $text = empty($last)?$data:$last;                                                                                                        
     $babaid=array();$babamail=array();//定义初始父级信息数组
     if($obj->parent>0){//如果拥有父级，则循环将所有父级信息加入数组
       $db = Typecho_Db::get();
       $parent = $obj->parent;            
            while ($parent > 0) {
                $parentRows = $db->fetchRow($db->select()->from('table.comments')
                ->where('coid = ? AND status = ?', $parent, 'approved')->limit(1));
                
                if (!empty($parentRows)) {
                    $coid = $parent;
                    $parent = $parentRows['parent'];
                  array_push($babaid,$parentRows['authorId']);
                  array_push($babamail,$parentRows['mail']);
                } else {
                    break;
                }
            }   
     }
     
     Typecho_Widget::widget('Widget_User')->to($user);//获取当前用户信息
     $stext =$text; 
      if(strpos($text,'$私密$') !== false){
     $stext = '<span class="SecretComments">该评论为私密评论，仅文章作者与评论发起者可见！</span>';//存在标记则定义个私密提示
     $text = str_replace("<p>\$私密\$</p>","",$text);
     $text = str_replace("\$私密\$","",$text);//私密评论显示时去掉标记
      }
      
     
 if (Typecho_Widget::widget('Widget_User')->hasLogin()){
   if($user->group=="administrator"||$user->group=="editor"||$user->uid==$obj->authorId||$user->uid==$obj->ownerId||in_array($user->uid,$babaid)){
     return $text;//如果用户是管理员或者编辑权限或者就是评论者本人或者就是文章作者直接返回评论内容不隐藏，如果用户id等于隐私评论爸爸或者比爸爸级别还高的时候可见
   }else{
     Helper::options()->commentsHTMLTagAllowed='<span class="SecretComments">'.Helper::options()->commentsHTMLTagAllowed;
     return $stext;}
}else{
$commentsMail = Typecho_Cookie::get('__typecho_remember_mail');
if(($obj->mail==$commentsMail && $obj->authorId==0)||(!empty($babamail) && in_array($commentsMail,$babamail))){return $text;//如果游客邮箱等于隐私评论的邮箱时直接返回内容不隐藏，如果游客邮箱等于隐私评论爸爸或者比爸爸级别还高的邮箱时可见
}else{
  Helper::options()->commentsHTMLTagAllowed='<span class="SecretComments">'.Helper::options()->commentsHTMLTagAllowed;
  return $stext;} 
 }  
     
     
   
   }

}
