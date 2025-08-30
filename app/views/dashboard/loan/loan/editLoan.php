<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header">
            <div class="col-sm-12">
                <h3 class="box-title"><?php echo $title; ?></h3>
                <a href="<?php echo site_url('loan/viewLoan'); ?>" class="btn btn-sm btn-info pull-right" style="margin-top:5px;">
                    <i class="glyphicon glyphicon-backward"></i> Loan list
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <form action="<?php echo site_url('loan/insertLoan'); ?>" method="POST" id="loanForm">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
//                            echo "<pre>";
//                            print_r($loan);
                            ?>
                            <div class="form-group">
                                <label for="authId">
                                    Authority<span class="text-danger">*</span>
                                </label>
                                <select name="authorityId" id="authorityId" required="" class="form-control">
                                    <option selected value="" >Select Authority</option>
                                    <?php
                                    if(!empty($auth)){
                                        foreach($auth as $row){ ?>
                                            <option value="<?php echo $row->id; ?>" <?php echo ((!empty
                                                ($loan->authorityId)
                                            && $loan->authorityId==$row->id)?"selected":'')
                                            ?>>
                                                <?php echo $row->name; ?>
                                            </option>
                                        <?php } }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="loan">
                                    Loan Amount<span class="text-danger">*</span>
                                </label>
                                <input name="loanAmount"  required="" class="form-control" id="loan" value="<?php
                                echo !empty($loan->loan)?$loan->loan:'0.00' ?>"
                                       placeholder="1000">
                            </div>

                            <div class="form-group">

                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="interest">
                                            Interest(%)
                                        </label>
                                        <input name="interest" value="<?php
                                        echo !empty($loan->interest)?$loan->interest:'0.00' ?>" class="form-control" id="interest" placeholder="5">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="interest">
                                            Interest Amount
                                        </label>
                                        <input  name="interestAmount" class="form-control" id="interestAmount" value="<?php
                                        echo !empty($loan->interestAmount)?$loan->interestAmount:'0.00' ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="payable">
                                    Payable Amount<span class="text-danger">*</span>
                                </label>
                                <input name="payable" required="" class="form-control" id="payableAmount" value="<?php
                                echo !empty($loan->payable)?$loan->payable:'0.00' ?>">
                            </div>

                            <div class="form-group">
                                <label for="install">
                                    Installment?
                                </label>
                                <select name="install" id="install" class="form-control">
                                    <option value="2" <?php echo ((!empty
                                        ($loan->install)
                                        && $loan->install==2)?"selected":'')
                                    ?> >No</option>
                                    <option value="1" <?php echo ((!empty
                                        ($loan->install)
                                        && $loan->install==1)?"selected":'')
                                    ?>>Yes</option>
                                </select>
                            </div>

                            <div id="installDiv" style="<?php echo ((!empty
                                ($loan->install)
                                && $loan->install==2)?"display: none;":'')
                            ?> ">
                                <div class="form-group">
                                    <label for="installType">
                                        Payment Type<span class="text-danger">*</span>
                                    </label>
                                    <select name="installType" id="installType" class="form-control">
                                        <option value="1" <?php echo ((!empty
                                            ($loan->installType)
                                            && $loan->installType==1)?"selected":'')
                                            ?> >Daily</option>
                                        <option value="2" <?php echo ((!empty
                                            ($loan->installType)
                                            && $loan->installType==2)?"selected":'')
                                        ?>>Monthly</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="duration">
                                        Duration<span class="text-danger">*</span>
                                    </label>
                                    <input name="duration" id="duration" value="<?php
                                    echo !empty($loan->loan)?$loan->loan:'0.00' ?>"class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="perInstall">
                                        Per <span id="perInstallSpan">Month</span>
                                    </label>
                                    <input name="perInstall" readonly="" id="perInstall" value="<?php
                                    echo !empty($loan->perInstall)?$loan->perInstall:'0.00' ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accId">
                                    Accounts<span class="text-danger">*</span>
                                </label>

                                <select name="accId" id="accId" required="" class="form-control">
                                    <option selected="" value="">Select Accounts</option>
                                    <?php
                                    if(!empty($accounts)){
                                        foreach($accounts as $acc){ ?>
                                            <option value="<?php echo $acc->accountID; ?>" <?php echo ((!empty
                                                ($loan->bank_id)
                                                && $loan->bank_id==$acc->accountID)?"selected":'')
                                            ?>>
                                                <?php echo $acc->accountName; ?>
                                            </option>
                                    <?php } }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="date">
                                    Date<span class="text-danger">*</span>
                                </label>
                                <div class="dynamic_date">
                                    <input name="date" id="datepicker" required="" value="<?php
                                    echo !empty($loan->date)?date('Y-m-d',strtotime($loan->date)):'' ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date">
                                    Remarks<span class="text-danger"></span>
                                </label>
                                <div class="dynamic_date">
                                    <textarea name="note" placeholder="Enter Remarks" id="note"
                                              class="form-control"><?php
                                        echo !empty($loan->remarks)?$loan->remarks:'0.00' ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="clearfix"></div>
                <div class="box-footer" style="padding-bottom: 10px;0px;">
                    <div class="col-sm-3">
                        <div class="row">
                            <input type="text" name="editID" readonly="" id="editID" value="<?php
                            echo !empty($loan->lid)?$loan->lid:'' ?>" class="form-control">
                            <button type="button" onclick="saveLoanInfo()" id="updateBtn" class="btn btn-primary btn-lg">
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
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>

