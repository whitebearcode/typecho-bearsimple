<?php

namespace TypechoPlugin\BsCore;

use \Typecho\{Widget};
use \Typecho\Widget\Helper\Form;
use \Typecho\Widget\Helper\Form\Element\{Text, Hidden, Submit, Textarea};


if (!defined('__TYPECHO_ROOT_DIR__')) exit;


class Console extends Widget
{
    /** 
     * 模板文件目录
     * 
     *  @var string 
     */
    private $_template_dir = __DIR__ . '/modules/MailServices/';

    /** 
     * 当前文件
     * 
     * @var string  
     */
    private $_currentFile;

    /**
     * 执行函数
     *
     * @return void
     * @throws \Typecho\Widget\Exception
     */
    public function execute()
    {
        $this->widget('Widget_User')->pass('administrator');
        $files = glob($this->_template_dir . '*.html');
        $this->_currentFile = $this->request->get('file', 'owner.html');

        if (preg_match("/^([_0-9a-z-\.\ ])+$/i", $this->_currentFile) && file_exists($this->_template_dir . $this->_currentFile)) {
            foreach ($files as $file) {
                if (!file_exists($file)) continue;
                $file = basename($file);
                $this->push(array(
                    'file'      =>  $file,
                    'current'   => ($file == $this->_currentFile)
                ));
            }
            return;
        }
        throw new \Typecho\Widget\Exception('模板文件不存在', 404);
    }

    /**
     * 获取菜单标题
     *
     * @return string
     */
    public function getMenuTitle(): string
    {
        return _t('编辑文件 %s', $this->_currentFile);
    }

    /**
     * 获取文件内容
     *
     * @return string
     */
    public function currentContent(): string
    {
        return htmlspecialchars(file_get_contents($this->_template_dir . $this->_currentFile));
    }

    /**
     * 获取文件是否可读
     *
     * @return string
     */
    public function currentIsWriteable(): string
    {
        return is_writeable($this->_template_dir . $this->_currentFile);
    }

    /**
     * 获取当前文件
     *
     * @return string
     */
    public function currentFile(): string
    {
        return $this->_currentFile;
    }

    
}
