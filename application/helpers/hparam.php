<?
function showgen($dopParam)
{
    foreach ($dopParam as $key => $val) {
        $dopexp = explode(":", $val);
    }
   //print_r($exif);

    $xRes = $exif["Image Width"];
    $yRes = $exif["Image Height"];
    $ISO = $exif["ISO"];
    $diaphr = $exif["F Number"];
    $modelLens = $exif["Lens ID"];
    $expTime=$exif["Exposure Time"];

////Resolution
//    foreach ($dopParam as $key => $val) {
//        if (stripos($val, 'X Resolution') !== false) {
//            $xRes = $key;
//        }
//    }
//    $xResult = explode(": ", $dopParam[$xRes]);
//    $xRes=$xResult[1];
//
//
//    foreach ($dopParam as $key => $val) {
//        if (stripos($val, 'Y Resolution') !== false) {
//            $yRes = $key;
//        }
//    }
//    $yResult = explode(": ", $dopParam[$yRes]);
//    $yRes=$yResult[1];
//
//
//    foreach ($dopParam as $key => $val) {
//        if (stristr($val, 'ISO  ') !== false) {
//            $ISO = $key;
//        }
//    }
//    $ISOResult = explode(": ", $dopParam[$ISO]);
//    $ISO=$ISOResult[1];
//
//    foreach ($dopParam as $key => $val) {
//        if (stripos($val, 'F Number') !== false) {
//            $diaphr = $key;
//        }
//    }
//    $diaphrResult = explode(": ", $dopParam[$diaphr]);
//    $diaphr=$diaphrResult[1];
//
//    foreach ($dopParam as $key => $val) {
//        if (stristr($val, 'Lens ID ') !== false) {
//            $modelLens = $key;
//        }
//    }
//    $modelLensResult = explode(": ", $dopParam[$modelLens]);
//    $modelLens=$modelLensResult[1];
//
//
//    foreach ($dopParam as $key => $val) {
//        if (stripos($val, 'Exposure Time ') !== false) {
//            $expTime = $key;
//        }
//    }
//    $expTimeResult = explode(": ", $dopParam[$expTime]);
//    $expTime=$expTimeResult[1];
//
//    $exif=array();
//        foreach ($dopParam as $key => $val) {
//            $dopexp = explode(":", $val);
//            $exif[trim($dopexp[0])] = trim($dopexp[1]);
//        }




    $arr=array($ISO, $diaphr, $modelLens, $xRes, $yRes,$expTime);

    return $arr;
}
    ?>