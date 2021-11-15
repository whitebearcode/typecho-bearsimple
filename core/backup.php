<?php $name = "bearsimple";
$db = Typecho_Db::get();
if (isset($_POST['type'])) {
    if ($_POST["type"] == "备份模板数据") {
        $value = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name))['value'];
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . '_backup'))) {
            $db->query($db->update('table.options')->rows(array('value' => $value))->where('name = ?', 'theme:' . $name . '_backup')); ?>
            <script>
                toastr.success("备份更新成功！");
                window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
            </script>
        <?php } else { ?>
            <?php
            if ($value) {
                $db->query($db->insert('table.options')->rows(array('name' => 'theme:' . $name . '_backup', 'user' => '0', 'value' => $value)));
            ?>
                <script>
                    toastr.success("备份成功！");
                    window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
                </script>
            <?php }
        }
    }
    if ($_POST["type"] == "还原模板数据") {
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . '_backup'))) {
            $_value = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . '_backup'))['value'];
            $db->query($db->update('table.options')->rows(array('value' => $_value))->where('name = ?', 'theme:' . $name)); ?>
            <script>
                toastr.success("还原成功！");
                window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
            </script>
        <?php } else { ?>
            <script>
                toastr.success("未备份过数据，无法恢复！");
                window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
            </script>
        <?php } ?>
    <?php } ?>
    <?php if ($_POST["type"] == "删除备份数据") {
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . '_backup'))) {
            $db->query($db->delete('table.options')->where('name = ?', 'theme:' . $name . '_backup')); ?>
            <script>
                toastr.success("删除成功");
                window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
            </script>
        <?php } else { ?>
            <script>
                toastr.success("没有备份内容，无法删除！");
                window.location.href = '<?php Helper::options()->adminUrl('options-theme.php'); ?>'
            </script>
        <?php } ?>
    <?php } ?>
<?php } ?>
<?php
echo '
<br><center><form class="protect" action="?backup" method="post">
<input type="submit" name="type" class="ui button" value="备份模板数据" />
 <input type="submit" name="type" class="ui button" value="还原模板数据" />
<input type="submit" name="type" class="ui button" style="margin-top:4px" value="删除备份数据" /></form></center>';
