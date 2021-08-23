<?php
if($options->Editors == '1'){
 Typecho_Plugin::factory('admin/write-post.php')->richEditor = array('BearEditor_Plugin', 'Editor');
        Typecho_Plugin::factory('admin/write-page.php')->richEditor = array('BearEditor_Plugin', 'Editor');
class BearEditor_Plugin{
      /**
     * 插入编辑器
     */
    public static function Editor()
    {
        
        echo <<<EOF
<link href="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
<script>
var simplemde = new SimpleMDE({ 
element: $("#text")[0] ,
autoDownloadFontAwesome:true,
autofocus: true,
hideIcons: ["guide"],
autosave: {
		enabled: true,
		uniqueId: "text",
		delay: 1000,
	},
	parsingConfig: {
		allowAtxHeaderWithoutSpace: true,
		strikethrough: false,
		underscoresBreakWords: true,
	},
	renderingConfig:{
	singleLineBreaks:true,
	codeSyntaxHighlighting:true,
	},
	showIcons: ["code", "table","fullscreen","bold","ordered-list","clean-block","side-by-side","fullscreen","heading-1","heading-2","heading-3","heading-bigger","heading-smaller","strikethrough","unordered-list"],
placeholder: "随心记录，简洁无极限~",
lineWrapping: true,
});
</script>
EOF;
    }
}
}