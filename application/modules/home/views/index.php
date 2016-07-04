        <!-- main content start-->
        <!--body wrapper start-->
        <div class="wrapper">
            <?php if($this->session->flashdata('message')) { ?>
            <div class="alert alert-success fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $this->session->flashdata('message');?>
            </div>
            <?php 
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <section class="panel">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th colspan="5" style="text-align:center; background-color:#5AB6DF;color:#000000;">Vehicle Statistics</th>
                                </tr>
                                <tr style="vertical-align:middle;color:#000000;">
                                    <th style="background-color:#9F79EE;text-align:centre">Total</th>
                                    <th style="background-color:#6DDFB5;">Available</th>
                                    <th style="background-color:#EBC85E;">Rented</th>
                                    <th style="background-color:#319FA1;">Returned</th>
                                    <th style="background-color:#FC8675;">Garage</th>
                                </tr>
                                <tr style="text-align:center;color:#000000;">
                                    <td style="background-color:#9F79EE;"><a href="<?php echo base_url(); ?>index.php/vehicle?vehicle=total"><font color="white"><?php echo $total_vehicle; ?></font></a></td>
                                    <td style="background-color:#6DDFB5;"><a href="<?php echo base_url(); ?>index.php/vehicle?vehicle=available"><font color="white"><?php echo $total_available; ?></font></a></td>
                                    <td style="background-color:#EBC85E;"><a href="<?php echo base_url(); ?>index.php/vehicle?vehicle=rented"><font color="white"><?php echo $total_rented; ?></font></a></td>
                                    <td style="background-color:#319FA1;"><a href="<?php echo base_url(); ?>index.php/vehicle?vehicle=returned"><font color="white">0</font></a></td>
                                    <td style="background-color:#FC8675;"><a href="<?php echo base_url(); ?>index.php/vehicle?vehicle=repair"><font color="white"><?php echo $total_repair; ?></font></a></td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="col-sm-3">
                    <section class="panel">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2" style="text-align:center;background-color:#5AB6DF;color:#000000;">Day(Total - RO)</th>
                                </tr>
                                <tr style="color:#000000;">
                                    <th style="text-align:center;background-color:#65CEA7">Income</th>
                                    <th style="text-align:center;background-color:#FC8675;">Expenditure</th>
                                </tr>
                                <tr style="text-align:center;color:#000000;">
                                    <td style="background-color:#65CEA7"><?php echo $dayIncome; ?></td>
                                    <td style="background-color:#FC8675;"><?php echo $dayExpense; ?></td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="col-sm-3">
                    <section class="panel">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2" style="text-align:center;background-color:#5AB6DF;color:#000000;">Month(Total - RO)</th>
                                </tr>
                                <tr style="color:#000000;">
                                    <th style="text-align:center;background-color:#65CEA7">Income</th>
                                    <th style="text-align:center;background-color:#FC8675;">Expenditure</th>
                                </tr>
                                <tr style="text-align:center;color:#000000;">
                                    <td style="background-color:#65CEA7"><?php echo $monthly_income; ?></td>
                                    <td style="background-color:#FC8675"><?php echo $monthly_expense; ?></td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            INCOME & EXPENDITURE FOR THE MONTH (DAYWISE)
                       
                        </header>
                        <div class="panel-body">

                            <div class="chart">
                                <div id="combine-chart"></div>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <!--<div class="col-sm-6">
                     <section class="panel">
                        <header class="panel-heading">
                            Top 5 cars by rental amount				
                          <!--<span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                         <div class="panel-body">
                           <div class="chartJS" style="height: 265px;">
                                <canvas id="bar-chart-js2" height="260" width="1140" style="width: 1140px; height: 260px;"></canvas>
                            </div>
                            <div class="legend">
                                <div style="position: absolute; width: 74px; height: 40px; top: 17px; right: 34px; opacity: 0; background-color: rgb(255, 255, 255);"> </div>
                                <table style="position:absolute;top:46px;right:84px;font-size:smaller;color:#545454" cellspacing="5px">
                                    <tbody>
                                    <tr>
                                        <td class="legendColorBox"><div style="border:1px solid rgb(49,159,161);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(49,159,161);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="top1" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                        <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(235,200,94);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(235,200,94);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="top2" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(252,134,117);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(252,134,117);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="top3" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(159,121,238);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(159,121,238);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="top4" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(90,182,223);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(90,182,223);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="top5" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         
                                    </tr>
                                    
                                    </tbody>
                                </table>
                             </div>
                        </div>
                        
                    </section>
                </div>-->
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Top 5 Cars by Rental Amount
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                            <div id="graph-bar"></div>
                        </div>
                    </section>
                </div>
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Least 5 Cars By Rental Amount
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                            <div id="graph-bar1"></div>
                        </div>
                    </section>
                </div>
                <!--<div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Least 5 cars by rental amount				
                        <!--<span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                       <div class="panel-body">
                           <div class="chartJS" style="height: 265px;">
                                <canvas id="bar-chart-js3" height="260" width="1140" style="width: 1140px; height: 260px;"></canvas>
                            </div>
                            <div class="legend">
                                <div style="position: absolute; width: 74px; height: 40px; top: 17px; right: 34px; opacity: 0; background-color: rgb(255, 255, 255);"> </div>
                                <table style="position:absolute;top:46px;right:84px;font-size:smaller;color:#545454" cellspacing="5px">
                                    <tbody>
                                   <tr>
                                        <td class="legendColorBox"><div style="border:1px solid rgb(49,159,161);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(49,159,161);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="bottom1" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                        <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(235,200,94);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(235,200,94);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="bottom2" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(252,134,117);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(252,134,117);overflow:hidden"></div></div></td><td class="legendLabel" >&nbsp;&nbsp;<div id="bottom3" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(159,121,238);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(159,121,238);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="bottom4" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         <td width="5px"></td>
                                         <td class="legendColorBox"><div style="border:1px solid rgb(90,182,223);padding:1px"><div style="width:4px;height:0;border:5px solid rgb(90,182,223);overflow:hidden"></div></div></td><td class="legendLabel">&nbsp;&nbsp;<div id="bottom5" style="position: relative;top: -9px;padding-left: 5px;"></div></td>
                                         
                                    </tr>
                                    
                                    </tbody>
                                </table>
                             </div>
                        </div>
                    </section>
                </div>-->
            </div>

            <!--<div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Combined Chart
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                            <div id="combine-chart">
                                <div id="legendcontainer26" class="legend-block">
                                </div>
                                <div id="combine-chartContainer" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Toggle Chart
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                            <div id="toggle-chart">
                                <div class="clearfix">
                                    <form class="form-horizontal pull-left chart-control">
                                        <div class="control-group">
                                            <label class="control-label">Chart Type :</label>
                                            <div class="series-list">
                                                <label class="checkbox inline">
                                                    <input id="chartType1" checked name="ct" type="radio" value="line"/>
                                                    Line Chart</label>
                                                <label class="checkbox inline">
                                                    <input id="chartType2" name="ct" type="radio" value="bar"/>
                                                    Bar Chart </label>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal chart-control pull-right chart-control">
                                        <div class="control-group ">
                                            <label class="control-label"> Toggle series :</label>
                                            <div class="series-list">
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="cbdata1" checked>
                                                    data1</label>
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="cbdata2" checked>
                                                    data2 </label>
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="cbdata3" checked>
                                                    data3 </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="legendPlaceholder20">
                                </div>
                                <div id="toggle-chartContainer" style="width: 100%;height:300px; text-align: left;">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            -->
        </div>
        <!--body wrapper end-->
    <!-- main content end-->