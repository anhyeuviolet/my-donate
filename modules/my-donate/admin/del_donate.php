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

$donate_id = $nv_Request->get_int( 'donate_id', 'post', 0 );
$checkss = $nv_Request->get_string( 'checkss', 'post', '' );
$list_donate_id = $nv_Request->get_string( 'list_donate_id', 'post', '' );
$contents = 'ERR_' . $donate_id;

if( $list_donate_id != '' and NV_CHECK_SESSION == $checkss )
{
	$del_array = array_map( 'intval', explode( ',', $list_donate_id ) );
}
elseif( md5( $donate_id . NV_CHECK_SESSION ) == $checkss )
{
	$del_array = array( $donate_id );
}
if( !empty( $del_array ) )
{
	$sql = 'SELECT donate_id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE donate_id IN (' . implode( ',', $del_array ) . ')';
	$result = $db->query( $sql );
	$del_array = $no_del_array = array( );
	$artitle = array( );
	while( list( $donate_id, $title ) = $result->fetch( 3 ) )
	{
		$check_permission = false;
		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$check_permission = true;
		}

		if( $check_permission > 0 )
		{
			$contents = nv_del_donate( $donate_id );
			$artitle[] = $title;
			$del_array[] = $donate_id;
		}
		else
		{
			$no_del_array[] = $donate_id;
		}
	}
	$count = sizeof( $del_array );
	if( $count )
	{
		nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_donates'], implode( ', ', $artitle ), $admin_info['userid'] );
	}
	if( !empty( $no_del_array ) )
	{
		$contents = 'ERR_' . $lang_module['error_permission'] . ': ' . implode( ', ', $no_del_array );
	}
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
