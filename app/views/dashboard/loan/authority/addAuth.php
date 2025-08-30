<?php
    if($this->session->flashdata('success')){
        echo "<div class='green'>".$this->session->flashdata('success')."</div>";
    }elseif($this->session->flashdata('failed')){
        echo "<div class='red'>".$this->session->flashdata('failed')."</div>";
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <div class="col-sm-12">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <a href="<?php echo site_url('loan'); ?>" class="btn btn-sm btn-info pull-right" style="margin-top:5px;">
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
                                    <label for="name">
                                        Name<span class="text-danger">*</span>
                                    </label>
                                    <input name="name" required="" class="form-control" id="name" placeholder="Brac Bank">
                                </div>

                                <div class="form-group">
                                    <label for="contact">
                                        Contact No.<span class="text-danger">*</span>
                                    </label>
                                    <input name="contact" required="" class="form-control OnlyNumbers" id="contact" placeholder="016********">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" placeholder="Enter Authority Address" class="form-control" id="address"></textarea>
                                </div>

                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-sm" onclick="return confirm('Sure to Add?');">
                            <i class="glyphicon glyphicon-ok-sign"></i> Save
                        </button>

                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>  
</div>
