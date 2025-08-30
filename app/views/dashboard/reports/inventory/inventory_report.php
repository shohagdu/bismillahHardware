<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                        id="show_message"></span></div></div>
        <div >
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i
                                class="glyphicon glyphicon-print"></i> Print</button>
                </div>
                <form action="" method="post" id="inventoryReportForm">
                    <div class="form-group no-print">
                        <div class="col-sm-3">
                            <label>Product Name/Code</label>
                            <div class="clearfix"></div>
                            <input type="text" id="productName_1" required data-type="productName" placeholder="Product Name / Code" class="productName form-control">
                            <input type="hidden" name="product_id" id="productID_1" class="form-control">

                        </div>
                        <div class="col-sm-2">
                            <label>Brand</label>
                            <div class="clearfix"></div>
                            <select id="bandID" name="bandID" class="form-control" >
                                <option value="">Select Band</option>
                                <?php if(!empty($bandInfo)){ foreach ($bandInfo as $brand) { ?>
                                    <option value="<?php echo $brand->id; ?>"><?php echo $brand->title; ?></option>
                                <?php } }?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Brand</label>
                            <div class="clearfix"></div>
                            <button type="button" onclick="searchingInvantoryReport()" class="btn btn-info" ><i
                                        class="glyphicon
                            glyphicon-search" ></i> Search</button>
                        </div>

                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <div id="stock_info_data">
                            <table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
                                <thead>

                                <tr>
                                    <td class="font-weight-bold"> SL</td>
                                    <td class="font-weight-bold width30per"> Product name</td>
                                    <td class="font-weight-bold">In(Op+In) </td>
                                    <td class="font-weight-bold">Out(S+T)</td>
                                    <td class="font-weight-bold" >Balance</td>
                                    <td class="font-weight-bold width20per" nowrap="" >Purchase/Sale </td>
                                    <td class="font-weight-bold" >T. Pur. </td>
                                    <td class="font-weight-bold" >T. Sale </td>
                                    <td class="no-print font-weight-bold " style="width: 10%;">Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=1;
                                $totalPurchaseAmnt=0;
                                $totalSalesAmnt=0;
                                $stockQty=0;
                                if(!empty($info)){
                                    foreach ($info as $row) {
                                        if($row->current_stock_item>0){
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td class="text-left"><?php echo $row->name.' ['.$row->productCode.']'; ?><?php echo (!empty($row->bandTitle)?"     [".$row->bandTitle.']':''); ?></td>
                                            <td><i class="badge"><?php echo $row->debit_item_info; ?></i></td>
                                            <td><i class="badge"><?php echo $row->credit_item_info; ?></i></td>
                                            <td><i class="badge"><?php echo $stock= $row->current_stock_item; $stockQty+=$stock ?></i></td>
                                            <td>
                                                <i class="badge bg-red"><?php echo (!empty($row->purchase_price)?$row->purchase_price:'0.00'); ?></i>
                                               /
                                                <i class="badge bg-green"><?php echo (!empty($row->unit_sale_price)?$row->unit_sale_price:'0.00'); ?></i>

                                               </td>
                                            <td><i class="badge"><?php echo $totalPurchase =(!empty($row->current_stock_item)?number_format($row->purchase_price*$row->current_stock_item,2,'.',''):'0.00'); $totalPurchaseAmnt+=$totalPurchase; ?></i></td>
                                            <td><i class="badge"><?php echo $totalSales =(!empty($row->current_stock_item)?number_format($row->unit_sale_price*$row->current_stock_item,2,'.',''):'0.00'); $totalSalesAmnt+=$totalSales; ?></i></td>



                                            <td class="no-print">
                                                <a href="<?php echo base_url('reports/details_inventory_report/'.$row->id)
                                                ?>" class="btn btn-info btn-xs"><i
                                                            class="glyphicon glyphicon-share-alt"></i>
                                                    Details</a>
                                            </td>

                                        </tr>
                                        <?php
                                        }
                                    }
                                }
                                ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total Amount</td>
                                        <td><i class="badge"><?php echo (!empty($stockQty)?$stockQty:'0') ?></i></td>
                                        <td></td>
                                        <td><i class="badge"><?php echo (!empty($totalPurchaseAmnt)?number_format($totalPurchaseAmnt,2):'0.00') ?></i></td>
                                        <td><i class="badge"><?php echo (!empty($totalSalesAmnt)?number_format($totalSalesAmnt,2):'0.00') ?></i></td>


                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
