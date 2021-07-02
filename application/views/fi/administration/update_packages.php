<!DOCTYPE html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ERP System | Administration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>dist/css/skins/skin-blue.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>dist/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/');?>dist/css/styles_new.css"> 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition skin-blue sidebar-mini administration_package">
    <!-- <div class="wrapper"> -->
      <!-- <?php  ?> -->
      <!-- Left side column. contains the logo and sidebar -->
      <!-- <?php  ?> -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <section class="content-header">
      <h1>Event Management </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li class="active">Packages</li>
      </ol>
    </section>

    <?php if(isset($success)){?>
    <div class="alert alert-success alert-dismissable fade in">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <strong></strong> <?=$success?>
    </div>
    <?php }?>
    <?php if(isset($error)){?>
    <div class="alert alert-danger alert-dismissable fade in">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <strong>Error!</strong> <?=$error?>
    </div>
    <?php }?>
        <section class="content">
          <!-- TABLE: LATEST ORDERS -->
          <form action="<?=site_url('fi_home/update_packages/'.$id)?>" method="POST" id="iform" name="iform">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header with-border">
                  <div class="row">
                    <div class="col-sm-5 col-md-4">
                      <h3 class="uhead2">
                        Packages
                      </h3>
                    </div>
                    <div class="col-sm-7 col-md-8">
                      <div class="pull-right">
                        <ul class="list-inline topul">
                          <li><a href="#" class="uhead2"> Main Menu </a></li>
                          <li><a href="#" class="uhead2"> Options </a></li>
                          <li><button class="btn btn-default" onclick="print();" > <i class="fa fa-print"></i></button> </li>
                        </ul>
                        <!-- <a href="#" class="btn btn-md btn-info btn-flat">New Customer</a> -->
                      </div>
                    </div>
                  </div>
                </div><div class="box-body">
                  <div class="table-responsive">
                    <table class="table   table-hover no-margin">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th style="width:20%">Price</th>
                          <th>Taxable</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php 
                        foreach($package as $row)
                        { 
                            if($row['package_taxable'] == 1)
                            {
                                $checked = "checked";
                            }
                            else
                            {
                                $checked = "";
                            } ?>
                        <tr>
                            <td>1</td>
                            <td><input value="<?=$row['package_name']?>" type="text" class="form-control" name="package_name" id="id" onchange="fngetitemtot()" required /></td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                                        <input  type="number" value="<?=$row['package_price']?>" class="form-control" name="package_price" id="pcktotprice" required />
                                    </div>
                                </div>
                            </td>
                            <td><input <?=$checked?> type="checkbox" name="package_taxable" id="id"/></td>
                            <td><input value="<?=$row['package_desc']?>" type="text" name="package_desc" id="package_desc" style="width: 100%;"/></td>
                        </tr>

                        <?php
                        }
                      ?> 
                        
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
              </div>
            </div>
               <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <p class="uhead2">Items</p>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover no-margin">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="newcalc">
                                <?php
                                    foreach($package_item as $row)
                                    { 
                                    //SELECT `id`, `package_id`, `item_name`, `item_quantity`, `item_price`, `item_desc`, `item_created_at`, `user` FROM `admin_package_item` WHERE 1
                                ?>
                                    <tr class="tr_clone">
                                        <td>1</td>
                                        <td>
                                            <!-- <input type="text" class="form-control" name="i_name[]" id="item_name" required> -->
                                            <select class="form-control fcap" name="title[]" id="title1" onchange="fnadmpckinfo(this.value,'1')">
                                            
                                            <?php
                                            foreach ($all_items as $item) 
                                            {
                                                if($row['item_name'] == $item['item_name'])
                                                { ?>
                                                    <option selected value="<?=$item['item_id']?>"><?=$item['item_name']?></option>        
                                                <?php 
                                                } ?>
                                            <option value="<?= $item['item_id']  ?>"><?=$item['item_name']?></option>
                                            <?php }
                                            ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input value="<?=$row['item_quantity']?>" type="number" class="form-control quants" min="1" name="quant[]" id="item_quant1" required value="1" style="width: 50px;" >
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                                                    <input  value="<?=$row['item_price']?>"  type="number" class="form-control iprice" min="1" name="i_price[]" id="item_price1" required style="width: 80px;">
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"></span>
                                                    <input value="<?=$row['item_desc']?>" type="text" class="form-control"  name="itmdesc[]" id="itmdesc1" required>
                                                </div>
                                            </div>
                                        </td>
                                    
                                        <td>
                                        <?php
                                        if($item_count == 0)
                                        { ?>
                                        <span class="btn btn-xs btn-primary tr_clone_add <?=$item_count?>" title="Add row"> <i class="fa fa-plus"></i> </span>
                                        
                                            <?php
                                        }
                                        else
                                        { 
                                            $item_count = $item_count - 1;
                                            ?>
                                        <button class="btn btn-xs btn-danger tr_clone_remove" title="Add row"><i class="fa fa-minus"></i></button>
                                            <?php
                                        }
                                            
                                            ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btns text-center">
                            <button type="submit" class="btn btn-lg btn-info btn-flat">Update</button>
                            <button type="reset" class="btn btn-lg btn-default btn-flat">Cancel</button>
                                    </div>
                        </div>
                    </div>


            <!-- /.col -->

          </div>
        </form>


        </section>

        <!-- /.content -->

      </div>


<script type="text/javascript">
    function fnadmpckinfo(admpckId,txtinpid)
    {
        $.ajax({
            type: "POST",
            url: "<?=site_url('fi_home/fngetadmpckjson')?>",
            data:'admpckId='+admpckId,
            dataType: "json",
            success: function(data)
            {
                var myobj=data.admpackageitem;
                $("#item_price"+txtinpid).val(myobj.item_price);
                $("#itmdesc"+txtinpid).val(myobj.item_desc);
                fngetitemtot();
            }
        });
    }

    function fngetitemtot()
    {
        var res =0;
        $(".iprice").each(function()
        {
            res += Number(this.value);
        });

        //$('#pcktotprice').val(res);
    }

</script>


  <script>
    $(document).on("keyup", ".quants", function(){
        //alert("111");
        var res =0;
          $(".iprice").each(function(){
             res += Number(this.value);
         });

        //alert(res);

        $('#pcktotprice').val(res);
    });
  </script>


 <!--  <script type="text/javascript">
  	function fncaltotal(txtipval,txtipid)
  	{

  		var totamount=txtipval*

  		$('$item_price'+txtipid).val();
  	}
  </script> -->


      <!-- /.content-wrapper -->

      <!-- Main Footer -->

      <!-- <?php  ?>

    </div> -->

    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->

      <script src="<?php echo base_url('assets/');?>bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->

  <!--<script src="<?php echo base_url('assets/');?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->

  <script src="<?php echo base_url('assets/');?>js/jquery.validate.js"></script>
   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

  <!-- AdminLTE App -->

 <!-- <script src="dist/js/adminlte.min.js"></script>-->

 <script type="text/javascript">
  //ERP tr added
  	var cnt = 2
    $(document).on('click', '.tr_clone_add', function(rrr) {
     rrr.preventDefault();
    var aaa = $("#title1").html();

	$(this).parents("tbody").append('<tr class="tr_clone"> <td>'+cnt+'</td><td><select class="form-control fcap" name="title[]" id="title'+cnt+'" onchange="fnadmpckinfo(this.value,'+cnt+')">'+aaa+'</td><td><input type="number" class="form-control quants" min="1" id="item_quant'+cnt+'" value="1" name="quant[]" style="width: 50px;"></td> <td> <div class="form-group"> <div class="input-group">  <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span> <input type="number" min="0" class="form-control iprice" name="i_price[]" id="item_price'+cnt+'"></div></div></td> <td><div class="form-group"><div class="input-group"><input type="text" class="form-control" style="width:150px;" name="itmdesc[]" id="itmdesc'+cnt+'" required></div></div></td> <td> <button class="btn btn-xs btn-primary tr_clone_add" title="Add row"><i class="fa fa-plus"></i></button></td> </tr>');
	$(this).removeClass('btn-primary tr_clone_add').addClass('btn-danger tr_clone_remove').html('<i class="fa fa-minus"></i>');

	cnt++;
});





  $(document).on('click', '.tr_clone_remove', function(){
       // Your Code
      var $tr    = $(this).closest('.tr_clone');

  	$(this).closest('table').addClass("currenttable");
  	var alltr = $(this).parents("table.currenttable").find('tr');
  	var len = alltr.length - 1;

  	//$(alltr).each(function(){ $(this).find("td:first-child").text(i)});
  	//alert(len);
      var $clone = $tr.remove();
  	if(cnt>0)
  	{
  	cnt--;
  	}
  });
  </script>




  <script>

  $(document).ready(function(){

    var item_price;
  $(".newcalc").on("click",".iname", function(){
    // alert(123);
   var i_name = $(this).val();

   $.ajax({
       type: "POST",
       url: "<?php echo base_url('Fi_home/single_price_info'); ?>",
       data: {i_name : i_name},
       success: function(data)
       {
           var items = data;
           // console.log(items);
           var temp1 = new Array();
           temp1 = items.split("##");
           // alert(temp1[1]);

             document.getElementById("i_price").value = temp1[3];
            //document.getElementById("loc_phone1").innerHTML = temp1[3];
            item_price = temp1[3];

            // alert(item_price);


       }
     });

  });

    $(".quants").on("keyup change", function(){
      var q = $(this).val();
      //alert(q);
      var product = Number(item_price) * Number(q);
      var prod = product.toFixed(2);
      // alert(prod);
      document.getElementById('i_price').value = prod;

    });
  });
  </script>
  <script>

  $(document).ready(function($) {

     $("#iform").validate({
             rules: {

                     // title:{required: true},
                     // cus_fname:{required: true},
                     item_name:{required: true},
                     item_quant:{required: true},
                     i_price:{required: true}

                     // acquiredBy:{required: true}
         },
         highlight: function (element) {
             $(element).closest('.frm_testimonials').removeClass('success').addClass('error');
         },

         messages: {
                     // title:{required: "Please Select Title"},
                     item_name:{required: "Please enter Item Name"},
                     item_quant:{required: "Please enter Quantity"},
                     item_price:{required: "Please enter price"}
                     // cus_zip:{required: "Please Enter Zip Code"}


                     // acquiredBy:{required:"Please select Acquired By."}

         },

     });
  });

  </script>




 <!-- </body>

</html>-->
