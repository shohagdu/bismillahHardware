<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="">
            <div class="box no-border" >
                <div class="box-header">
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-warning btn-sm pull-right no-print"  onclick="goBack()" ><i
                            class="glyphicon glyphicon-backward"></i> Back</button>
                    <button class="btn btn-primary btn-sm pull-right no-print" style="margin-right:5px;"
                            onclick="window
                    .print()
"><i
                            class="glyphicon glyphicon-print"></i> Print</button>


                </div>

                <div class="clearfix"></div>
                <div class="box-body">
                    <table class="table-style width70per"  style="margin-bottom:10px;">
                        <tr>
                            <th class="text-left width20per" >Name</th>
                            <td class="text-left width30per"><?php echo (!empty($customer_info->name)
                                    ?$customer_info->name:'')
                                ?></td>
                            <th class="text-left width20per">Mobile</th>
                            <td class="text-left width30per"><?php echo (!empty($customer_info->mobile)
                                    ?$customer_info->mobile:'') ?></td>
                        </tr>
                        <tr>
                            <th class="text-left">Email</th>
                            <td class="text-left"><?php echo (!empty($customer_info->email)?$customer_info->email:'') ?></td>
                            <th class="text-left">Date of Birth</th>
                            <td class="text-left"><?php echo (!empty($customer_info->date_of_birth)
                                    ?date('d M, Y',strtotime($customer_info->date_of_birth)):'')
                                ?></td>
                        </tr>
                        <tr>
                            <th class="text-left">Address</th>
                            <td class="text-left"><?php echo (!empty($customer_info->address)?$customer_info->address:'') ?></td>
                            <th class="text-left">Remarks</th>
                            <td class="text-left"><?php echo (!empty($customer_info->remarks)?$customer_info->remarks:'') ?></td>
                        </tr>


                    </table>
                    <table  class="table-style width100per" >
                        <thead>
                        <tr>
                            <th> SL</th>
                            <th class="width20per"> Type</th>
                            <th class="width10per"> Date</th>
                            <th > Remarks</th>
                            <th class="width10per text-right"> Debit</th>
                            <th class="width10per text-right"> Credit</th>
                            <th class="width10per text-right"> Balance </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tDebitQty      =   '0.00';
                        $tCreditQty     =   '0.00';
                        $balance        =   '0.00';
                        if(!empty($info)){
                            $i=1;
                            foreach ($info as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td class="text-left"><?php
                                        if(!empty($row->type) && $row->type==6){
                                            echo "Purchase From Supplier";
                                        }elseif(!empty($row->type) && $row->type==7){
                                            echo "Supplier Payment";
                                        }
                                    ?></td>
                                    <td class="text-left">
                                        <?php
                                            echo(!empty($row->payment_date) ? date('d M, Y', strtotime
                                            ($row->payment_date)) : '');
                                        ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo (!empty($row->remarks)?$row->remarks:'');
                                        ?>

                                        <?php echo (!empty($row->transCode)?" >> TRNS ID # ".$row->transCode:'');
                                        ?>
                                        <?php echo (!empty($row->purchase_id)?" >> PUR. ID # ".$row->purchase_id:'');
                                        ?>

                                    </td>


                                    <td class="text-right padding-right-5px">
                                        <?php
                                            echo !empty($row->debit_amount)?number_format
                                            ($row->debit_amount,2):'0.00'; $tDebitQty+=!empty($row->debit_amount)?$row->debit_amount:'0.00';
                                        ?>
                                    </td>
                                    <td class="text-right padding-right-5px">
                                        <?php
                                             echo !empty($row->credit_amount)?number_format
                                            ($row->credit_amount,2):'0.00';
                                             $tCreditQty+= !empty($row->credit_amount)
                                            ?$row->credit_amount:'0.00';
                                        ?>
                                    </td>
                                    <td class="text-right padding-right-5px">
                                        <?php
                                         $balance += ((!empty($row->debit_amount)?$row->debit_amount:'0.00') -
                                            (!empty
                                        ($row->credit_amount)
                                            ?$row->credit_amount:'0.00'));
                                        echo number_format($balance,2);
                                        ?>
                                    </td>



                                </tr>
                                <?php
                            }
                        }else{
                            echo "<tr><td colspan='8' class='red'>No Data Exist</td></tr>";
                        }
                        ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total Summery</th>
                                <th class="text-right padding-right-5px"><?php echo (!empty($tDebitQty)?number_format($tDebitQty,2):'0')
                                    ?></th>
                                <th class="text-right padding-right-5px"><?php echo (!empty($tCreditQty)?number_format
                                    ($tCreditQty,2)
                                        :'0.00') ?></th>
                                <th class="text-right"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
