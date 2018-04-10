<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
	die( 'Stop!!!' );
$page_title = $lang_module['update_dotate'];
$error = array( );
$rowcontent = array(
	'donate_id' => '',
	'title' => '',
	'alias' => '',
	'total_value' => '',
	'curency' => '',
	'description' => '',
	'keywords' => '',
	'status' => 1,
	'weight' => 0,
	'add_time' => NV_CURRENTTIME,
	'edit_time' => NV_CURRENTTIME,
	'mode' => 'add'
);

$rowcontent['donate_id'] = $nv_Request->get_int( 'donate_id', 'get,post', 0 );

$array_list_action = array(
	'delete' => $lang_global['delete'],
);

if( $rowcontent['donate_id'] > 0 )
{
	$check_permission = false;
	$rowcontent = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE donate_id=' . $rowcontent['donate_id'] )->fetch( );
	if( !empty( $rowcontent['donate_id'] ) )
	{
		$rowcontent['mode'] = 'edit';
		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$check_permission = true;
		}
	}

	if( !$check_permission )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
		die( );
	}
	$page_title = $lang_module['edit_donate'];
}

if( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
	$rowcontent['title'] = $nv_Request->get_title( 'title', 'post', '', 1 );
    
	$rowcontent['alias'] = strtolower( change_alias ( $rowcontent['title'] ) );
    
	$rowcontent['total_value'] = $nv_Request->get_title( 'total_value', 'post' );
	$rowcontent['curency'] = $nv_Request->get_title( 'curency', 'post' );
    
    $rowcontent['description'] = $nv_Request->get_textarea('description', 'post', '');
    $rowcontent['description'] = nv_nl2br(nv_htmlspecialchars(strip_tags($rowcontent['description'])), '<br />');
    
	$rowcontent['keywords'] = $nv_Request->get_title( 'keywords', 'post', '', 1 );
	$rowcontent['status'] = $nv_Request->get_int( 'status', 'post', 1 );

	if( empty( $rowcontent['title'] ) )
	{
		$error[] = $lang_module['error_title'];
	}
	elseif( empty( $rowcontent['total_value'] ) )
	{
		$error[] = $lang_module['error_total_value'];
	}

	if( empty( $error ) )
	{
		if( $rowcontent['donate_id'] == 0 )
		{
			$sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_donates
				(   title,
                    alias,
                    total_value,
                    curency,
                    description,
                    keywords,
                    status,
                    weight,
                    add_time,
                    edit_time
                ) VALUES
				 (:title,
				 :alias,
				 :total_value,
				 :curency,
				 :description,
				 :keywords,
				 :status,
				  ' . intval( $rowcontent['weight'] ) . ',
				  ' . intval( $rowcontent['add_time'] ) . ',
				  ' . intval( $rowcontent['edit_time'] ) . ')';

			$data_insert = array( );
			$data_insert['title'] = $rowcontent['title'];
			$data_insert['alias'] = $rowcontent['alias'];
			$data_insert['total_value'] = $rowcontent['total_value'];
			$data_insert['curency'] = $rowcontent['curency'];
			$data_insert['description'] = $rowcontent['description'];
			$data_insert['keywords'] = $rowcontent['keywords'];
			$data_insert['status'] = $rowcontent['status'];

			$rowcontent['donate_id'] = $db->insert_id( $sql, 'donate_id', $data_insert );
			if( $rowcontent['donate_id'] > 0 )
			{
                nv_fix_donate ();
				$nv_Cache->delMod( $module_name );
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_donate'], $rowcontent['title'], $admin_info['userid'] );
				$url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
				$msg1 = $lang_module['donate_added'];
				$msg2 = $lang_module['donate_back'] . ' ' . $module_info['custom_title'];
				redirect( $msg1, $msg2, $url );
			}
			else
			{
				$error[] = $lang_module['errorsave'];
			}
		}
		else
		{
			$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donates SET
				 title=:title,
				 alias=:alias,
				 total_value=:total_value,
				 curency=:curency,
				 description=:description,
				 keywords=:keywords,
				 status=:status,
				 edit_time=' . NV_CURRENTTIME . '
				WHERE donate_id =' . $rowcontent['donate_id'] );

			$sth->bindParam( ':title', $rowcontent['title'], PDO::PARAM_STR );
			$sth->bindParam( ':alias', $rowcontent['alias'], PDO::PARAM_STR );
			$sth->bindParam( ':total_value', $rowcontent['total_value'], PDO::PARAM_STR );
			$sth->bindParam( ':curency', $rowcontent['curency'], PDO::PARAM_STR );
            $sth->bindParam( ':description', $rowcontent['description'], PDO::PARAM_STR );
			$sth->bindParam( ':keywords', $rowcontent['keywords'], PDO::PARAM_STR );
			$sth->bindParam( ':status', $rowcontent['status'], PDO::PARAM_STR );

			if( $sth->execute( ) )
			{
                nv_fix_donate ();
				$nv_Cache->delMod( $module_name );
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['edit_donate'], $rowcontent['title'], $admin_info['userid'] );
				$url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
				$msg1 = $lang_module['donate_updated'] . ' ' . $rowcontent['title'];
				$msg2 = $lang_module['donate_back'] . ' ' . $lang_module['main'];
				redirect( $msg1, $msg2, $url );
			}
			else
			{
				$error[] = $lang_module['errorsave'];
			}
		}
	}
	else
	{
		$url = 'javascript: history.go(-1)';
		$msg1 = implode( '<br />', $error );
		$msg2 = $lang_module['content_back'];
		redirect( $msg1, $msg2, $url, 'back' );
	}
}

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'ITEM', $rowcontent );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign('description', nv_htmlspecialchars(nv_br2nl($rowcontent['description'])));

if( !empty( $error ) )
{
	$xtpl->assign( 'error', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$array_status = array(
	$lang_global['no'],
	$lang_global['yes']
);

foreach( $array_status as $key => $val )
{
	$xtpl->assign( 'STATUS', array(
		'key' => $key,
		'title' => $val,
		'selected' => $key == $rowcontent['status'] ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.status' );
}

while( list( $action_i, $title_i ) = each( $array_list_action ) )
{
	if( defined( 'NV_IS_MODADMIN' ) )
	{
		$action_assign = array(
			'value' => $action_i,
			'title' => $title_i
		);
		$xtpl->assign( 'ACTION', $action_assign );
		$xtpl->parse( 'main.action' );
	}
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );
if( $rowcontent['donate_id'] > 0 )
{
	$op = '';
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
