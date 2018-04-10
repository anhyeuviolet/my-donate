<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */

if ( ! defined( 'NV_IS_MOD_MY_DONATE' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$per_page = 25;
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;
$page = $nv_Request->get_int( 'page', 'get', 1 );
$xtpl = new XTemplate( 'main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'CUR_PAGE', $page );
$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates ORDER BY weight ASC' )->fetchColumn( );

$sql = 'SELECT donate_id, title, alias, weight, add_time, donate_time, description, total_value, curency FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE status = 1 ORDER BY weight ASC LIMIT ' . ($page - 1) * $per_page . ', ' . $per_page;
$rowall = $db->query( $sql )->fetchAll( 3 );

$num = sizeof( $rowall );
$a = 1;
if( $page > 1 )
    $a = 1 + (($page - 1) * $per_page);

$array_status = array(
    $lang_global['no'],
    $lang_global['yes']
);
foreach( $rowall as $row )
{
    list( $donate_id, $title, $alias, $weight, $add_time, $donate_time, $description, $total_value, $curency ) = $row;

    $xtpl->assign( 'ROW', array(
        'donate_id' => $donate_id,
        'alias' => $alias,
        'description' => $description,
        'weight' => $weight,
        'total_value' => $total_value,
        'curency' => $curency,
        'link' => nv_url_rewrite ( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias . $global_config['rewrite_exturl'], true),
        'title' => $title,
        'add_time' => nv_date ( 'd/m/Y', $add_time ),
        'donate_time' => nv_date ( 'd/m/Y', $donate_time )
    ) );

    $xtpl->assign( 'STT', $a );
    $xtpl->parse( 'main.data.loop.stt' );


    $xtpl->parse( 'main.data.loop' );
    ++$a;
}


$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if( !empty( $generate_page ) )
{
    $xtpl->assign( 'GENERATE_PAGE', $generate_page );
    $xtpl->parse( 'main.data.generate_page' );
}

if( $num > 0 )
{
    $xtpl->parse( 'main.data' );
}
elseif( $page > 1 )
{
    header( 'Location:' . $base_url );
}
else
{
    $xtpl->parse( 'main.no_data' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
