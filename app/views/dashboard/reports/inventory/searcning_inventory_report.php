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
