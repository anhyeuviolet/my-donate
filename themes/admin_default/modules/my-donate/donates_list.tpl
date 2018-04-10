<!-- BEGIN: main -->
<!-- BEGIN: data -->
<form class="navbar-form" name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=source_cat">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'donate_id_check[]', 'check_all[]',this.checked);" /></th>
					<th class="text-center">{LANG.weight}</th>
					<th class="text-center">{LANG.sourcecat_name}</th>
					<th class="text-center">{LANG.add_time}</th>
					<th class="text-center">{LANG.status}</th>
					<th class="text-center">{LANG.functional}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'donate_id_check[]', 'check_all[]', this.checked);" value="{ROW.donate_id}" name="donate_id_check[]" /></td>
					<td class="text-center">
					<!-- BEGIN: weight -->
					<select class="form-control" id="id_weight_{ROW.donate_id}" onchange="nv_change_donate('{ROW.donate_id}','weight');">
						<!-- BEGIN: loop -->
						<option value="{WEIGHT.key}" {WEIGHT.selected}>{WEIGHT.title}</option>
						<!-- END: loop -->
					</select>
					<!-- END: weight -->
					</td>
					<td><strong><a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a></strong></td>
                    <td>{ROW.add_time}</td>
					<td class="text-center">
					<!-- BEGIN: status -->
					<select class="form-control" id="id_status_{ROW.donate_id}" onchange="nv_change_donate('{ROW.donate_id}','status');">
						<!-- BEGIN: loop -->
						<option value="{STATUS.key}" {STATUS.selected}>{STATUS.title}</option>
						<!-- END: loop -->
					</select>
					<!-- END: status -->
					</td>
					
					<td class="text-center">{ROW.adminfuncs}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
			<tfoot>
				<tr class="text-left">
					<td colspan="12">
						<select class="form-control" name="action" id="action">
							<!-- BEGIN: action -->
							<option value="{ACTION.value}">{ACTION.title}</option>
							<!-- END: action -->
						</select>
						<input type="button" class="btn btn-primary" onclick="nv_donate_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')" value="{LANG.action}" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<script>
var curr_page = "{CUR_PAGE}";
</script>

<!-- END: data -->

<!-- BEGIN: no_data -->
<div class="row alert alert-info">Chưa có Nhóm nguồn tin nào</div>
<!-- END: no_data -->

<!-- END: main -->