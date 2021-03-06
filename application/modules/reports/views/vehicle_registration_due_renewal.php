        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <?php 
            if($this->form_validation->run() == true){
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#vehicle_registration_due_renewal').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bProcessing": true,
                "bServerSide": true,
				"aoColumnDefs" : [
                    {"aTargets": [3],"mRender": format_ddmmyyyy},
					{"aTargets": [4],"mRender": format_ddmmyyyy},
                ],
                "sAjaxSource": '<?php echo base_url(); ?>index.php/reports/vehicle_registration_due_renewal?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&due=<?php echo $this->input->post('due_renewal'); ?>',
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
                            <form class="form-horizontal" role="form" method="post" action="vehicle_registration_due">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Vehicle Due Renewal <span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php if(!$this->input->post('start_date')){ echo date('d/m/Y'); }else{ echo set_value('start_date');} ?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php if(!$this->input->post('end_date')){ echo date('d/m/Y'); }else{ echo set_value('end_date');} ?>"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="due_renewal" name="due_renewal">
                                            <option value="0"> Both </option>
                                            <option value="1"> Registration Renewal </option>
                                            <option value="2"> Insurance Renewal </option>
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/reports/vehicle_due_renewal_export?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&due=<?php echo $this->input->post('due_renewal'); ?>"> Export</a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <?php
                                    $tmpl = array ( 'table_open'  => '<table id="vehicle_registration_due_renewal" class="table table-bordered table-hover">' );
                                    $this->table->set_template($tmpl);
                                    $this->table->set_heading('Sno','Vehicle Reg. No','Insurance Company','Date Of Insurance Renewal','Date Of Registration Renewal');
                                    echo $this->table->generate();
                                ?>
                            </div>
                            <a href="<?php echo base_url(); ?>" class="btn btn-danger" type="button">Dashboard</a>
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