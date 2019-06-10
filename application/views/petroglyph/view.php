<style>
#myCanvas{
    position: absolute;
     left:0px;
     top:0px;
     border:2px solid #c3c3c3;
     z-index:0;
 }
p{
    color: red;

}
img.petroglyph_view{
    max-width: 600px;
    max-height: 600px;
    width:100%;
}

.sid span {
    visibility: hidden;
    opacity: 0;
    width: 250px;
    background: #f2f2f2;
    position: absolute;
    margin-left: 70px;
    margin-top: -40px;
    background: #f2f2f2;
    padding: 0.5em;
    border: 1px solid #6982ad;
    border-radius: 8px 8px 8px 0px;
    transition: all 0.5s ease-in-out;
}
.sid:hover span{
    visibility: visible;
    opacity: 1;
}


</style>
<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<!--<script type="text/javascript" src="/assets/js/scale.js"></script>-->

<?php if (isset($message)) echo $message;?>
<div class="col-md-12">
    <h1><?=$petroglyph->name?></h1>
</div>
<?  //print_r($petroglyph->photo_x);
if ($logged_in&& $petroglyph->level_quality < 0.6){
echo "<p><b>Обратите внимание на плохое разрешение фото. Рекомендуется заменить изображение. <br>  Показатель качетсва: ",$petroglyph->level_quality ,"</b></p>";}
?>
<div id="forIm" style="position:relative; height: 600;" class="col-md-6 bottom-20">
    <?php if (isset($img_src)):?>

        <?php if ($petroglyph->NameModel == "ТЕЛЕФОН") {
           ?>
<!--       <a data-fancybox="gallery" href="imagexl/--><?//=$petroglyph->id?><!--">-->
        <img class="img-responsive img-thumbnail" src="image/<?=$petroglyph->id?>">


        <?php } else { ?>
<!--    <a data-fancybox data-type="iframe" data-fancybox="gallery" href="imagesc/--><?//=$petroglyph->id?><!--">-->
<!--    <a href="petroglyph/viewinframe".$petroglyph_id></a>-->

<!--        <a data-fancybox="gallery" href="imagexl/--><?//=$petroglyph->id?><!--">-->
		<canvas id="myCanvas" style="position: absolute; background-color: transparent; z-index: 1;"></canvas>
        <canvas id="layerScale" style="position: absolute; background-color: transparent; z-index: 2;"> </canvas>
        <canvas id="layerScale2" style="position: absolute; background-color: transparent; z-index: 2;"> <span></span></canvas>

        </a>
		<script>
		var canvas = document.getElementById("myCanvas");
		var ctx = canvas.getContext("2d");

		var sizeDiv= document.getElementById("forIm");
		//ctx.canvas.height = sizeDiv.offsetHeight;
		ctx.canvas.width  = sizeDiv.offsetWidth;
		ctx.canvas.height = 530;
		var img = new Image();

        var das;

        img.src = "image/<?=$petroglyph->id?>";

            img.onload = function () {
                das = img.height;
                was = img.width;
                ctx.drawImage(img, 0, 0, was, das);
                var oneSM;
                oneSMSer = was /<? echo($petroglyph->photo_x);?>;

                if (oneSMSer < 20) {
                    oneSM = oneSMSer * 10;
                    var units = "дм";
                }//дм
                else if (oneSMSer < 70) {
                    oneSM = oneSMSer;
                    units = "cм";
                }//см
                else {
                    oneSM = oneSMSer / 10;
                    units = "мм"
                }//мм

                function drawScale() {
                    ctxScale.fillStyle = "white";
                    ctxScale.fillRect(0, das - 20, oneSM * 5, 10)

                    ctxScale.beginPath();
                    ctxScale.strokeText("0", 0, das - 30);
                    ctxScale.moveTo(0, das - 20);
                    ctxScale.lineTo(0, das - 25);
                    var k = 1;
                    for (var i = 0; i < (0 + oneSM * 5); i = (i + oneSM)) {
                        ctxScale.moveTo(i + oneSM, das - 20);
                        ctxScale.lineTo(i + oneSM, das - 25);
                        if ((k % 2) == 0) {
                            ctxScale.strokeRect(i, das - 19, oneSM, 8);
                        } else {
                            ctxScale.fillStyle = "black";
                            ctxScale.fillRect(i, das - 20, oneSM, 10);
                        }
                        ctxScale.strokeText(k, i + (oneSM - 2), das - 30);
                        k++;

                    }
                    ctxScale.stroke();
                    ctxScale.font = "lighter 10px Calibri";
                    ctxScale.strokeText(units, oneSM * 5 + 10, das - 10);

                }

                drawScale();
            };

        var canvasScale = document.getElementById("layerScale");
        var ctxScale= canvasScale.getContext("2d");
        ctxScale.canvas.width  = canvas.offsetWidth;
        ctxScale.canvas.height = canvas.offsetHeight;

        var canvasScale2 = document.getElementById("layerScale2");
        var ctxScale2= canvasScale2.getContext("2d");
        ctxScale2.canvas.width  = canvas.offsetWidth;
        ctxScale2.canvas.height = canvas.offsetHeight;

        ctxScale2.lineWidth = 5;
        canvasScale2.onmousedown= function () {
            ctxScale2.clearRect(0, 0, canvas.width, canvas.height);
            x1=event.offsetX;
            y1=event.offsetY;
            ctxScale2.beginPath();
            ctxScale2.moveTo(x1, y1); //рисуем линию

        }
        canvasScale2.onmouseup= function () {
            x=event.offsetX;
            y=event.offsetY;
            ctxScale2.lineTo(x, y); //рисуем линию
            ctxScale2.stroke();
            d1=(x1-x);
            d2=(y1-y);

            h= Math.sqrt((d1*d1)+(d2*d2));
            h2=(h/oneSMSer).toFixed(2);
            document.getElementById("mlin").value= h2+" см";
            ctxScale.fillStyle = "white";
            ctxScale.fillRect(x+5, y-20, 40, 15)
            ctxScale.strokeText(h2+" см", x+10, y-10);
        };

    </script>
       <?php } ?>

    <?php endif?>
    <?php if ($petroglyph->description):?>
        <h3><?=lang("description");?></h3>
        <?=$petroglyph->description?>
    <?php endif?>
</div>
<div class="col-md-6">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=lang("epoch");?></h3>
            </div>
            <ul class="list-group">
                <?=in_array('neolithic', $petroglyph->epoch)?'<li class="list-group-item">' . lang("neolithic") . '</li>':''?>
                <?=in_array('p_neolithic', $petroglyph->epoch)?'<li class="list-group-item">' . lang("neolithic") . ' (?)</li>':''?>
                <?=in_array('bronze', $petroglyph->epoch)?'<li class="list-group-item">' . lang("bronze_epoch") . '</li>':''?>
                <?=in_array('p_bronze', $petroglyph->epoch)?'<li class="list-group-item">' . lang("bronze_epoch") . ' (?)</li>':''?>
                <?=in_array('early_iron', $petroglyph->epoch)?'<li class="list-group-item">' . lang("early_iron_age") . '</li>':''?>
                <?=in_array('p_early_iron', $petroglyph->epoch)?'<li class="list-group-item">' . lang("early_iron_age") . ' (?)</li>':''?>
                <?=in_array('middle', $petroglyph->epoch)?'<li class="list-group-item">' . lang("middle_age") . '</li>':''?>
                <?=in_array('p_middle', $petroglyph->epoch)?'<li class="list-group-item">' . lang("middle_age") . ' (?)</li>':''?>
                <?=in_array('modern', $petroglyph->epoch)?'<li class="list-group-item">' . lang("modern_period") . '</li>':''?>
                <?=in_array('p_modern', $petroglyph->epoch)?'<li class="list-group-item">' . lang("modern_period") . ' (?)</li>':''?>
                <?=in_array('contemporary', $petroglyph->epoch)?'<li class="list-group-item">' . lang("contemporary_period") . '</li>':''?>
                <?=in_array('p_contemporary', $petroglyph->epoch)?'<li class="list-group-item">' . lang("contemporary_period") . ' (?)</li>':''?>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=lang("method");?></h3>
            </div>
            <ul class="list-group">
                <?=in_array('pecking', $petroglyph->method)?'<li class="list-group-item">' . lang("pecking") . '</li>':''?>
                <?=in_array('engraving', $petroglyph->method)?'<li class="list-group-item">' . lang("engraving") . '</li>':''?>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php if ($logged_in): ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=lang("coordinates");?></h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item"><?=lang("latitude");?>: <?=$petroglyph->lat?></li>
                <li class="list-group-item"><?=lang("longitude");?>: <?=$petroglyph->lng?></li>
            </ul>
        </div>
    </div>
<?php endif; ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?=lang("culture");?></h3>
            </div>
            <ul class="list-group">
                <?=in_array('scythian', $petroglyph->culture)?'<li class="list-group-item">' . lang("scythian") . '</li>':''?>
                <?=in_array('turk', $petroglyph->culture)?'<li class="list-group-item">' . lang("turkic") . '</li>':''?>
            </ul>
        </div>
    </div>
    <? if(($petroglyph->photo_x)<10){
        $phplane="Макросъемка";
    } elseif(($petroglyph->photo_x)<100){
        $phplane="Фото";
    } elseif(($petroglyph->photo_x)< 100*10){
        $phplane="Общий план";
    } else {$phplane="Пейзаж";} ?>

        <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">План фотографии</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item"><?echo $phplane;?></li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Сведения о качестве</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">Резкость: <?if($petroglyph->sharp) {echo $petroglyph->sharp;} else{ echo "Нет данных";}?></li>
                <li class="list-group-item">Яркость:  <?if($petroglyph->brightn) {echo $petroglyph->brightn;} else{ echo "Нет данных";}?></li>
                <li class="list-group-item">Контраст: <?if($petroglyph->contr) {echo $petroglyph->contr;} else{ echo "Нет данных";}?></li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Дополнительные сведения</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item"> ISO: <?if($petroglyph->ISO) {echo $petroglyph->ISO;} else{ echo "Нет данных";}?></li>
                <li class="list-group-item"> Диафрагма: <?if($petroglyph->Diaphragma) {echo $petroglyph->Diaphragma;} else{ echo "Нет данных";}?></li>
                <li class="list-group-item"> Модель объектива: <?if($petroglyph->ModelLens) {echo $petroglyph->ModelLens;} else{ echo "Нет данных";}?></li>
                <li class="list-group-item"> Фокусное расстояние: <?if($petroglyph->FocusDistance) {echo $petroglyph->FocusDistance;} else{ echo "Нет данных";}?></li>
            </ul>
        </div>
    </div>

    <?php if ($petroglyph->NameModel != "ТЕЛЕФОН") {?>
    <div class="sid">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span >Проведите линию на изображении, чтобы узнать длину элемента</span>
                <h3 class="panel-title">Линейка</h3>
            </div>
            <input type="text" size="35" id="mlin">
        </div>
    </div>
</div>
<?php } ?>



</div>
<?php if ($materials):?>
    <div class="col-md-12">
        <h3><?=lang("additional_materials");?></h3>
        <?php foreach ($materials as $material):?>
            <div class="col-md-2 bottom-20">
                <div class="thumbnail">
                <div class="wrapper">
                        <a data-fancybox="gallery"
                           data-caption="<?=$material->name?>"
                           data-description="<?=$material->description?>"
                           href="<?=base_url() .lang("lang") . "material/imagexl/" . $material->id?>"><img
                                class="img-responsive  img-material" src="<?=base_url() .lang("lang") . "material/image/" . $material->id?>"></a><br>
                        <?php if ($admin):?>
                            <a class="btn btn-default btn-xs overlay-bl" href="<?=base_url() .lang("lang") .  "material/tomain/" . $material->id?>"><?=lang("to main");?></a>
                            <a class="btn btn-default btn-xs overlay-br" href="<?=base_url() .lang("lang") .  "material/delete/" . $material->id?>"><?=lang("delete");?></a>
                        <?php endif?>
                </div>
            </div>
                </div>
        <?php endforeach?>
    </div>
<?php endif?>
<?php if ($admin):?>
<div class="col-md-12 bottom-20">
    <a class="btn btn-default" href="admin/<?=$petroglyph->id?>"><?=lang("edit");?></a>
    <a class="btn btn-default" href="delete/<?=$petroglyph->id?>"><?=lang("delete");?></a>
    <a class="btn btn-default"href="addfile/<?=$petroglyph->id?>"><?=lang("add_file");?></a>
</div>
<?php endif?>
<script>
    // $('[data-fancybox]').fancybox({
    //     toolbar  : false,
    //     smallBtn : true,
    //     iframe : {
    //         preload : false,
    //         css : {
    //             width : 1000,
    //             height : 1000
    //         }
    //     }
    // })
    // })
 function funcalert(){
     alert(1);
 }

    $('[data-fancybox]').fancybox({
        protect: true,
        afterShow: function( instance, slide ) {
            slide.$image[0].addEventListener("resize", funcalert),
            alert(slide.$image[0].width);
        },
        caption : function( instance, item ) {
            var caption = $(this).data('caption') || '';
            if (caption) caption = '<b>' + caption + '</b><br>';
            caption += $(this).data('description') || '';
            return caption;
          return '(<span data-fancybox-index></span>/<span data-fancybox-count></span>)' + ( caption.length ? ' ' + caption : '' );
        }
    });
</script>