        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#ledger_view').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php/transactions/ledger_wise_transaction_details?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&ledger=<?php echo $this->input->post('ledger'); ?>',
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
        </script>
        
        <div class="page-heading">
            <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $this->session->flashdata('success');?>
            </div>
            <?php 
            }
            ?>
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
        
        <!--body wrapper start-->
        <div class="wrapper">
        <?php echo $this->session->flashdata('success');?>
        <?php echo validation_errors();?>
        <?php if(isset($error)) { echo $error; }?>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?>
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="ledger_wise_transaction">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Ledger Wise period<span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php if(!$this->input->post('start_date')){ echo date('d/m/Y'); }else { echo set_value('start_date'); } ?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php if(!$this->input->post('end_date')){ echo date('d/m/Y'); }else { echo set_value('end_date'); } ?>"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="ledger" name="ledger">
                                            <option value="0"> All </option>
                                            <?php
                                                foreach($ledger as $title)
                                                {
                                                    echo "<option value='$title[id]' " . set_select('ledger', $title['id']) . " >". $title['title']."</option>";
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/transactions/export_ledger_wise_transaction?start_date=<?php echo $this->input->post('start_date'); ?>&end_date=<?php echo $this->input->post('end_date'); ?>&ledger=<?php echo $this->input->post('ledger'); ?>"> Export</a>
                            </span>
                        </header>
                        <?php
                            if($this->input->post('ledger') == 0){
                        ?>
                        <div class="panel-body">
                            <div class="adv-table" id="printable">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Transaction Date</th>
                                        <th>Vehicle No</th>
                                        <th>Description</th>
                                        <th>DrAmount</th>
                                        <th>CrAmount</th>
                                    </tr>
                                    <?php
                                        for($i = 0;$i<sizeof($transaction);$i++){
                                            $title = explode('|',$transaction[$i]);
                                    ?>
                                    <tr>
                                        <td colspan="6"><?php echo $title[0]; ?></td>
                                    </tr>
                                    
                                    <?php
                                            $transactions = explode('*',$title[1]);
                                            for($j=0;$j<sizeof($transactions);$j++){
                                    ?>
                                    <tr>
                                    <?php
                                                $a = explode('+',$transactions[$j]);
                                                for($k=0;$k<sizeof($a);$k++)
                                                {
                                    ?>
                                        <td><?php echo $a[$k]; ?></td>
                                    <?php
                                                }
                                    ?>
                                    </tr>
                                    <?php
                                            }
                                    ?>
                                    
                                    <?php
                                        }
                                    ?>
                                </table>
                            </div>
                            <div style="float:right">
                                <span class="pull-left"><b>Total DrAmount : </b></span>
                                <span class="pull-left" style="padding-right:52px;"><?php echo $total->DebitTotal; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="pull-left"><b>Total CrAmount : </b></span>
                                <span class="pull-right" style="padding-right:40px;"><?php echo $total->CreditTotal; ?></span>
                            </div>
                        </div>
                        <?php
                            }else{
                        ?>
                        <div class="panel-body">
                            <div class="adv-table" id="printable">
                                <?php
                                    $tmpl = array ( 'table_open'  => '<table id="ledger_view" class="table table-bordered table-hover">' );
                                    $this->table->set_template($tmpl);
                                    $this->table->set_heading('Transaction No','Date','vehicle No','Ledger','Description','Dr Amount','Cr Amount');
                                    echo $this->table->generate();
                                ?>
                            </div>
                            <div style="float:right">
                                <span class="pull-left"><b>Total DrAmount : </b></span>
                                <span class="pull-left" style="padding-right:52px;"><?php echo $total->CreditTotal; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="pull-left"><b>Total CrAmount : </b></span>
                                <span class="pull-right" style="padding-right:40px;"><?php echo $total->DebitTotal; ?></span>
                            </div>
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
        </div>
        <!--body wrapper end-->
        <!--pickers plugins-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>