        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <?php 
            if($this->form_validation->run() == true){
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#transaction_detail').dataTable( {
                "fnDrawCallback": function ( oSettings ) {
                if ( oSettings.aiDisplay.length == 0 )
                {
                    return;
                }
                
                    var nTrs = $('#transaction_detail tbody tr');
                    var iColspan = nTrs[0].getElementsByTagName('td').length;
                    var sLastGroup = "";
                    
                    for ( var i=0 ; i<nTrs.length ; i++ )
                    {
                        var iDisplayIndex = oSettings._iDisplayStart + i;
                        var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[4];
                        if ( sGroup != sLastGroup )
                        {
                            var nGroup = document.createElement( 'tr' );
                            var nCell = document.createElement( 'td' );
                            nCell.colSpan = iColspan;
                            nCell.className = "group";
                            nCell.innerHTML = sGroup;
                            nGroup.appendChild( nCell );
                            nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
                            sLastGroup = sGroup;
                        }
                    }
                
                },
                "aoColumnDefs": [{ "bVisible": false,  "aTargets": [2] }],
                "aaSortingFixed": [[ 2, 'asc' ]],
                "aaSorting": [[ 0, 'asc' ]],
                // "sDom": 'lfr<"giveHeight"t>ip',
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
                            <form class="form-horizontal" role="form" method="post" action="ledger_wise_transaction">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-2" for="start_date">Ledger wise transaction period<span style="color:red;">*</span></label>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="start_date" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>"/> 
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="end_date" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>"/>
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
                        <div class="panel-body">
                            <!--<div class="adv-table" id="printable">
                                <?php
                                    $tmpl = array ( 'table_open'  => '<table id="transaction_detail" class="table table-bordered table-hover">' );
                                    $this->table->set_template($tmpl);
                                    $this->table->set_heading('Transaction No','Transaction Date','legder_id','Description','Ledger','Dr Amount','Cr Amount');
                                    echo $this->table->generate();
                                ?>
                            </div>-->
                            <section id="unseen">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Company</th>
                                        <th class="numeric">Price</th>
                                        <th class="numeric">Change</th>
                                        <th class="numeric">Change %</th>
                                        <th class="numeric">Open</th>
                                        <th class="numeric">High</th>
                                        <th class="numeric">Low</th>
                                        <th class="numeric">Volume</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>AAC</td>
                                        <td>AUSTRALIAN AGRICULTURAL COMPANY LIMITED.</td>
                                        <td class="numeric">$1.38</td>
                                        <td class="numeric">-0.01</td>
                                        <td class="numeric">-0.36%</td>
                                        <td class="numeric">$1.39</td>
                                        <td class="numeric">$1.39</td>
                                        <td class="numeric">$1.38</td>
                                        <td class="numeric">9,395</td>
                                    </tr>
                                    <tr>
                                        <td>AAD</td>
                                        <td>ARDENT LEISURE GROUP</td>
                                        <td class="numeric">$1.15</td>
                                        <td class="numeric">  +0.02</td>
                                        <td class="numeric">1.32%</td>
                                        <td class="numeric">$1.14</td>
                                        <td class="numeric">$1.15</td>
                                        <td class="numeric">$1.13</td>
                                        <td class="numeric">56,431</td>
                                    </tr>
                                    <tr>
                                        <td>AAX</td>
                                        <td>AUSENCO LIMITED</td>
                                        <td class="numeric">$4.00</td>
                                        <td class="numeric">-0.04</td>
                                        <td class="numeric">-0.99%</td>
                                        <td class="numeric">$4.01</td>
                                        <td class="numeric">$4.05</td>
                                        <td class="numeric">$4.00</td>
                                        <td class="numeric">90,641</td>
                                    </tr>
                                    <tr>
                                        <td>ABC</td>
                                        <td>ADELAIDE BRIGHTON LIMITED</td>
                                        <td class="numeric">$3.00</td>
                                        <td class="numeric">  +0.06</td>
                                        <td class="numeric">2.04%</td>
                                        <td class="numeric">$2.98</td>
                                        <td class="numeric">$3.00</td>
                                        <td class="numeric">$2.96</td>
                                        <td class="numeric">862,518</td>
                                    </tr>
                                    <tr>
                                        <td>ABP</td>
                                        <td>ABACUS PROPERTY GROUP</td>
                                        <td class="numeric">$1.91</td>
                                        <td class="numeric">0.00</td>
                                        <td class="numeric">0.00%</td>
                                        <td class="numeric">$1.92</td>
                                        <td class="numeric">$1.93</td>
                                        <td class="numeric">$1.90</td>
                                        <td class="numeric">595,701</td>
                                    </tr>
                                    <tr>
                                        <td>ABY</td>
                                        <td>ADITYA BIRLA MINERALS LIMITED</td>
                                        <td class="numeric">$0.77</td>
                                        <td class="numeric">  +0.02</td>
                                        <td class="numeric">2.00%</td>
                                        <td class="numeric">$0.76</td>
                                        <td class="numeric">$0.77</td>
                                        <td class="numeric">$0.76</td>
                                        <td class="numeric">54,567</td>
                                    </tr>
                                    <tr>
                                        <td>ACR</td>
                                        <td>ACRUX LIMITED</td>
                                        <td class="numeric">$3.71</td>
                                        <td class="numeric">  +0.01</td>
                                        <td class="numeric">0.14%</td>
                                        <td class="numeric">$3.70</td>
                                        <td class="numeric">$3.72</td>
                                        <td class="numeric">$3.68</td>
                                        <td class="numeric">191,373</td>
                                    </tr>
                                    <tr>
                                        <td>ADU</td>
                                        <td>ADAMUS RESOURCES LIMITED</td>
                                        <td class="numeric">$0.72</td>
                                        <td class="numeric">0.00</td>
                                        <td class="numeric">0.00%</td>
                                        <td class="numeric">$0.73</td>
                                        <td class="numeric">$0.74</td>
                                        <td class="numeric">$0.72</td>
                                        <td class="numeric">8,602,291</td>
                                    </tr>
                                    <tr>
                                        <td>AGG</td>
                                        <td>ANGLOGOLD ASHANTI LIMITED</td>
                                        <td class="numeric">$7.81</td>
                                        <td class="numeric">-0.22</td>
                                        <td class="numeric">-2.74%</td>
                                        <td class="numeric">$7.82</td>
                                        <td class="numeric">$7.82</td>
                                        <td class="numeric">$7.81</td>
                                        <td class="numeric">148</td>
                                    </tr>
                                    <tr>
                                        <td>AGK</td>
                                        <td>AGL ENERGY LIMITED</td>
                                        <td class="numeric">$13.82</td>
                                        <td class="numeric">  +0.02</td>
                                        <td class="numeric">0.14%</td>
                                        <td class="numeric">$13.83</td>
                                        <td class="numeric">$13.83</td>
                                        <td class="numeric">$13.67</td>
                                        <td class="numeric">846,403</td>
                                    </tr>
                                    <tr>
                                        <td>AGO</td>
                                        <td>ATLAS IRON LIMITED</td>
                                        <td class="numeric">$3.17</td>
                                        <td class="numeric">-0.02</td>
                                        <td class="numeric">-0.47%</td>
                                        <td class="numeric">$3.11</td>
                                        <td class="numeric">$3.22</td>
                                        <td class="numeric">$3.10</td>
                                        <td class="numeric">5,416,303</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </section>
                            <div style="float:right">
                                <span class="pull-left"><b>Total DrAmount : </b></span>
                                <span class="pull-left" style="padding-right:52px;"><?php echo $amount->DrAmount; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="pull-left"><b>Total CrAmount : </b></span>
                                <span class="pull-right" style="padding-right:52px;"><?php echo $amount->CrAmount; ?></span>
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