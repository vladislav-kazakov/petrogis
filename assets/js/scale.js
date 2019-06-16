
function setImageSrc(srcIm){
	
var img = new Image(); 
img.src = srcIm; 

ctx.drawImage(img, 10, 10); 
}

function drawScale(){
	ctxScale.beginPath();
	ctxScale.strokeText("0", 20, 440);
	ctxScale.moveTo(20,450); ctxScale.lineTo(20,445);

var k=1;
for(var i=20;i<(20+50*5); i=(i+50)){
	ctxScale.moveTo(i+50,450); ctxScale.lineTo(i+50,445);
if( ((i*0.1)% 2)==0 ){
	ctxScale.strokeRect(i,451,50,8);
	}else{ctxScale.fillRect(i,450,50,10);
	}
	ctxScale.strokeText(k, i+48, 440);
k++;

}

	ctxScale.stroke();
	ctxScale.font = "lighter 10px Calibri";
	ctxScale.strokeText("см", 280, 460);
}
