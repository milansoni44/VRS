        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <?php 
            if($this->form_validation->run() == true){
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#transaction_header').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bProcessing": true,
                "bServerSide": true,
                "aoColumnDefs" : [
                    {"aTargets": [1],"mRender": format_ddmmyyyy},
				],
                "sAjaxSource": '<?php echo base_url(); ?>index.php/transactions/account_statement_details?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&rental_type=<?php echo $this->input->post('rental_type'); ?>',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ":20,
                        "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/img/ajax-loader.gif'>"
                },  
                "fnInitComplete": function() {
                        //oTable.fnAdjustColumnSizing();
                 },
                    'fnServerData': function(sSource, aoData, fnCallback)
                    {
                      $.ajax
                      ({
                        'dataType': 'json',
                        'type'    : 'POST',
                        'url'     : sSource,
                        'data'    : aoData,
                        'success' : fnCallback
                      });
                    },
                    "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                        /*
                         * Calculate the total market share for all browsers in this table (ie inc. outside
                         * the pagination)
                         */
                        var drAmount = 0;
                        for ( var i=0 ; i<aaData.length ; i++ )
                        {
                            drAmount += aaData[i][4]*1;
                        }
                        // alert(drAmount);
                        /* Calculate the market share for browsers on this page */
                        var crAmount = 0;
                        for ( var j=0 ; j<aaData.length ; j++ )
                        {
                            crAmount += aaData[ aiDisplay[j] ][5]*1;
                        }
                        // // alert(totalExpense);
                        // /* Modify the footer row to match what we want */
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[4].innerHTML = parseFloat(drAmount).toFixed(3);
                        nCells[5].innerHTML = parseFloat(crAmount).toFixed(3);
                    }
            } );
        } );
        function format_ddmmyyyy(oObj) {
            // console.log(oObj);
            // var sValue = oObj.aData([oObj.iDataColumn]);
            var sValue = oObj;
            var aDate = sValue.split('-');
            if(aDate[2] + "/" + aDate[1] + "/" + aDate[0] == "00/00/0000")
            {
                return "";
            }else{
                return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
            }
        }
        </script>
        <?php 
            }
        ?>
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Home</a>
                </li>
                <li class="active"> <?php echo $page_title; ?> </li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <section class="wrapper">
        <?php echo $this->session->flashdata('success');?>
        <?php echo validation_errors();?>
        <?php if(isset($error)) { echo $error; }?>
        <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?> Form
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="account_statement">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Account Statement period<span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php if(!$this->input->post('start_date')){ echo date('d/m/Y'); }else { echo set_value('start_date'); } ?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php if(!$this->input->post('end_date')){ echo date('d/m/Y'); }else { echo set_value('end_date'); } ?>"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="rental_type" class="form-control">
                                            <option value="rental" <?php if(!$this->input->post('rental_type')){ }elseif($this->input->post('rental_type') == 'rental'){ ?> selected <?php }?>>Rental</option>
                                            <option value="non-rental" <?php if(!$this->input->post('rental_type')){ }elseif($this->input->post('rental_type') == 'non-rental'){ ?> selected <?php }?>>Non Rental</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p style="margin-left:20px;">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                                    </p>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            <?php 
                if($this->form_validation->run() == true){
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?>
                            <span class="tools pull-right">
                                <!--<a class="custom-button" href="<?php echo base_url(); ?>index.php/transactions/pdf_account_statement?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>"> PDF</a>-->
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/transactions/export_account_statement?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&rental_type=<?php echo $this->input->post('rental_type'); ?>"> Export</a>
                            </span>
                        </header>
                        <?php 
                            if($this->input->post('rental_type') == 'rental'){
                        ?>
                        <div class="panel-body">
                            <div class="adv-table" id="printable">
                                <table id="transaction_header" class="table table-bordered table-hover">
                                    <thead>
                                        <th>Transaction No</th>
                                        <th>Date</th>
                                        <th>Vehicle No</th>
                                        <th>Description</th>
                                        <th>Dr Amount</th>
                                        <th>Cr Amount</th>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                            <a href="<?php echo base_url(); ?>" class="btn btn-danger" type="button">Dashboard</a>
                        </div>
                        <?php
                            }else{
                        ?>
                        <div class="panel-body">
                            <div class="adv-table" id="printable">
                                <table id="transaction_header" class="table table-bordered table-hover">
                                    <thead>
                                        <th>Transaction No</th>
                                        <th>Date</th>
                                        <th>Vehicle No</th>
                                        <th>Description</th>
                                        <th>Dr Amount</th>
                                        <th>Cr Amount</th>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                            <a href="<?php echo base_url(); ?>" class="btn btn-danger" type="button">Dashboard</a>
                        </div>
                        <?php
                            }
                        ?>
                    </section>
                </div>
            </div>
            <?php 
                }
            ?>
        <!-- page end-->
        </section>
        <!--body wrapper end-->
        <!--pickers plugins-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>