<!-- BEGIN: main -->
<div id="module_show_list">
	{SOURCECAT_LIST}
</div>
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<div id="content">
	<a name="edit"></a>
	<form class="source_form" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" enctype="multipart/form-data" method="post">
		<div class="row">
			<div class="form-group row clear">
				<label class="col-sm-4 control-label"><strong>Tiêu đề</strong></label>
				<div class="col-lg-18 col-md-18 col-sm-18"><input name="title" type="text" id="title" class="form-control" value="{ITEM.title}"/></div>
			</div>
					
			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Liên kết tĩnh</strong></label>
				<div class="col-lg-18 col-md-18 col-sm-18"><input name="alias" type="text" id="alias" class="form-control" value="{ITEM.alias}"/></div>
			</div>
            
			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Giá trị</strong></label>
				<div class="col-lg-18 col-md-18 col-sm-18"><input name="total_value" type="text" id="total_value" class="form-control" value="{ITEM.total_value}"/></div>
			</div>

			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Đơn vị tiền tệ</strong></label>
				<div class="col-lg-18 col-md-18 col-sm-18"><input name="curency" type="text" id="curency" class="form-control" value="{ITEM.curency}"/></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Mô tả chi tiết</strong></label>
            <div class="col-lg-18 col-md-18 col-sm-18"><textarea name="description" type="text" style="width: 100%" id="description" class="form-control"/>{description}</textarea></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Từ khoá</strong></label>
				<div class="col-lg-18 col-md-18 col-sm-18"><input name="keywords" type="text" id="keywords" class="form-control" value="{ITEM.keywords}"/></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 control-label"><strong>Trạng thái kích hoạt</strong></label>
				<div class="col-lg-3 col-md-3 col-sm-3">
				<select class="form-control" id="status" name="status">
					<!-- BEGIN: status -->
					<option value="{STATUS.key}" {STATUS.selected}>{STATUS.title}</option>
					<!-- END: status -->
				</select>
				</div>
			</div>
		</div>
		<div class="text-center">
			<br/>
			<input type="hidden" value="1" name="save" />
			<input type="hidden" value="{ITEM.donate_id}" name="donate_id" />
			<input class="btn btn-primary submit-post" name="statussave" type="submit" value="{LANG.save}" />
		</div>
	</form>
</div>
<script>
var CFG = [];
CFG.upload_current = '{UPLOAD_PATH}';
CFG.upload_path = '{UPLOAD_PATH}';
</script>
<!-- END: main -->
