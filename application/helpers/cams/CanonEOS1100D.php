<?
function calculate($metadIm1){
$matrixCamX= 22.2;
$matrixCamY= 14.7;
//Focus Distance
		foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Focus Distance Upper')!==false){
			$keyDistU = $key;
			}
		 }
		$FDUpperValue = explode(": ", $metadIm1[$keyDistU]);
		//echo $FDUpperValue[1] ," ";
		
		foreach ($metadIm1 as  $key=>$val){
			if (stripos($val, 'Focus Distance Lower')!==false){
			$keyDistL = $key;
			}
		 }
		$FDLowerValue = explode(": ", $metadIm1[$keyDistL]);
		//echo $FDLowerValue[1] ," ";
		
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
		 
		 
	$FDU=explode(" ", $FDUpperValue[1]); 
	$FDL=explode(" ", $FDLowerValue[1]);
	$FD=($FDU[0]+$FDL[0])/2;
	$FL=explode(" ", $FLValue[1]);

$ImageWidth=$WidthValue[1];
$ImageHeight=$HeightValue[1];

$Opr=$ImageWidth/$ImageHeight;

if ($Opr>1.5){
	$matrixX=$matrixCamX;
}else{
	$matrixX=($matrixCamX/1.5)*$Opr;
}

		$X_kadra=($FD*100)*($matrixX*10)/($FL[0]*10);
		$X_kadra=round($X_kadra,2);


    return $arrWithX=array($X_kadra,$FD);
}
?>