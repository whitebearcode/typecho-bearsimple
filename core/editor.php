<?php

if ($options->Editor == '1'){
require_once 'markdown/ParsedownExtension.php';

Typecho_Plugin::factory('Widget_Abstract_Contents')->markdown = ['BearMarkdown_Plugin', 'parse'];
        Typecho_Plugin::factory('Widget_Abstract_Comments')->markdown = ['BearMarkdown_Plugin', 'parse'];
        Typecho_Plugin::factory('Widget_Archive')->footer             = ['BearMarkdown_Plugin', 'resourceLink'];
class BearMarkdown_Plugin{
     public static function parse($text)
    {
        $markdownParser              = ParsedownExtension::instance();
        $markdownParser->isTocEnable = 1;

        return $markdownParser->setBreaksEnabled(true)->text($text);
    }

    public static function resourceLink()
    {
        $markdownParser     = ParsedownExtension::instance();
        $isAvailableMermaid = $markdownParser->isNeedMermaid;
        $isAvailableMathjax = $markdownParser->isNeedLaTex;

        $resourceContent = '';

        if ($isAvailableMermaid) {
            $resourceContent .= '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mermaid@8/dist/mermaid.min.js"></script>';
            $resourceContent .= '<script type="text/javascript">(function(){mermaid.initialize({startOnLoad:true})})();</script>';
        }

        if ($isAvailableMathjax) {
            $resourceContent .= '<script type="text/javascript">(function(){MathJax={tex:{inlineMath:[[\'$\',\'$\'],[\'\\\\(\',\'\\\\)\']]}}})();
            $(document).on(\'pjax:complete\', function () {
            (function(){MathJax={tex:{inlineMath:[[\'$\',\'$\'],[\'\\\\(\',\'\\\\)\']]}}})();
            });
            </script>';
            $resourceContent .= '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.min.js"></script>
            <script>
            $(document).on(\'pjax:complete\', function () {
            $.getScript("https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.min.js");
            });
            </script>
            ';
        }

        echo $resourceContent;
    }
}
}