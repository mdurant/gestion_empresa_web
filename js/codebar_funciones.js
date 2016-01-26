$(function(){
			    function clearCanvas(){
        var canvas = $('#miscCanvas').get(0);
        var ctx = canvas.getContext('2d');
        ctx.lineWidth = 0;
        // ctx.lineCap = 'butt';
        ctx.fillStyle = '#ffffff';
        ctx.strokeStyle  = '#ffffff';
        ctx.clearRect (0, 0, canvas.width, canvas.height);
        ctx.strokeRect (0, 0, canvas.width, canvas.height);
      }
		$("#codebar").on("keyup",function(){
				//alert("hay mierda rechasada");
				//alert("ajsojsaojsa");
				clearCanvas();
				// $("#miscCanvas").empty();
			$("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"});  
			//$("#miscCanvas").barcode($("#valores").val(), "code93");  
		});

		$("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"});  

		function download() {
    var dt = canvas.toDataURL();
    this.href = dt;
}

var canvas = document.getElementById('miscCanvas');
document.getElementById('download').addEventListener('click', download, false);

	});