<?php
if($this->session->flashdata('success')){
    ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
    </div>
    <?php
}elseif($this->session->flashdata('failed')){
    ?>
    <div class="alert alert-danger alert-dismissible">
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
            <a href="<?php echo site_url('loan/addLoan'); ?>" class="btn btn-sm btn-success" >
                <i class="glyphicon glyphicon-plus"></i> Add Loan
            </a>
        </h3>           
    </div><!-- /.box-header -->
    <?php 
         ?>
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Loan Author</th>
                            <th>Loan Amount</th>
                            <th>Interest(%)</th>
                            <th>Interest amount</th>
                            <th>Payable</th>
                            <th>Installment</th>
                            <th>Bank</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if(!empty($listLoan)){
                            $sl = 1;
                            foreach($listLoan as $loan){ ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td>
                                        <?php echo $loan['name']; ?>
                                    </td>
                                    <td><?php echo $loan['receivedLoan']; ?></td>
                                    <td><?php echo $loan['interest']."(%)"; ?></td>
                                    <td><?php echo $loan['interestAmount']; ?></td>
                                    <td><?php echo $loan['lpayable']; ?></td>

                                    <td>
                                        <?php
                                        if($loan['install']==1) {
                                            if ($loan['installType'] == 1) {
                                                echo $loan['perInstall'] . ' Per Day X ' . $loan['duration'];
                                            } elseif ($loan['installType'] == 2) {
                                                echo $loan['perInstall'] . ' Per Month X ' . $loan['duration'];
                                            }
                                        }else{
                                            echo "No Installment";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $loan['accountName'].(!empty($loan['accountNumber'])? "[".$loan['accountNumber']."]":''); ?></td>
                                    <td><?php echo date('d M, Y',strtotime($loan['date'])); ?></td>
                                    <td>
                                        <?php
                                            if($loan['lstatus']>0){
                                               // echo 'Not Editable';     
                                            }else{ ?>
                                                <a href="<?php echo site_url('loan/editLoan/'.$loan['lid']); ?>" class="btn btn-info btn-xs btn-flat">
                                                    <i class="glyphicon glyphicon-edit"></i> Edit
                                                </a>
                                            <?php } 
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

</div>

