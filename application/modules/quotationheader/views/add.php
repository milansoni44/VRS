        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script>
             var row_ids ;
            
            $(document).ready(function(){
                
                $(window).load(function(){
                   var seq = $('#seq').val();
                    row_ids = seq.split(',');
                });
                var count=<?php echo sizeof($vehicle)?>;
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
                                        for($i = 0;$i <sizeof($vehicle); $i++){
                                    ?>
                                    '<option value="<?php echo $vehicle[$i]['id'];?>"><?php echo $vehicle[$i]['vehicle_reg_no']." ".$vehicle[$i]['brand']; ?></option>'+
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
                    alert("First row not allowed to delete");
                }else{
                    var row = document.getElementById(rowid);
                    row.parentNode.removeChild(row);
                    seq = document.getElementById("seq").value;
                    seqarray = seq.split(",");
                    for(var i=0 ; i<seqarray.length ; i++){
                            //alert(seqarray[i]+"and rowid :"+rowid);
                            if(seqarray[i] == rowid){
                                
                                seqarray.splice(i, 1);
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
                    <form class="form-horizontal" role="form" method="post" action="add">
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
                                                <option value="<?php echo $name['id'] ?>"><?php echo $name['branch_name'] ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 control-label col-lg-2" for="quotation_date">Quotation Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input class="form-control form-control-inline input-medium default-date-picker" type="text" id="quotation_date" placeholder="Select Quotation Date" name="quotation_date"/>   
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
                                                <option value="<?php echo $name1['id']; ?>"><?php echo $name1['en_name'] ?></option>
                                                <?php         
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <label  class="col-lg-2 col-sm-2 control-label" for="validity">Validity Upto <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Validity in Days" id="validity" name="validity">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="status">Status</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="status" name="status" disabled>
                                                <option value="Sent">Sent</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="No Reply">No Reply</option>
                                                <option value="Cancelled">Cancelled</option>
                                                <option value="Regret">Regret</option>
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
                                                $k = 1;
                                                for($i = 0;$i < sizeof($vehicle); $i++){
                                                    
                                                    $selectedValue = 0;
                                            ?>
                                            <tr id="<?php echo $i+1?>">
                                                <td>
                                                    <select class="form-control" id="brand-<?php echo $i+1;?>" name="brand<?php echo $i+1;?>" onchange="getVehicle(this);">
                                                        <option value="0">-- Select --</option>
                                                        
                                                        <?php  for($j = 0;$j < sizeof($vehicle); $j++){ ?>
                                                        <option <?php if($i==$j){ ?> selected <?php } ?> value="<?php echo $vehicle[$j]['id'];?>"><?php echo $vehicle[$j]['vehicle_reg_no']." ".$vehicle[$j]['brand']; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Model Year" id="model-<?php echo $i+1;?>" name="model<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['model_year'];?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Engine" id="engine-<?php echo $i+1;?>" name="engine<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['engine_capacity'];?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Daily Rate" id="daily_rate-<?php echo $i+1;?>" name="daily_rate<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['daily_rate'];?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Weekly Rate" id="weekly_rate-<?php echo $i+1;?>" name="weekly_rate<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['weekly_rate'];?>">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Monthly Rate" id="monthly_rate-<?php echo $i+1;?>" name="monthly_rate<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['month_rate'];?>">
                                                </td>
                                                <td>
                                                    <select class="form-control" id="insurance-<?php echo $i+1;?>" name="insurance<?php echo $i+1;?>">
                                                        <option value="0">-- Select --</option>
                                                        <option <?php if($vehicle[$i]['insurance_type']=='Comprehensive'){?> selected <?php } ?> value="Comprehensive">Comprehensive</option>
                                                        <option <?php if($vehicle[$i]['insurance_type']=='Third Party'){?> selected <?php } ?> value="Third Party">Third Party</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="breakdown-<?php echo $i+1;?>" name="breakdown<?php echo $i+1;?>">
                                                        <option value="0">-- Select --</option>
                                                        <option  <?php if($vehicle[$i]['breakdown_recovery']=='yes'){?> selected <?php } ?> value="yes">Yes</option>
                                                        <option <?php if($vehicle[$i]['breakdown_recovery']=='no'){?> selected <?php } ?> value="no">No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="General Remarks" id="general_remarks-<?php echo $i+1;?>" name="general_remarks<?php echo $i+1;?>" value="<?php echo $vehicle[$i]['remarks'];?>">
                                                </td>   
                                                <td>
                                                    <button class="btn btn-primary" type="button" id="remove" style="<?php if($k == 1){?>display:none<?php }?>" onclick="deleteRow(<?php echo $i+1;?>);">Remove</button>
                                                    <?php 
                                                        $sequance[] = $k;
                                                        $k++; 
                                                    ?>
                                                </td>
                                            </tr>
                                             <?php
                                                  }
                                             ?>
                                        </table>
                                    </div>
                                    <input type="hidden" name="seq" id="seq" value="<?php echo implode(",", $sequance); ?>"></input>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>