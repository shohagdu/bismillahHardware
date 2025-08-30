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
            <a href="<?php echo site_url('loan/addAuth'); ?>" class="btn btn-sm btn-success">
                <i class="glyphicon glyphicon-plus"></i> Add Authority
            </a>
        </h3>           
    </div>
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Loan Amount</th>
                    <th>Paid Amount</th>
                    <th>Current Due Amount</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if(!empty($opBal)){
                    $sl = 1;
                    foreach($opBal as $row){ ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->contact; ?></td>
                            <td><?php echo $row->address; ?></td>
                            <td><?php echo  number_format($row->totalPayable,2,'.',','); ?></td>
                            <td><?php echo  number_format($row->totalPaid,2,'.',','); ?></td>

                            <td><?php echo  number_format($row->totalPayable-$row->totalPaid,2,'.',','); ?></td>
                            <td>
                                <a href="<?php echo site_url('loan/editAuth/'.$row->id); ?>" class="btn btn-info btn-xs">
                                    <i class="glyphicon glyphicon-pencil"></i> Update
                                </a>
                                <a href="<?php echo site_url('loan/ledger/'.$row->id); ?>" class="btn btn-primary btn-xs">
                                    <i class="glyphicon glyphicon-pencil"></i> Ledger
                                </a>

                            </td>
                        </tr>
                    <?php
                }
               }
?>
            </tbody>
        </table>
    </div>
</div>
