<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */
if( !defined( 'NV_IS_FILE_ADMIN' ) )
{
	die( 'Stop!!!' );
}
if( !defined( 'NV_IS_AJAX' ) )
{
	die( 'Wrong URL' );
}

$donate_id = $nv_Request->get_int( 'donate_id', 'post,get', 0 );
$mod = $nv_Request->get_title( 'mod', 'post,get', '' );
$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
$content = 'NO_' . $donate_id;

$donate_id = $db->query( 'SELECT donate_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE donate_id=' . $donate_id )->fetchColumn( );
if( $donate_id > 0 )
{
	if( $mod == 'weight' and $new_vid > 0 and (defined( 'NV_IS_MODADMIN' )) )
	{
		$sql = 'SELECT donate_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donates WHERE donate_id!=' . $donate_id . ' ORDER BY weight ASC';
		$result = $db->query( $sql );

		$weight = 0;
		while( $row = $result->fetch( ) )
		{
			++$weight;
			if( $weight == $new_vid )
			{
				++$weight;
			}
			$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donates SET weight=' . $weight . ' WHERE donate_id=' . $row['donate_id'];
			$db->query( $sql );
		}

		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donates SET weight=' . $new_vid . ' WHERE donate_id=' . $donate_id;
		$db->query( $sql );
		nv_fix_donate( );
		$content = 'OK_' . $donate_id;
	}
	elseif( defined( 'NV_IS_MODADMIN' ) )
	{
		if( $mod == 'status' and ($new_vid == 0 or $new_vid == 1) )
		{
			$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donates SET status=' . $new_vid . ' WHERE donate_id=' . $donate_id;
			$db->query( $sql );
			$content = 'OK_' . $donate_id;
		}
	}
	$nv_Cache->delMod( $module_name );
}


include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';
