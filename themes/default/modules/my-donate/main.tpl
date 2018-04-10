<!-- BEGIN: main -->
<!-- BEGIN: data -->
<form class="navbar-form" name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=source_cat">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">{LANG.weight}</th>
					<th class="text-center">{LANG.add_time}</th>
					<th class="text-center">{LANG.title}</th>
					<th class="text-center">{LANG.description}</th>
					<th class="text-center">{LANG.donate_value}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td class="text-center">{ROW.weight}</td>
                    <td>{ROW.add_time}</td>
					<td><strong><a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a></strong></td>
					<td class="text-center">{ROW.description}</td>
					<td class="text-center">{ROW.total_value} {ROW.curency} </td>
				</tr>
				<!-- END: loop -->
			</tbody>
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