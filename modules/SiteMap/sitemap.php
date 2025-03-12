<?php
header("HTTP/1.1 200 OK");
header("Content-Type: text/xml");
$options = Helper::options();
$db = Typecho_Db::get();
$limit = bsOptions::getInstance()::get_option( 'bearsimple' )['SiteMap'];
$pages = $db->fetchAll(
    $db->select()->from('table.contents')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $options->gmtTime)
        ->where('table.contents.type = ?', 'page')
        ->limit($limit)
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
);
$articles = $db->fetchAll(
    $db->select()->from('table.contents')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $options->gmtTime)
        ->where('table.contents.type = ?', 'post')
        ->limit($limit)
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
);
ob_clean();
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($pages as $page) {
    $tpage = Typecho_Widget::widget('Widget_Abstract_Contents')->push($page);
    echo "\t<url>\n";
    echo "\t\t<loc>" . $tpage['permalink'] . "</loc>\n";
    echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $page['modified']) . "</lastmod>\n";
    echo "\t\t<changefreq>monthly</changefreq>\n";
    echo "\t\t<priority>0.8</priority>\n";
    echo "\t</url>\n";
}
foreach ($articles as $article) {
    $tpost = Typecho_Widget::widget('Widget_Abstract_Contents')->push($article);
    echo "\t<url>\n";
    echo "\t\t<loc>" . $tpost['permalink'] . "</loc>\n";
    echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $article['modified']) . "</lastmod>\n";
    echo "\t\t<changefreq>monthly</changefreq>\n";
    echo "\t\t<priority>0.5</priority>\n";
    echo "\t</url>\n";
}
echo "</urlset>";
exit;