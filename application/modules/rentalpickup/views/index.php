        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#rental_pickup_view').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bProcessing": true,
                "bServerSide": true,
                "aoColumnDefs" : [
                    {"aTargets": [1],"mRender": format_ddmmyyyy},
                    {"aTargets": [5],"mRender": format_ddmmyyyy},
                    {"aTargets": [6],"mRender": format_ddmmyyyy},
                ] ,
                "sAjaxSource": '<?php echo base_url(); ?>index.php/rentalpickup/rental_pickup_details',
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
            });
        });
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
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?>
                            <span class="tools pull-right">
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/rentalpickup/add"> Add Rental Pickup</a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <?php
                                    // $tmpl = array ( 'table_open'  => '<table id="rental_pickup_view" class="table table-bordered table-hover">' );
                                    // $this->table->set_template($tmpl);
                                    // // $this->table->set_heading('PickUp ID','Date Of Rental','Customer Name','Vehicle No','Rental Type','Return By','Return Date','Extra KM Amount','Rent Amount','Discount','Net Amount','Actions');
                                    // $this->table->set_heading('PickUp ID');
                                    // //$this->table->set_heading('PickUp ID','Branch','Customer Name','Date Of Rental','Vehicle No','Rental Type','Pick From');
                                    // echo $this->table->generate();
                                ?>
                                <table id="rental_pickup_view" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>PickUp ID</th>
                                            <th>Date Of Rental</th>
                                            <th>Customer Name</th>
                                            <th>Vehicle No</th>
                                            <th>Rental Type</th>
                                            <th>Return By</th>
                                            <th>Return Date</th>
                                            <th>Extra KM Amount</th>
                                            <th>Rent Amount</th>
                                            <th>Discount</th>
                                            <th>Net Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <a href="<?php echo base_url(); ?>" class="btn btn-danger" type="button">Dashboard</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>