<?php


use Typecho\Db;

const FRAMEWORK_PLUGIN_NAME = 'plugin:BsCore_';
const FRAMEWORK_KEY_PARMAS_NAME = 'plugin:bsOF_key_params';

if (!function_exists('get_option')) {

// get option for framework
    function get_option($option, $default = false)
    {
        $db = Db::get();
        $pluginName = FRAMEWORK_PLUGIN_NAME;
        $select = $db->select()->from('table.options')
            ->where('name = ?', $pluginName);

        $options = $db->fetchRow($select);
        if (empty($options)) {
            return $default;
        } else {

            $options = unserialize($options['value']);
            if (array_key_exists($option, $options)) {
                return $options[$option];
            } else {
                return $default;
            }
        }
    }
}


if (!function_exists('update_option')) {
    function update_option($option, $value, $autoload = null)
    {
        $db = Db::get();
        $pluginName = FRAMEWORK_PLUGIN_NAME;
        $select = $db->select()->from('table.options')
            ->where('name = ?', $pluginName);

        $options = $db->fetchRow($select);
        $settings = [$option => $value];
        if (empty($options)) {
            $db->query($db->insert('table.options')
                ->rows([
                    'name' => $pluginName,
                    'value' => serialize($settings),
                    'user' => 0
                ]));
        } else {
            $options = unserialize($options['value']);
            $options[$option] = $value;
            $db->query($db->update('table.options')
                ->rows(['value' => serialize($options)])
                ->where('name = ?', $pluginName)
                ->where('user = ?', 0));
        }

        return true;
    }
}
if (!function_exists('update_bs_key_params')) {
    function update_bs_key_params($option, $value, $autoload = null)
    {
        $db = Db::get();
        $pluginName = FRAMEWORK_KEY_PARMAS_NAME;
        $select = $db->select()->from('table.options')
            ->where('name = ?', $pluginName);

        $options = $db->fetchRow($select);
        $settings = [$option => $value];
        if (empty($options)) {
            $db->query($db->insert('table.options')
                ->rows([
                    'name' => $pluginName,
                    'value' => serialize($settings),
                    'user' => 0
                ]));
        } else {
            $options = unserialize($options['value']);
            $options[$option] = $value;
            $db->query($db->update('table.options')
                ->rows(['value' => serialize($options)])
                ->where('name = ?', $pluginName)
                ->where('user = ?', 0));
        }
    }
}
if (!function_exists('get_bs_key_params')) {

// get option for framework
    function get_bs_key_params($option, $default = false)
    {
        $db = Db::get();
        $pluginName = FRAMEWORK_KEY_PARMAS_NAME;
        $select = $db->select()->from('table.options')
            ->where('name = ?', $pluginName);

        $options = $db->fetchRow($select);
        if (empty($options)) {
            return $default;
        } else {
            $options = unserialize($options['value']);
            if (array_key_exists($option, $options)) {
                return $options[$option];
            } else {
                return $default;
            }
        }
    }
}
if (!function_exists('delete_option')) {

    function delete_option($option)
    {
        $db = Db::get();
        $pluginName = FRAMEWORK_PLUGIN_NAME;
        if (is_scalar($option)) {
            $option = trim($option);
        }

        if (empty($option)) {
            return false;
        }

        wp_protect_special_option($option);

        // Get the ID, if no ID then return.
        $select = $db->select()->from('table.options')
            ->where('name = ?', $pluginName);

        $row = $db->fetchRow($select);
        if (is_null($row)) {
            return false;
        }

        $result = $db->query($db->delete('table.options')->where('name = ?', 'plugin:' . $pluginName));


        if ($result) {

            return true;
        }

        return false;
    }
}
