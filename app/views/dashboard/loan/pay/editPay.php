
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <div class="col-sm-12">
                    <h3 class="box-title"><?php echo $title; ?> </h3>
                    <a href="<?php echo site_url('loan/viewPay'); ?>" class="btn btn-sm btn-info pull-right" style="margin-top:5px;">
                        <i class="glyphicon glyphicon-backward"></i> Loan payment list
                    </a>
                </div>
            </div>
            <form action="<?php echo site_url('loan/insertPay'); ?>" method="POST" id="loanPayform">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="authId">Authority<span class="text-danger">*</span></label>
                            <select name="authId" id="authId" required="" class="form-control">
                                <option selected="" value="">Select Authority</option>
                                <?php
                                if(!empty($auth)){
                                    foreach($auth as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"  <?php echo ((!empty
                                            ($payInfo->loan_auth_id)
                                            && $payInfo->loan_auth_id==$row->id)?"selected":'')
                                        ?>>
                                            <?php echo $row->name; ?>
                                        </option>
                                    <?php } }
                                ?>
                            </select>
                        </div>

                        <div class="form-group" id="payableDiv" style="display: none;">
                            <div class="form-group">
                                <label for="payable">Payable Loan</label>
                                <input readonly="" name="payable" class="form-control" id="payable" value="0">
                            </div>

                            <div class="form-group">
                                <label for="due">Due</label>
                                <input readonly="" name="due" class="form-control" id="due" value="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="accId">Accounts<span class="text-danger">*</span></label>
                            <select name="accId" id="accId" required="" class="form-control">
                                <option selected="" required value="">Select Accounts</option>
                                <?php
                                if(!empty($accounts)){
                                    foreach($accounts as $acc){ ?>
                                        <option value="<?php echo $acc->accountID; ?>" <?php echo ((!empty
                                            ($payInfo->bank_id)
                                            && $payInfo->bank_id==$acc->accountID)?"selected":'')
                                        ?>>
                                            <?php echo $acc->accountName; ?>
                                        </option>
                                    <?php } }
                                ?>
                            </select>
                        </div>

                        <div class="form-group" id="accBalDiv" style="display: none;">
                            <label for="accBal">Available Balance</label>
                            <input readonly="" required="" name="accBal" class="form-control" id="accBal" value="0">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount<span class="text-danger">*</span></label>
                            <input required="" name="amount" value="<?php
                            echo !empty($payInfo->debit_amount)?$payInfo->debit_amount:'' ?>" class="form-control"
                                   id="amount" >
                        </div>

                        <div class="form-group">
                            <label for="date">
                                Date<span class="text-danger">*</span>
                            </label>
                            <div class="dynamic_date">
                                <input name="date" id="datepicker" required=""  value="<?php
                                echo !empty($payInfo->payment_date)?date('Y-m-d',strtotime($payInfo->payment_date)):'' ?>"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date">
                                Remarks<span class="text-danger"></span>
                            </label>
                            <div class="dynamic_date">
                                <textarea name="note" placeholder="Enter Remarks" id="note" required=""
                                          class="form-control"><?php
                                    echo !empty($payInfo->remarks)?$payInfo->remarks:'' ?></textarea>
                            </div>
                        </div>

                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-sm-3">
                        <div class="form-group">
                        <input type="hidden" name="editID" value="<?php
                            echo !empty($payInfo->id)?$payInfo->id:'' ?>" class="form-control"
                                   id="editID" >
                            <button type="button" id="submit" onclick="saveLoanPayInfo()" class="btn btn-primary
                            btn-lg">
                                <i class="glyphicon glyphicon-ok-sign"></i> Update
                            </button>

                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="box-body" id="alert_error" style="display: none;">      <div  class="callout callout-danger">
                                <span id="show_error_save_info"></span>
                            </div>
                        </div>
                        <div class="box-body" id="alert" style="display: none;">      <div  class="callout
                                callout-info">
                                <span id="show_message"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>


                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
