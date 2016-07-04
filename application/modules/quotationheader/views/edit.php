        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script>
              var row_ids ;
            var count;
            $(document).ready(function(){
               
                $(window).load(function(){
                    // alert();
                     //document.getElementById("seq").value
                    
                    var seq = $('#seq').val();
                    row_ids = seq.split(',');
                    count = seq.split(',').length+1;
                });
                
                $('#submit').click(function(){
                    
                    for(var a = 1 ; a <= row_ids.length ; a++){
                            
                        if(($("#brand-"+a).val()) == 0){
                            alert("Please select the Vehicle Brand");
                            return false;                       
                        }
                    }
                });
                $('#add').click(function(){
                    
                    var rowVal = count;
                     
                    row_ids.push(count);
                    $('#myTable tr:last').after(
                        '<tr id='+count+'>'+
                            '<td>'+
                                '<select class="form-control" id="brand-'+count+'" name="brand'+count+'" onchange="getVehicle(this);">'+
                                    '<option value="0">-- Select --</option>'+
                                    <?php 
                                        for($i = 0;$i < sizeof($brand); $i++){
                                    ?>
                                    '<option value="<?php echo $vehicle_id[$i];?>"><?php echo $vehicle_reg_no[$i]." ".$brand[$i]; ?></option>'+
                                    <?php
                                        }
                                    ?>
                                    '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Model" id="model-'+count+'" name="model'+count+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Engine" id="engine-'+count+'" name="engine'+count+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Daily Rate" id="daily_rate-'+count+'" name="daily_rate'+count+'"></td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Weekly Rate" id="weekly_rate-'+count+'" name="weekly_rate'+count+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Monthly Rate" id="monthly_rate-'+count+'" name="monthly_rate'+count+'">'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" id="insurance-'+count+'" name="insurance'+count+'">'+
                                    '<option>-- Select --</option>'+
                                    '<option value="Comprehensive">Comprehensive</option>'+
                                    '<option value="Third Party">Third Party</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" id="breakdown-'+count+'" name="breakdown'+count+'">'+
                                    '<option>-- Select --</option>'+
                                    '<option value="yes">Yes</option>'+
                                    '<option value="no">No</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="General Remarks" id="general_remarks-'+count+'" name="general_remarks'+count+'">'+
                            '</td>'+
                            '<td>'+
                                '<button class="btn btn-primary" type="button" id="remove" onclick="deleteRow('+count+')">Remove</button>'+
                            '</td>'+
                        '</tr>'
                        
                    );
                    //row_ids.push(count);
                    document.getElementById("seq").value = row_ids.toString();
                    count++;
                    
                    
                });
            });
            function deleteRow(rowid)  
            {   
                // alert(rowid);
                if(rowid==1){
                    alert("First records is not allowed to delete");
                }else{
                    var row = document.getElementById(rowid);
                    row.parentNode.removeChild(row);
                    seq = document.getElementById("seq").value;
                    seqarray = seq.split(",");
                    for(var i=0 ; i<seqarray.length ; i++){
                            //alert(seqarray[i]+"and rowid :"+rowid);
                            if(seqarray[i] == rowid){
                                
                                seqarray.splice(i, 1);
                                row_ids = seqarray;
                                
                                //alert(seqarray);
                                break;
                            }
                    }
                    
                    document.getElementById("seq").value = seqarray.toString();
                    // position = $.inArray(rowid, row_ids);
                    // if ( ~position ) row_ids.splice(position, 1);
                    // document.getElementById("seq").value = row_ids.toString();
                     // alert(document.getElementById("seq").value);
                }
            }
            function getVehicle(object)
            {
                var vehicle_id = object.value;
                var id = object.id.toString();
                var id1 = id.split("-");
                
                // alert(id1[1]);
                
                var model = '#model-'+id1[1];
                var engine_capacity = '#engine-'+id1[1];
                var daily_rate = '#daily_rate-'+id1[1];
                var weekly_rate = '#weekly_rate-'+id1[1];
                var month_rate = '#monthly_rate-'+id1[1];
                var insurance_type = '#insurance-'+id1[1];
                var breakdown_recovery = '#breakdown-'+id1[1];
                var remarks = '#general_remarks-'+id1[1];
                // alert(vehicle_id);
                //alert(object.value);
                if(vehicle_id == 0){
                    alert("Please select model.");
                }
                else{
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/quotationheader/scanVehicle",
                            cache: false,				
                            data: {vehicle_id: vehicle_id},
                            async:false,
                            success: function(json){
                            // try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                $(model).val(obj.model_year);
                                $(engine_capacity).val(obj.engine_capacity);
                                $(daily_rate).val(obj.daily_rate);
                                $(weekly_rate).val(obj.weekly_rate);
                                $(month_rate).val(obj.month_rate);
                                $(insurance_type).val(obj.insurance_type);
                                $(breakdown_recovery).val(obj.breakdown_recovery);
                                $(remarks).val(obj.remarks);
                                
                            // }catch(e) {		
                            // alert(e);
                            // alert('Exception while request..');
                            // }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                }
            }
        </script>
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
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="branch">Branch <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="branch" name="branch">
                                                <option value="0">--Select Branch--</option>
                                                <?php 
                                                    foreach($branch as $name)
                                                    {
                                                ?>  
                                                <option <?php if($quotation_header->branch_id == $name['id']) {?> Selected <?php } ?> value="<?php echo $name['id'] ?>"><?php echo $name['branch_name'] ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 control-label col-lg-2" for="quotation_date">Quotation Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="quotation_date" placeholder="Select Quotation Date" name="quotation_date" value="<?php echo $quotation_header->quotation_date; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="customer_id">Customer <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="customer_id" name="customer">
                                                <option value="0">--Select Customer--</option>
                                                <?php 
                                                    foreach($customer as $name1)
                                                    {
                                                ?>
                                                <option <?php if($quotation_header->customer_id == $name1['id']) {?> Selected <?php } ?> value="<?php echo $name1['id']; ?>"><?php echo $name1['en_name'] ?></option>
                                                <?php         
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <label  class="col-lg-2 col-sm-2 control-label" for="validity">Validity Upto <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Validity in Days" id="validity" name="validity" value="<?php echo $quotation_header->validity_upto; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="status">Status</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="status" name="status">
                                                <option value="Sent" <?php if($quotation_header->status == 'Sent'){ ?>Selected <?php }?>>Sent</option>
                                                <option value="Accepted" <?php if($quotation_header->status == 'Accepted'){ ?>Selected <?php }?>>Accepted</option>
                                                <option value="No Reply" <?php if($quotation_header->status == 'No Reply'){ ?>Selected <?php }?>>No Reply</option>
                                                <option value="Cancelled" <?php if($quotation_header->status == 'Cancelled'){ ?>Selected <?php }?>>Cancelled</option>
                                                <option value="Regret" <?php if($quotation_header->status == 'Regret'){ ?>Selected <?php }?>>Regret</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel-body">
                                    <p>
                                        <button class="btn btn-primary" type="button" id="add">Add</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="myTable">
                                            <tr>
                                                <td><label>Brand / Model <span style="color:red;">*</span></label></td>
                                                <td><label>Model</label></td>
                                                <td><label>Engine</label></td>
                                                <td><label>Daily Rate</label></td>
                                                <td><label>Weekly Rate</label></td>
                                                <td><label>Monthly Rate</label></td>
                                                <td><label>Insurance</label></td>
                                                <td><label>Breakdown Recovery</label></td>
                                                <td><label>General Remarks</label></td>
                                                <td><label>Remove</label></td>
                                            </tr>
                                            <?php 
                                                // echo '<pre>';
                                                // print_r($quotation_details);
                                                // echo '</pre>';
                                                $k=0;
                                                for($j=1;$j<=sizeof($quotation_details);$j++){
                                            ?>
                                            <tr id="<?php echo $j; ?>">
                                                <td>
                                                    <select class="form-control" id="brand-<?php echo $j; ?>" name="brand<?php echo $j; ?>" onchange="getVehicle(this);">
                                                        <option value="0">-- Select --</option>
                                                        <?php 
                                                            for($i = 0;$i < sizeof($brand); $i++){
                                                        ?>
                                                        <option <?php if($quotation_details[$k]['vehicle_id'] == $vehicle_id[$i]) { ?>selected <?php } ?> value="<?php echo $vehicle_id[$i];?>"><?php echo $vehicle_reg_no[$i]." ".$brand[$i]; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Model Year" id="model-<?php echo $j; ?>" name="model<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['model_year']; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Engine" id="engine-<?php echo $j; ?>" name="engine<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['engine_capacity']; ?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Daily Rate" id="daily_rate-<?php echo $j; ?>" name="daily_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['daily_rate']; ?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Weekly Rate" id="weekly_rate-<?php echo $j; ?>" name="weekly_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['weekly_rate']; ?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Monthly Rate" id="monthly_rate-<?php echo $j; ?>" name="monthly_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['monthly_rate']; ?>">
                                                </td>
                                                <td>
                                                    <select class="form-control" id="insurance-<?php echo $j; ?>" name="insurance<?php echo $j; ?>">
                                                        <option value="0">-- Select --</option>
                                                        <option <?php if($quotation_details[$k]['insurance_type'] == 'Comprehensive') { ?>selected <?php } ?> value="Comprehensive">Comprehensive</option>
                                                        <option <?php if($quotation_details[$k]['insurance_type'] == 'Third Party') { ?>selected <?php } ?> value="Third Party">Third Party</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="breakdown-<?php echo $j; ?>" name="breakdown<?php echo $j; ?>">
                                                        <option value="0">-- Select --</option>
                                                        <option <?php if($quotation_details[$k]['breakdown_recovery'] == 'yes') { ?>selected <?php } ?> value="yes">Yes</option>
                                                        <option <?php if($quotation_details[$k]['breakdown_recovery'] == 'no') { ?>selected <?php } ?> value="no">No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="General Remarks" id="general_remarks-<?php echo $j; ?>" name="general_remarks<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['remarks']; ?>">
                                                </td>   
                                                <td>
                                                    <button class="btn btn-primary" type="button" id="remove" onclick="deleteRow(<?php echo $j; ?>);">Remove</button>
                                                    <?php 
                                                        $seq[] = $j;
                                                    ?>  
                                                   
                                                </td>
                                            </tr>
                                            <?php
                                                $k++;
                                                }
                                                 $seq1 = implode(',',$seq);
                                            ?>
                                             <input type="hidden" name="seq" id="seq" value="<?php echo $seq1; ?>"></input>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/quotationheader" class="btn btn-default" type="button">Cancel</a>
                            </p>
                        </div>
                    </form>
                    
                </section>
            </div>
        </div>
        <!--pickers plugins-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>