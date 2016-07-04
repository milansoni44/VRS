        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <?php 
            if($this->form_validation->run() == true){
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#vehicle_income_expense').dataTable({
                "aoColumnDefs": [
                    { "bVisible": false, "aTargets": [ 2 ] }
                ],
                "aaSortingFixed": [[ 2, 'asc' ]],
                "fnDrawCallback":function(oSettings){
                    if( oSettings.aiDisplay.length == 0 )
                    {
                        return ;
                    }
                    
                    var nTrs = $('#vehicle_income_expense tbody tr');
                    var iColspan = nTrs[0].getElementsByTagName( 'td' ).length;
                    var sLastGroup = "";
                    for ( var i=0 ; i<nTrs.length ; i++ ){
                        var iDisplayIndex = oSettings._iDisplayStart + i;
                        var sGroup = oSettings.aoData[ i ]._aData[2];
                        if ( sGroup != sLastGroup )
                        {
                            var nGroup = document.createElement( 'tr' );
                            var nCell = document.createElement( 'th' );
                            nCell.colSpan = iColspan;
                            nCell.className = "group";
                            nCell.innerHTML = sGroup;
                            nGroup.appendChild( nCell );
                            nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
                            sLastGroup = sGroup;
                        }
                    }
                },
                "tableTools": {
                    "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php/transactions/vehicle_income_expense_details?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&vehicle=<?php echo $this->input->post('vehicle'); ?>',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ":20,
                        "order": [[ 1, 'asc' ]],
                        "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/img/ajax-loader.gif'>"
                },
                "fnInitComplete": function() { },
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
                    var totalIncome = 0;
                    for ( var i=0 ; i<aaData.length ; i++ )
                    {
                        totalIncome += aaData[i][3]*1;
                    }
                    // alert(totalIncome);
                    /* Calculate the market share for browsers on this page */
                    var totalExpense = 0;
                    for ( var j=0 ; j<aaData.length ; j++ )
                    {
                        totalExpense += aaData[ aiDisplay[j] ][4]*1;
                    }
                    // alert(totalExpense);
                    /* Modify the footer row to match what we want */
                    var nCells = nRow.getElementsByTagName('th');
                    nCells[2].innerHTML = parseFloat(totalIncome).toFixed(3);
                    nCells[3].innerHTML = parseFloat(totalExpense).toFixed(3);
               }
			});
		});
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
                    <a href="<?php echo base_url(); ?>">Home</a>
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
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="vehicle_wise_income_expense">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Vehicle income expense period<span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php if(!$this->input->post('start_date')){ echo date('d/m/Y'); }else{ echo set_value('start_date'); }?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php if(!$this->input->post('end_date')){ echo date('d/m/Y'); }else{ echo set_value('end_date'); }?>"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-control chosen-select" id="vehicle" name="vehicle">
                                            <option value="0"> All </option>
                                            <?php
                                                foreach($vehicle as $vehicle_name)
                                                {
                                                    echo "<option value='$vehicle_name[id]' " . set_select('vehicle', $vehicle_name['id']) . " >".$vehicle_name['vehicle_reg_no'].".  ".$vehicle_name['brand']."</option>";
                                                }
                                            ?>
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/transactions/export_vehicle_income_expens?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&vehicle=<?php echo $this->input->post('vehicle'); ?>"> Export</a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <?php
                                    // $tmpl = array ( 'table_open'  => '<table id="vehicle_income_expense" class="table table-bordered table-hover">' );
                                    // $this->table->set_template($tmpl);
                                    // $this->table->set_heading('Transaction Id','Transaction Date','Vehicle No','Brand','Description','Income','Expense');
                                    // echo $this->table->generate();
                                ?>
                                <table id="vehicle_income_expense" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Vehicle No</th>
                                            <th>Brand</th>
                                            <th>Vehicle Owner</th>
                                            <th>Income</th>
                                            <th>Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Total:</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
        <script src="<?php echo base_url(); ?>assets/js/choosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
        </script>