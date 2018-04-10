/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2018 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 20 Mar 2018 07:43:50 GMT
 */
 
 function nv_show_donate () {
	if (document.getElementById('module_show_donate')) {
		$('#module_show_donate').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_donate' + '&page=' + curr_page + '&nocache=' + new Date().getTime());
	}
	return;
}

 function nv_del_donate(donate_id, delallcheckss) {
	if (confirm(nv_is_del_confirm[0])) {
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_donate' + '&nocache=' + new Date().getTime(), 'donate_id=' + donate_id + '&checkss=' + delallcheckss, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				nv_show_donate();
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}


function nv_donate_action(oForm, checkss, msgnocheck) {
	var fa = oForm['donate_id_check[]'];
	var list_donate_id = '';
	if (fa.length) {
		for (var i = 0; i < fa.length; i++) {
			if (fa[i].checked) {
				list_donate_id = list_donate_id + fa[i].value + ',';
			}
		}
	} else {
		if (fa.checked) {
			list_donate_id = list_donate_id + fa.value + ',';
		}
	}

	if (list_donate_id != '') {
		var action = document.getElementById('action').value;
		if (action == 'delete') {
			if (confirm(nv_is_del_confirm[0])) {
				$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_donate' + '&nocache=' + new Date().getTime(), 'list_donate_id=' + list_donate_id + '&checkss=' + checkss, function(res) {
					var r_split = res.split('_');
					if (r_split[0] == 'OK') {
						nv_show_donate();
					} else if (r_split[0] == 'ERR') {
						alert(r_split[1]);
					} else {
						alert(nv_is_del_confirm[2]);
					}
				});
			}
		}else{
			return false;
		}
	} else {
		alert(msgnocheck);
	}
}

function nv_change_donate(donate_id, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + donate_id, 5000);
	var new_vid = $('#id_' + mod + '_' + donate_id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_donate&nocache=' + new Date().getTime(), 'donate_id=' + donate_id + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		var r_split = res.split('_');
		if (r_split[0] != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		clearTimeout(nv_timer);
		nv_show_donate();
		return;
	});
	return;
}
