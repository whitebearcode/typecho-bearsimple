<?php

# 根据Parsedown进行修改适配Bearsimple主题

require_once 'ParsedownExtra.php';

class ParsedownExtension extends ParsedownExtra
{
    protected $findTocSyntaxRule     = '/^<p>\s*\[TOC\]\s*<\/p>$/m';
    protected $originalBlockRuleList = ['$' => '/\${1,2}[^`]*?\${1,2}/m'];
    protected $absoluteUrl           = '';

    private $isMatureTocEnable = false; // for performance
    private $rawTocList        = [];    // temp store

    public $isTocEnable   = false;
    public $isNeedMermaid = false;
    public $isNeedLaTex   = false;

    /**
     * Singleton Pattern
     *
     * @param  string  $name
     *
     * @return ParsedownExtension
     */
    public static function instance($name = 'default')
    {
        $instance = parent::instance($name);

        $instance->initInstance();

        return $instance;
    }

    /**
     * Set toc parse rule
     *
     * @param  string  $findTocSyntaxRule
     *
     * @return $this
     */
    public function setTocSyntaxRule($findTocSyntaxRule)
    {
        $this->findTocSyntaxRule = $findTocSyntaxRule;

        return $this;
    }

    /**
     * Set original block parse rule
     *
     * @param  array  $originalBlockRule
     *
     * @return $this
     */
    public function addOriginalBlockRule($originalBlockRule)
    {
        $this->originalBlockRuleList = array_merge($this->originalBlockRuleList, $originalBlockRule);

        return $this;
    }

    /**
     * Set absolute url for toc
     *
     * @param  string  $absoluteUrl
     *
     * @return $this
     */
    public function setAbsoluteUrl($absoluteUrl)
    {
        $this->absoluteUrl = $absoluteUrl;

        return $this;
    }

    /**
     * Parse text
     *
     * @param  string  $text
     *
     * @return string
     */
    public function text($text)
    {
        return $this->handleAfter(parent::text($this->handleBefore($text)));
    }

    /**
     * Hook before parse
     *
     * @param  string  $text
     *
     * @return string
     */
    protected function handleBefore($text)
    {
        // register elements handles
        array_map(function ($originalBlockMark) {
            $this->addInlineElements($originalBlockMark, ['Original']);
        }, array_keys($this->originalBlockRuleList));

        // init toc switch
        $this->isMatureTocEnable = $this->isTocEnable && preg_match('/\s*\[TOC\]\s*/m', $text);

        return $text;
    }

    /**
     * Hook after parse
     *
     * @param  string  $text
     *
     * @return string
     */
    protected function handleAfter($text)
    {
        if ($this->isMatureTocEnable) {
            $text = preg_replace($this->findTocSyntaxRule, $this->buildToc(), $text);
            // cleanup
            $this->rawTocList = [];
        }

        return $text;
    }

    /**
     * Build toc
     *
     * @return string
     */
    protected function buildToc()
    {
        if (empty($this->rawTocList)) {
            return '';
        }

        $tocMarkdownContent = '';
        $topHeadLevel       = min(array_column($this->rawTocList, 'level'));

        foreach ($this->rawTocList as $tocItem) {
            $tocMarkdownContent .= sprintf('%s- [%s](%s#%s)' . PHP_EOL, str_repeat('  ', $tocItem['level'] - $topHeadLevel), $this->line($tocItem['text']), $this->absoluteUrl, $tocItem['id']);
        }

        return parent::text($tocMarkdownContent);
    }

    /**
     * Add inline elements,applies the given handle list to the marker, handle function name like "inline{$handle}"
     *
     * @param  string  $inlineMarker
     * @param  array  $inlineHandleList
     *
     * @return $this
     */
    public function addInlineElements($inlineMarker, $inlineHandleList)
    {
        if (strpos($this->inlineMarkerList, $inlineMarker) === false) {
            $this->inlineMarkerList .= $inlineMarker;
        }

        $this->InlineTypes[$inlineMarker] = array_merge(isset($this->InlineTypes[$inlineMarker]) ? $this->InlineTypes[$inlineMarker] : [], is_array($inlineHandleList) ? $inlineHandleList : (array)$inlineHandleList);

        return $this;
    }

    /**
     * Add block elements, applies the given handle list to the marker, handle function name like "block{$handle}"
     *
     * @param  string  $blockMarker
     * @param  array  $blockHandleList
     *
     * @return $this
     */
    public function addBlockElements($blockMarker, $blockHandleList)
    {
        $this->BlockTypes[$blockMarker] = array_merge(isset($this->BlockTypes[$blockMarker]) ? $this->BlockTypes[$blockMarker] : [], is_array($blockHandleList) ? $blockHandleList : (array)$blockHandleList);

        return $this;
    }

    /**
     * Parse header
     *
     * @param $line
     *
     * @return array
     */
    protected function blockHeader($line)
    {
        $block = parent::blockHeader($line);

        if (!$this->isMatureTocEnable) {
            return $block;
        }

        $text = $block['element']['handler']['argument'];
        $id   = urlencode($this->line($text));

        $block['element']['attributes'] = [
            'id' => $id,
        ];

        $this->rawTocList[] = [
            'id'    => $id,
            'text'  => $text,
            'level' => str_replace('h', '', $block['element']['name']),
        ];

        return $block;
    }

    /**
     * Hook for mermaid
     *
     * @param $Line
     *
     * @return array
     */
    protected function blockFencedCode($Line)
    {
        $block = parent::blockFencedCode($Line);

        if ('language-mermaid' === (isset($block['element']['element']['attributes']['class']) ? $block['element']['element']['attributes']['class'] : '')) {
            $this->isNeedMermaid = true;
            $block['element']    = [
                'name'       => 'div',
                'attributes' => [
                    'class' => 'mermaid',
                ],
                'element'    => [
                    'text' => '',
                ],
            ];
        }

        return $block;
    }

    /**
     * Parse original
     *
     * @see https://github.com/mrgeneralgoo/typecho-markdown/pull/7
     *
     * @param  array  $excerpt
     *
     * @return array|null
     */
    protected function inlineOriginal($excerpt)
    {
        $originalBlockMark = substr($excerpt['text'], 0, 1);

        if (!isset($this->originalBlockRuleList[$originalBlockMark]) || !preg_match($this->originalBlockRuleList[$originalBlockMark], $excerpt['text'], $originalBlock) || empty($originalBlock[0])) {
            return null;
        }

        if ($originalBlockMark === '$') {
            $this->isNeedLaTex = true;
        }

        return $this->inlineText($originalBlock[0]);
    }
}
