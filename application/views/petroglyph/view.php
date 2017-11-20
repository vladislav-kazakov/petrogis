<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?if (isset($message)) echo $message;?>
<div class="col-md-12">
    <h1><?=$petroglyph->name?></h1>
</div>
<div class="col-md-6 bottom-20">
    <?if (isset($img_src)):?>
        <a data-fancybox="gallery" href="imagexl/<?=$petroglyph->id?>"><img
                class="img-responsive img-thumbnail" src="image/<?=$petroglyph->id?>"></a>
    <?endif?>
    <?if ($petroglyph->description):?>
        <h3><?=lang("description");?></h3>
        <?=$petroglyph->description?>
    <?endif?>
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
</div>
<?if ($materials):?>
    <div class="col-md-12">
        <h3><?=lang("additional_materials");?></h3>
        <?foreach ($materials as $material):?>
            <div class="col-md-2 bottom-20">
                <div class="thumbnail">
                <div class="wrapper">
                        <a data-fancybox="gallery"
                           data-caption="<?=$material->name?>"
                           data-description="<?=$material->description?>"
                           href="<?=base_url() .lang("lang") . "material/imagexl/" . $material->id?>"><img
                                class="img-responsive  img-material" src="<?=base_url() .lang("lang") . "material/image/" . $material->id?>"></a><br>
                        <?if ($admin):?>
                            <a class="btn btn-default btn-xs overlay-br" href="<?=base_url() .lang("lang") .  "material/delete/" . $material->id?>"><?=lang("delete");?></a>
                        <?endif?>
                </div>
            </div>
                </div>
        <?endforeach?>
    </div>
<?endif?>
<?if ($admin):?>
<div class="col-md-12 bottom-20">
    <a class="btn btn-default" href="admin/<?=$petroglyph->id?>"><?=lang("edit");?></a>
    <a class="btn btn-default" href="delete/<?=$petroglyph->id?>"><?=lang("delete");?></a>
    <a class="btn btn-default"href="addfile/<?=$petroglyph->id?>"><?=lang("add_file");?></a>
</div>
<?endif?>
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