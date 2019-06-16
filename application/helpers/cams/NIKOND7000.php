<?
function calculate($metadIm1){
$matrixCamX=23.6;
$matrixCamY=15.6;

//Focus Distance
		foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Focus Distance')!==false){
			$keyDist = $key;
			}
		 }
		$FDValue = explode(": ", $metadIm1[$keyDist]);
		//var_dump($piecesValue[1]); 

		//Focal Length 
		foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Focal Length')!==false){
			$keyFLen = $key;
			}
		 }
		 $FLValue = explode(": ", $metadIm1[$keyFLen]);
		 
		 
		foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Image Width')!==false){
			$keyWidth = $key;
			}
		 }
		 $WidthValue = explode(": ", $metadIm1[$keyWidth]);
		 
		 foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Image Height')!==false){
			$keyHeight = $key;
			}
		 }
		 $HeightValue = explode(": ", $metadIm1[$keyHeight]);

$ImageWidth=$WidthValue[1];
$ImageHeight=$HeightValue[1];

$Opr=$ImageWidth/$ImageHeight;
if ($Opr>1.5){
	$matrixX=$matrixCamX;
}else{
	$matrixX=($matrixCamX/1.5)*$Opr;
}
//echo $matrixX,"<br>";


	$FL=explode(" ", $FLValue[1]);
	$FD=explode(" ", $FDValue[1]);
		
		
		$X_kadra=($FD[0]*100)*($matrixX/10)/($FL[0]/10);
		$X_kadra=round($X_kadra,2);

    //return $X_kadra;
     return $arrWithX=array($X_kadra,$FDValue[1]);

}
?>