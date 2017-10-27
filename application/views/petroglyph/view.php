<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?if (isset($message)) echo $message;?>
<div class="col-md-12">
    <h1><?=$petroglyph->name?></h1>
</div>
<div class="col-md-6 bottom-20">
    <?if (isset($img_src)):?>
        <a data-fancybox="gallery" href="<?=base_url() ."petroglyph/imagexl/" . $petroglyph->id?>"><img
                class="img-responsive img-thumbnail" src="<?=base_url() ."petroglyph/image/" . $petroglyph->id?>"></a>
    <?endif?>
    <?if ($petroglyph->description):?>
        <h3>Описание</h3>
        <?=$petroglyph->description?>
    <?endif?>
</div>
<div class="col-md-6">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Эпоха</h3>
            </div>
            <ul class="list-group">
                <?=in_array('neolithic', $petroglyph->epoch)?'<li class="list-group-item">неолит</li>':''?>
                <?=in_array('p_neolithic', $petroglyph->epoch)?'<li class="list-group-item">неолит (?)</li>':''?>
                <?=in_array('bronze', $petroglyph->epoch)?'<li class="list-group-item">эпоха бронзы</li>':''?>
                <?=in_array('p_bronze', $petroglyph->epoch)?'<li class="list-group-item">эпоха бронзы (?)</li>':''?>
                <?=in_array('early_iron', $petroglyph->epoch)?'<li class="list-group-item">ранний железный век</li>':''?>
                <?=in_array('p_early_iron', $petroglyph->epoch)?'<li class="list-group-item">ранний железный век (?)</li>':''?>
                <?=in_array('middle', $petroglyph->epoch)?'<li class="list-group-item">средневековье</li>':''?>
                <?=in_array('p_middle', $petroglyph->epoch)?'<li class="list-group-item">средневековье (?)</li>':''?>
                <?=in_array('modern', $petroglyph->epoch)?'<li class="list-group-item">новое время</li>':''?>
                <?=in_array('p_modern', $petroglyph->epoch)?'<li class="list-group-item">новое время (?)</li>':''?>
                <?=in_array('contemporary', $petroglyph->epoch)?'<li class="list-group-item">новейшее время</li>':''?>
                <?=in_array('p_contemporary', $petroglyph->epoch)?'<li class="list-group-item">новейшее время (?)</li>':''?>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Метод</h3>
            </div>
            <ul class="list-group">
                <?=in_array('pecking', $petroglyph->method)?'<li class="list-group-item">выбивка</li>':''?>
                <?=in_array('engraving', $petroglyph->method)?'<li class="list-group-item">гравировка</li>':''?>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Координаты</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">Широта: <?=$petroglyph->lat?></li>
                <li class="list-group-item">Долгота: <?=$petroglyph->lng?></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Культура</h3>
            </div>
            <ul class="list-group">
                <?=in_array('scythian', $petroglyph->culture)?'<li class="list-group-item">скифская</li>':''?>
                <?=in_array('turk', $petroglyph->culture)?'<li class="list-group-item">тюркская</li>':''?>
            </ul>
        </div>
    </div>
</div>
<?if ($materials):?>
    <div class="col-md-12">
        <h3>Дополнительные материалы</h3>
        <?foreach ($materials as $material):?>
            <div class="col-md-2 bottom-20">
                <div class="thumbnail">
                <div class="wrapper">
                        <a data-fancybox="gallery"
                           data-caption="<?=$material->name?>"
                           data-description="<?=$material->description?>"
                           href="<?=base_url() ."material/imagexl/" . $material->id?>"><img
                                class="img-responsive  img-material" src="<?=base_url() ."material/image/" . $material->id?>"></a><br>
                    <a class="btn btn-default btn-xs overlay-br" href="../material/delete/<?=$material->id?>">Удалить</a>
                </div>
            </div>
                </div>
        <?endforeach?>
    </div>
<?endif?>
<div class="col-md-12 bottom-20">
    <a class="btn btn-default" href="admin/<?=$petroglyph->id?>">Редактировать </a>
    <a class="btn btn-default" href="delete/<?=$petroglyph->id?>">Удалить</a>
    <a class="btn btn-default"href="addfile/<?=$petroglyph->id?>">Добавить файл</a>
</div>
<script>
    $('[data-fancybox]').fancybox({
        protect: true,
        caption : function( instance, item ) {
            var caption = $(this).data('caption') || '';
            if (caption) caption = '<b>' + caption + '</b><br>';
            caption += $(this).data('description') || '';
            return caption;
//          return '(<span data-fancybox-index></span>/<span data-fancybox-count></span>)' + ( caption.length ? ' ' + caption : '' );
        }
    });
</script>