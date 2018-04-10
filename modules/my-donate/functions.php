<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

if (!in_array($op, array(
    'viewcat',
    'detail'
))) {
    define('NV_IS_MOD_MY_DONATE', true);
}

global $global_array_donate;
$global_array_donate = array();
$donate_id = 0;
$alias_donate_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE status = 1 ORDER BY weight ASC';
$list = $nv_Cache->db($sql, 'donate_id', $module_name);
if (!empty($list)) {
    foreach ($list as $l) {
        $global_array_donate[$l['donate_id']] = $l;
        $global_array_donate[$l['donate_id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'] . $global_config['rewrite_exturl'];
        if ($alias_donate_url == $l['alias']) {
            $donate_id = $l['donate_id'];
        }
    }
}

$count_op = sizeof($array_op);
if (!empty($array_op) and $op == 'main') {
    $op = 'main';
    if ($count_op > 1 or $donate_id > 0) {
        $op = 'detail';
    }
}
