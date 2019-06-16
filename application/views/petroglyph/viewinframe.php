<style>
#myCanvas{
    position: absolute;
     left:0px;
     top:0px;
     border:2px solid #c3c3c3;
     z-index:0;
 }

</style>
<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<!--<script type="text/javascript" src="/assets/js/scale.js"></script>-->

<!--<div id="forIm" style="position:relative; " class="col-md-6 bottom-20">-->

		<canvas id="myCanvas" style="position: absolute; background-color: transparent; z-index: 1;"></canvas>
        <canvas id="layerScale" style="position: absolute; background-color: transparent; z-index: 100;"> </canvas>

		<script>
		var canvas = document.getElementById("myCanvas");
		var ctx = canvas.getContext("2d");
		var img = new Image();
        var das;
        img.src = "../imagexl/<?=$petroglyph->id?>";
        /*
        img.onload = function () {
            canvas.width = this.naturalWidth;
            canvas.height = this.naturalHeight;
            ctx.drawImage(this, 0, 0, this.width, this.height);
        }
*/

            img.onload = function () {
                canvas.width = this.naturalWidth;
                canvas.height = this.naturalHeight;
                das = img.height;
                was = img.width;
                ctx.drawImage(img, 0, 0, this.width, this.height);//was, das);
                var oneSM;
                var oneSMSer = was /<? echo($petroglyph->photo_x);?>;


                if (oneSMSer < 20) {
                    oneSM = oneSMSer * 10;
                    var units = "дм";
                } else if (oneSMSer < 70) {
                    oneSM = oneSMSer;
                    units = "cм";
                } else {
                    oneSM = oneSMSer / 10;
                    units = "мм"
                }



                function drawScale() {
                    var canvasScale = document.getElementById("layerScale");
                    var ctxScale= canvasScale.getContext("2d");
                    //ctxScale.canvas.width  = canvas.offsetWidth;
                    //ctxScale.canvas.height = canvas.offsetHeight;
                    ctxScale.fillStyle = "red";
                    ctxScale.fillRect(0, 20, 100, 100)
                    //
                    //     ctxScale.beginPath();
                    //     ctxScale.strokeText("0", 0, das - 30);
                    //     ctxScale.moveTo(0, das - 20);
                    //     ctxScale.lineTo(0, das - 25);
                    //     var k = 1;
                    //     for (var i = 0; i < (0 + oneSM * 5); i = (i + oneSM)) {
                    //         ctxScale.moveTo(i + oneSM, das - 20);
                    //         ctxScale.lineTo(i + oneSM, das - 25);
                    //         if ((k % 2) == 0) {
                    //             ctxScale.strokeRect(i, das - 19, oneSM, 8);
                    //         } else {
                    //             ctxScale.fillStyle = "black";
                    //             ctxScale.fillRect(i, das - 20, oneSM, 10);
                    //         }
                    //         ctxScale.strokeText(k, i + (oneSM - 2), das - 30);
                    //         k++;
                    //
                    //     }
                    //     ctxScale.stroke();
                    //     ctxScale.font = "lighter 10px Calibri";
                    //     ctxScale.strokeText(units, oneSM * 5 + 10, das - 10);
                    //
                    // }


                }

                drawScale();
            }


		//setImageSrc(img.src);

        // function draw() {
        //     var canvasScale = document.getElementById("layerScale");
        //     var ctxScale= canvasScale.getContext("2d");
        //     ctxScale.fillStyle = "red";
        //     ctxScale.fillRect(0, 20, 100, 100);
        //
        // }
        // draw();




        //drawScale();
    </script>

<!--</div>-->
