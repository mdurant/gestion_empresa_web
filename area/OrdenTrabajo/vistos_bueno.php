<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestion de Vistos Buenos</title>
<link rel="stylesheet" href="../../css/bootstrap.css"/>
<script type="text/javascript" src="../../scripts/jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="form.js"></script>
</head>
<style>
.center
{
	width:33%;
	margin:0 auto;
	border:solid 1px #093;
	border-radius:1em;
}
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }

</style>
<script>
$(document).ready(function()
{
 
    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
        $("#message").html("<font color='green'>"+response.responseText+"</font>");
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#myForm").ajaxForm(options);
 
});
 

</script>

<body>
 <!-- Example row of columns -->
     <div class="row center">
        <div class="span5" style="margin-bottom:.5em;">
          <center><h3 style="color:#093">1° Aprobación</h3></center>
          <table>
          	<form name="form1" id="form1" enctype="multipart/form-data" action="">
            	<tr>
                	<td><label for="observacion"><center><strong>Observación:&nbsp;</strong></center></label></td>
                </tr>
                <tr>
                	<td><textarea cols="20" style="width:400px; resize:none;" rows="5"  id="observacion" name="observacion"></textarea></td>
                </tr>
            </form>
          </table>
          <table>
          	<form id="myForm" action="upload.php" method="post" enctype="multipart/form-data">
                 <tr>
                   <td><br/><input type="file" style="width:400px; cursor:pointer;" name="myfile"></td>
                 </tr>
                 <tr>
                   <td><br/><center><input type="submit" class="btn btn-success" value="Ajax File Upload"></center></td>
                 </tr>
            </form>
                 <tr>
                     <div id="progress">
                            <div id="bar"></div>
                            <div id="percent">0%</div >
                    </div>
                    <div id="message"></div>
                 </tr>
           </table>
        </div>
      </div>
</body>
</html>