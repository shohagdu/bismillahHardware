<?php
if ($this->session->flashdata('success')) {
    echo '<b style="color: green;">' . $this->session->flashdata('success') . '</b>';
} elseif ($this->session->flashdata('failed')) {
    echo '<b style="color: red;">' . $this->session->flashdata('failed') . '</b>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <div class="col-sm-12">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <a href="<?php echo site_url('loan'); ?>" class="btn btn-sm btn-info pull-right"
                       style="margin-top:5px;">
                        <i class="glyphicon glyphicon-backward"></i> Authority list
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <form action="<?php echo site_url('loan/insertAuth'); ?>" method="POST" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="editId" value="<?php echo $auth['id']; ?>">
                                    <label for="name">
                                        Name<span class="text-danger">*</span>
                                    </label>
                                    <input name="name" required="" class="form-control" id="name"
                                           value="<?php echo $auth['name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="contact">
                                        Contact No.<span class="text-danger">*</span>
                                    </label>
                                    <input name="contact" required="" class="form-control" id="contact"
                                           value="<?php echo $auth['contact']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control"
                                              id="address"><?php echo $auth['address']; ?></textarea>
                                </div>

                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-sm"
                                onclick="return confirm('Sure to Update?');">
                            <i class="glyphicon glyphicon-ok-sign"></i> Update
                        </button>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script>
    var submitId = $("#submit");
    $(document).on("blur", "#name", function (e) {
        var name = $(this).val().trimLeft();
        var fieldId = $("#name");
        var select = 'id';
        var table = 'loan_authority';
        var id = '<?php echo $auth["id"]; ?>';
        var where = {name: name, id: id};
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('common/chkDuplicacyEdit'); ?>",
            data: {select: select, table: table, where: where},
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    disabledMsg(fieldId, submitId, 'Duplicate!');
                } else {
                    enabledMsg(fieldId, submitId);
                }
            }
        });
    });

    $(document).on("blur", "#contact", function (e) {
        var contact = $(this).val().trimLeft();
        var fieldId = $("#contact");
        var select = 'id';
        var table = 'loan_authority';
        var id = '<?php echo $auth["id"]; ?>';
        var where = {contact: contact, id: id};
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('common/chkDuplicacyEdit'); ?>",
            data: {select: select, table: table, where: where},
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    disabledMsg(fieldId, submitId, 'Duplicate!');
                } else {
                    enabledMsg(fieldId, submitId);
                }
            }
        });
    });

    $(document).on("keyup", "#contact", function (e) {
        var val = $(this).val().trimLeft();
        var fieldId = $("#contact");
        if (isNaN(val)) {
            disabledMsg(fieldId, submitId, 'Must be numeric');
        } else {
            enabledMsg(fieldId, submitId);
        }
    });
</script> 