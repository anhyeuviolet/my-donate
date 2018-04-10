<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
		'name' => 'My-donate',
		'modfuncs' => 'main,detail,search',
		'change_alias' => '',
		'submenu' => 'main,detail,search',
		'is_sysmod' => 0,
		'virtual' => 1,
		'version' => '4.0.01',
		'date' => 'Tue, 20 Mar 2018 07:43:50 GMT',
		'author' => 'KennyNguyen (nguyentiendat713@gmail.com)',
		'uploads_dir' => array($module_name,$module_name.'/images',$module_name.'/templates',$module_name.'/temp'),
		'files_dir' => array($module_name,$module_name.'/images',$module_name.'/templates'),
		'note' => 'Module Donate - Simple version'
	);