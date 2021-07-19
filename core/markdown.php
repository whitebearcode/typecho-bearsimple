<?php
$options = Typecho_Widget::widget('Widget_Options');
if ($options->Markdown == '1'){

    require_once dirname(dirname(__FILE__)).'/modules/markdown/ParsedownExtension.php';;
Typecho_Plugin::factory('Widget_Abstract_Contents')->markdown = ['Markdown_Plugin', 'parse'];
        Typecho_Plugin::factory('Widget_Abstract_Comments')->markdown = ['Markdown_Plugin', 'parse'];
        Typecho_Plugin::factory('Widget_Archive')->footer             = ['Markdown_Plugin', 'resourceLink'];


class Markdown_Plugin{

        public static function parse($text)
    {
        $markdownParser              = ParsedownExtension::instance();
        $markdownParser->isTocEnable = Helper::options()->is_available_toc;

        return $markdownParser->setBreaksEnabled(true)->text($text);
    }

    public static function resourceLink()
    {
        $markdownParser     = ParsedownExtension::instance();
        $isAvailableMermaid = $markdownParser->isNeedMermaid && Helper::options()->is_available_mermaid;
        $isAvailableMathjax = $markdownParser->isNeedLaTex && Helper::options()->is_available_mathjax;

        $resourceContent = '';

        if ($isAvailableMermaid) {
            $resourceContent .= '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mermaid@8/dist/mermaid.min.js"></script>';
            $resourceContent .= '<script type="text/javascript">(function(){mermaid.initialize({startOnLoad:true})})();</script>';
        }

        if ($isAvailableMathjax) {
            $resourceContent .= '<script type="text/javascript">(function(){MathJax={tex:{inlineMath:[[\'$\',\'$\'],[\'\\\\(\',\'\\\\)\']]}}})();</script>';
            $resourceContent .= '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.min.js"></script>';
        }

        echo $resourceContent;
    }
}
}
