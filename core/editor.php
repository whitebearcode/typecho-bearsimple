<?php

//根据Editormd进行魔改，仅对Bearsimple主题进行适配

if ($options->Editor == '1'){

    Typecho_Plugin::factory('Widget_Abstract_Contents')->content = array('BearEditor_Plugin', 'content');
  Typecho_Plugin::factory('Widget_Abstract_Contents')->excerpt = array('BearEditor_Plugin', 'excerpt');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('BearEditor_Plugin','footerJS');
        class BearEditor_Plugin{
             public static $count = 0;
       
    /**
     * 解析器
     */
    public static function footerJS($conent)
    {
    
        $options = Helper::options();
        $pluginUrl = $options->themeUrl.'/modules/EditorMD';
        $editormd = Typecho_Widget::widget('Widget_Options');
        if($editormd->emoji){
?>
<link rel="stylesheet" href="<?php echo $pluginUrl; ?>/css/emojify.min.css" />
<?php }if($editormd->Editor == 1 && $conent->isMarkdown){ ?>
<script type="text/javascript">
    window.jQuery || document.write(unescape('%3Cscript%20type%3D%22text/javascript%22%20src%3D%22<?php echo $pluginUrl; ?>/lib/jquery.min.js%22%3E%3C/script%3E'));
</script>
<?php }if($editormd->Editor == 1 && $conent->isMarkdown){ ?>
<script src="<?php echo $pluginUrl; ?>/lib/marked.min.js"></script>
<script src="<?php echo $pluginUrl; ?>/js/editormd.min.js"></script>
<?php if($editormd->Editor == 1){ ?>
<script src="<?php echo $pluginUrl; ?>/lib/raphael.min.js"></script>
<script src="<?php echo $pluginUrl; ?>/lib/underscore.min.js"></script>
<?php } if($editormd->Editor == 1){ ?>
<script src="<?php echo $pluginUrl; ?>/lib/flowchart.min.js"></script>
<script src="<?php echo $pluginUrl; ?>/lib/jquery.flowchart.min.js"></script>
<?php } if($editormd->Editor == 1){ ?>
<script src="<?php echo $pluginUrl; ?>/lib/sequence-diagram.min.js"></script>
<?php }}if($editormd->Editor){ ?>
<script src="<?php echo $pluginUrl; ?>/js/emojify.min.js"></script>
<?php }if($editormd->Editor||($editormd->isActive == 1 && $conent->isMarkdown)){?>
<script type="text/javascript">
$(function() {
<?php if($editormd->Editor == 1 && $conent->isMarkdown){ ?>
    var parseMarkdown = function () {
        var markdowns = document.getElementsByClassName("md_content");
        $(markdowns).each(function () {
            var markdown = $(this).children("#append-test").text();
            //$('#md_content_'+i).text('');
            var editormdView;
            editormdView = editormd.markdownToHTML($(this).attr("id"), {
                markdown: markdown,//+ "\r\n" + $("#append-test").text(),
                toolbarAutoFixed: false,
                htmlDecode: true,
                emoji: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                tex: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                toc: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                tocm: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                taskList: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                flowChart: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
                sequenceDiagram: <?php echo $editormd->Editor ? 'true' : 'false'; ?>,
            });
        });
    };
    parseMarkdown();
    $(document).on('pjax:complete', function () {
        parseMarkdown()
        
        if (typeof Prism !== 'undefined') {
        //为了方便将默认语言设为php
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = 'line-numbers language-php';document.getElementsByTagName('code').className  = 'language-php'; }
        Prism.highlightAll(true,null);
    }
    
    });
<?php }if($editormd->Editor){ ?>
    emojify.setConfig({
        img_dir: "//cdn.staticfile.org/emoji-cheat-sheet/1.0.0",
        blacklist: {
            'ids': [],
            'classes': ['no-emojify'],
            'elements': ['^script$', '^textarea$', '^pre$', '^code$']
        },
    });
    emojify.run();
<?php }
if(isset(Typecho_Widget::widget('Widget_Options')->plugins['activated']['APlayer'])){
    ?>
    var len = aPlayerOptions.length;
    for(var ii=0;ii<len;ii++){
        aPlayers[ii] = new APlayer({
            element: document.getElementById('player' + aPlayerOptions[ii]['id']),
            narrow: false,
            autoplay: aPlayerOptions[ii]['autoplay'],
            showlrc: aPlayerOptions[ii]['showlrc'],
            music: aPlayerOptions[ii]['music'],
            theme: aPlayerOptions[ii]['theme']
        });
        aPlayers[ii].init();
    }

    <?php
}
?>
});
</script>
<?php
}
    }
  
    public static function content($text, $conent){
      
        self::$count++;
        $editormd = Typecho_Widget::widget('Widget_Options');
        $text = $conent->isMarkdown ? ($editormd->Editor == 1?$text:$conent->markdown($text))
            : $conent->autoP($text);
         if(strpos($text,'![') !== false){
             return $conent->markdown($text);
         }
        if($editormd->Editor == 1 && $conent->isMarkdown && strpos($text,'h2') == false  && strpos($text,'```') == false  && !$conent->is('page','links'))
            return '<div id="md_content_'.self::$count.'" class="md_content" style="min-height: 50px;"><textarea id="append-test" style="display:none;">'.$text.'</textarea></div>';
        
        else{
            return $conent->markdown($text);
    }
    
    }
 
    
    public static function excerpt($text, $conent){
       
    
     
    
        self::$count++;
        $text = $conent->isMarkdown ? $conent->markdown($text)
            : $conent->autoP($text);
        return $text;
    }
  
        
}
}