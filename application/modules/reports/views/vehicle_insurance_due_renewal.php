        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <?php 
            if($this->form_validation->run() == true){
        ?>
        tableTools: {
    "sSwfPath": "https://datatables.net/release-datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
    "sRowSelect": "os",
    "sRowSelector": 'td:first-child',
    // "aButtons": [ "copy", "csv", "xls","pdf","print","select_all", "select_none" ]
    "aButtons": [
        "copy",
        "print", {
            "sExtends": "collection",
            "sButtonText": "Save", // button name 
            // "aButtons":    [ "csv", "xls", "pdf" ]
            "aButtons": [
                "csv",
                "xls", {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "List of product."
                },
                "print"
            ]
        }
    ]
}    
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
                            <form class="form-horizontal" role="form" method="post" action="vehicle_insurance_due">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Vehicle Insurance Due Renewal <span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php if(!$this->input->post('start_date')){ echo date('d/m/Y'); }else{ echo set_value('start_date'); }?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php if(!$this->input->post('end_date')){ echo date('d/m/Y'); }else{ echo set_value('end_date'); }?>"/>
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/reports/vehicle_insurance_due_export?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>"> Export</a>
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