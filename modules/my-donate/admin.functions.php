<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );
$per_page = 25;
$submenu['main'] = $lang_module['manage_donate'];
$submenu['donate'] = $lang_module['add_donate'];
// $submenu['payment'] = $lang_module['payment'];
// $submenu['add_payment'] = $lang_module['add_payment'];
$submenu['config'] = $lang_module['config'];

$allow_func = array( 'main', 'config', 'donate', 'add_donate', 'del_donate', 'add_object', 'del_object', 'payment', 'add_payment', 'del_payment', 'list_donate', 'change_donate');

define( 'NV_IS_FILE_ADMIN', true );


/**
 * redirect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed $nv_redirect
 * @return
 */
function redirect($msg1 = '', $msg2 = '', $nv_redirect, $autoSaveKey = '', $go_back = '')
{
    global $global_config, $module_file, $module_name;
    $xtpl = new XTemplate('redirect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    if (empty($nv_redirect)) {
        $nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    }
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_REDIRECT', $nv_redirect);
    $xtpl->assign('MSG1', $msg1);
    $xtpl->assign('MSG2', $msg2);

    if (! empty($autoSaveKey)) {
        $xtpl->assign('AUTOSAVEKEY', $autoSaveKey);
        $xtpl->parse('main.removelocalstorage');
    }

    if (nv_strlen($msg1) > 255) {
        $xtpl->assign('REDRIECT_T1', 20);
        $xtpl->assign('REDRIECT_T2', 20000);
    } else {
        $xtpl->assign('REDRIECT_T1', 5);
        $xtpl->assign('REDRIECT_T2', 5000);
    }

    if ($go_back) {
        $xtpl->parse('main.go_back');
    } else {
        $xtpl->parse('main.meta_refresh');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}


/**
 * nv_show_donates_list()
 *
 * @return
 *
 */
function nv_show_donates_list( $page = 1 ) {
	global $db, $lang_module, $lang_global, $module_name, $module_data, $global_array_cat, $admin_id, $global_config, $module_file, $per_page, $nv_Request;

	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$xtpl = new XTemplate( 'donates_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'CUR_PAGE', $page );
	$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates ORDER BY weight ASC' )->fetchColumn( );

	$sql = 'SELECT donate_id, title, alias, weight, add_time, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates ORDER BY weight ASC LIMIT ' . ($page - 1) * $per_page . ', ' . $per_page;
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
		list( $donate_id, $title, $alias, $weight, $add_time, $status ) = $row;

		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$check_show = 1;
		}

		if( !empty( $check_show ) )
		{

			$admin_funcs = array( );
			$weight_disabled = $func_cat_disabled = true;

			if( defined( 'NV_IS_MODADMIN' ) )
			{
				$func_cat_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=donate&amp;donate_id=" . $donate_id . "\">" . $lang_global['edit'] . "</a>\n";
			}
			if( defined( 'NV_IS_MODADMIN' ) )
			{
				$weight_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_donate('" . $donate_id . "', '" . md5( $donate_id . NV_CHECK_SESSION ) . "')\">" . $lang_global['delete'] . "</a>";
			}

			$xtpl->assign( 'ROW', array(
				'donate_id' => $donate_id,
				'alias' => $alias,
				'link' => nv_url_rewrite ( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias . $global_config['rewrite_exturl'], true),
				'title' => $title,
				'add_time' => nv_date ( 'd/m/Y', $add_time ),
				'adminfuncs' => implode( '&nbsp;-&nbsp;', $admin_funcs )
			) );

			$xtpl->assign( 'STT', $a );
			$xtpl->parse( 'main.data.loop.stt' );

			for( $i = 1; $i <= $all_page; ++$i )
			{
				$xtpl->assign( 'WEIGHT', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $weight ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'main.data.loop.weight.loop' );
			}
			$xtpl->parse( 'main.data.loop.weight' );

			foreach( $array_status as $key => $val )
			{
				$xtpl->assign( 'STATUS', array(
					'key' => $key,
					'title' => $val,
					'selected' => $key == $status ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'main.data.loop.status.loop' );
			}
			$xtpl->parse( 'main.data.loop.status' );

			$xtpl->parse( 'main.data.loop' );
			++$a;
		}
	}
	$array_list_action = array(
		'' => $lang_module['sel_action'],
		'delete' => $lang_global['delete']
	);
	while( list( $action_i, $title_i ) = each( $array_list_action ) )
	{
		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$action_assign = array(
				'value' => $action_i,
				'title' => $title_i
			);
			$xtpl->assign( 'ACTION', $action_assign );
			$xtpl->parse( 'main.data.action' );
		}
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

	return $contents;
}

/**
 * nv_fix_donate()
 *
 * @return
 *
 */
function nv_fix_donate( )
{
	global $db, $module_data;
	$sql = 'SELECT donate_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates ORDER BY weight ASC';
	$result = $db->query( $sql );
	$weight = 0;
	while( $row = $result->fetch( ) )
	{
		++$weight;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donates SET weight=' . $weight . ' WHERE donate_id=' . intval( $row['donate_id'] );
		$db->query( $sql );
	}
	$result->closeCursor( );
}



/**
 * nv_del_donate()
 *
 * @param mixed $donate_id
 * @return
 *
 */
function nv_del_donate( $donate_id )
{
	global $db, $module_name, $module_data, $title, $lang_module, $admin_info, $nv_Cache;
	$contents = "ERR_" . $donate_id;
	$title = '';
	list( $donate_id, $title ) = $db->query( 'SELECT donate_id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE donate_id=' . $donate_id )->fetch( 3 );
	if( $donate_id > 0 )
	{
		if( (defined( 'NV_IS_MODADMIN' )) )
		{
			$db->query( "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_donates WHERE donate_id=" . $donate_id );
			nv_fix_donate( );
			$nv_Cache->delMod( $module_name );
			$contents = "OK_" . $donate_id;
		}
		else
		{
			$contents = "ERR_" . $lang_module['error_permission'];
		}
	}
	else
	{
		$contents = "ERR_" . $lang_module['error_donate_id'];
	}
	return $contents;
}
