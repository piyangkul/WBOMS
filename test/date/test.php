<?PHP include("INTO.php");?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>ระบบการจอง</title>
    <link href="Datepicker_files/bootstrap.css" rel="stylesheet">
    <link href="Datepicker_files/datepicker.css" rel="stylesheet">
	<style>
	.container {
		background: #fff;
	}
	#alert {
		display: none;
	}
	body {
	background-image: url();
	background-color: #99CCCC;
}
</style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script src="Datepicker_files/jquery.js"></script>
<script src="Datepicker_files/bootstrap-datepicker.js"></script>
<script>
	
                        if (top.location != location) {
    top.location.href = document.location.href ;
  }
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'dd-mm-yyyy'
			});
			$('#dp2').datepicker();
			$('#dp3').datepicker();
			$('#dp3').datepicker();
			$('#dpYears').datepicker();
			$('#dpMonths').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
	</script>    
</head>
  
      <div class="span9 columns">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
<div class="well"  align="center" >
      <div align="center"></div>
<table class="table">
        <thead>
          <tr>
            <th><div align="center">กรุณาเลือกวันที่เข้า : 
             <label for="dpd1"></label> <input name="dpd1" class="span2" id="dpd1" type="text">              
              </div></th>
            <th><div align="center">กรุณาเลือกวันที่ออก : 
              <label for="dpd2"></label><input name="dpd2" class="span2" id="dpd2" type="text">   
               <?php 
   $dpd1 = $_POST["dpd1"];
 echo"$dpd1" ?>           
              </div></th>
          </tr>
        </thead>
      </table>
   <p>
     <label>
     <div align="right">
     
       <input type="submit" name="submit" id="submit" value="Submit">
       
   
     </label>
       <div align="center"></div>
  </div>
  
        
  <p>&nbsp;</p>
          <p>&nbsp;</p>
         <?PHP include("member6.php");?>
</html>
     