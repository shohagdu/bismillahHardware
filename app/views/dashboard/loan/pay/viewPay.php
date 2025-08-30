<section class="content">


<div class="box">
    <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
    <div class="box-header">
        <h3 class="box-title"><?php echo $title; ?></h3> 
        <h3 class="box-title pull-right" style="padding-right:20px;">
            <a href="<?php echo site_url('loan/addPay'); ?>" class="btn btn-sm btn-success">
                <i class="glyphicon glyphicon-plus"></i> Add Payment
            </a>
        </h3>           
    </div><!-- /.box-header -->

            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Loan Author</th>
                            <th>Payment</th>
                            <th>Accounts</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($listPay)){
                            $sl = 1;
                            foreach($listPay as $pay){ ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td>
                                            <?php echo $pay['name']; echo !empty($pay['contact'])?" [".$pay['contact']
                                                ."]":"";  ?>
                                    </td>
                                    <td><?php echo $pay['debit_amount']; ?></td>
                                    <td><?php echo $pay['accountName']; ?></td>
                                    <td><?php echo date('d M, Y',strtotime($pay['payment_date'])); ?></td>
                                    <td>
                                        <a href="<?php echo site_url('loan/editPay/'.$pay['id']); ?>" class="btn
                                        btn-info btn-xs btn-flat">
                                            <i class="glyphicon glyphicon-edit"></i> Edit
                                        </a>
                                        <button  class="btn btn-danger  btn-xs"  onclick="deleteLoanPay
                                        (<?php echo $pay['id'] ?> )" ><i  class="glyphicon glyphicon-remove"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

</div>
</section>