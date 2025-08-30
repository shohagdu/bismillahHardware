<?php
if($this->session->flashdata('success')){
    ?>
    <div class="alert alert-success alert-dismissible" id="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
    </div>
    <?php
}elseif($this->session->flashdata('failed')){
    ?>
    <div class="alert alert-danger alert-dismissible" id="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Failed!</strong><?php echo $this->session->flashdata('failed')?>
    </div>
    <?php
}
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo $title; ?></h3>
        <h3 class="box-title pull-right" style="padding-right:20px;">
            <a href="<?php echo site_url('loan'); ?>" class="btn btn-sm btn-danger">
                <i class="glyphicon glyphicon-backward"></i> Back
            </a>
        </h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered" style="width:50%;">
            <tr>
                <td>Name</td>
                <td><?php echo !empty($loanAuthInfo->name)?$loanAuthInfo->name:'-' ?></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><?php echo !empty($loanAuthInfo->contact)?$loanAuthInfo->contact:-'' ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo !empty($loanAuthInfo->address)?$loanAuthInfo->address:'-' ?></td>
            </tr>


        </table>
        <table  class="table table-bordered table-striped" style="margin-top:20px">
            <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Remarks</th>
                <th>Transaction ID</th>
                <th>Loan (Credit)</th>
                <th>Paid (Debit)</th>
                <th>Current Due Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl         =   1;
            $b          =   '0.00';
            $tCredit    =   '0.00';
            $cDebit     =   '0.00';
            if(!empty($reports)){
                foreach($reports as $row){
                    $tCredit+=$row->credit_amount;
                    $cDebit+=$row->debit_amount;
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo date('d F, Y',strtotime($row->payment_date)); ?></td>
                        <td><?php echo $row->remarks; ?></td>
                        <td><?php echo $row->transCode; ?></td>
                        <td class="text-right"><?php echo  number_format($row->credit_amount,2,'.',','); ?></td>
                        <td class="text-right"><?php echo  number_format($row->debit_amount,2,'.',','); ?></td>

                        <td class="text-right">
                            <?php  $b+= ($row->credit_amount-$row->debit_amount);
                            echo !empty($b)?number_format($b,2):'0.00';
                        ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Summery Amount</th>
                    <th class="text-right"><?php echo  !empty($tCredit)?number_format($tCredit,2):'0.00' ?></th>
                    <th class="text-right"><?php echo  !empty($cDebit)?number_format($cDebit,2):'0.00' ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
