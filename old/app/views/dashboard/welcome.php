<div class="row">
    <section class="row content invoice">
        <div class="row">
            <div class="col-md-12">
                <?php
                     $isSuperAdmin = $this->session->userdata('abhinvoiser_1_1_role');
                ?>
                <a href="<?php   echo ((!empty($isSuperAdmin) && $isSuperAdmin=='superadmin')? base_url('reports/dailySalesStatement'):'')?>">
                    <div class="col-md-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <div style="height:35px;">
                                    <h4 style=" text-align: center"><?php echo (!empty($todaySalesInfo)?$todaySalesInfo:'0.00') ?></h4>
                                </div>
                                <hr>
                                <p style="font-size: 14px; text-align: center">TODAY SALES </p>
                            </div>

                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="col-md-4">
                        <div class="small-box bg-maroon-gradient">
                            <div class="inner">
                                <div style="height:35px;">
                                    <h4 style=" text-align: center"><?php echo (!empty($todayDueCollection)?$todayDueCollection:'0.00') ?></h4>
                                </div>
                                <hr>
                                <p style="font-size: 14px; text-align: center">TODAY DUE COLLECT </p>
                            </div>

                        </div>
                    </div>
                </a>
                <a href="<?php   echo ((!empty($isSuperAdmin) && $isSuperAdmin=='superadmin')? base_url('Reports/expReports'):'')?>">
                    <div class="col-md-4">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <div style="height:35px;">
                                    <h4 style=" text-align: center"><?php echo (!empty($todayExpenseInfo)?$todayExpenseInfo:'0.00') ?></h4>
                                </div>
                                <hr>
                                <p style="font-size: 14px; text-align: center">TODAY EXPENSE </p>
                            </div>

                        </div>
                    </div>
                </a>


            </div>
        </div>
    </section>
</div>

