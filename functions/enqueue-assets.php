<?php

function enqueue_time_versioned_plugin_style($handle, $src = '', $deps = array(), $media = 'all')
{
    global $base_dir;
    global $base_url;

    $hostPath = $base_url . $src;
    $directoryPath = $base_dir . $src;

    wp_enqueue_style($handle, $hostPath, $deps, filemtime($directoryPath), $media);
}

function enqueue_time_versioned_plugin_js($handle, $src = '', $deps = array())
{
    global $base_dir;
    global $base_url;

    $hostPath = $base_url . $src;
    $directoryPath = $base_dir . $src;

    wp_register_script($handle, $hostPath, array( 'jquery' ), filemtime($directoryPath));
    wp_localize_script($handle, 'ajaxData', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script($handle);
}
