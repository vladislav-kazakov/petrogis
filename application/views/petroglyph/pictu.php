<style type="text/css">
    img {
        width: 200px;
        height: 140px;
        border: 2px #CCCCCC solid;
        border-radius: 10px;

    }
 a.toolt {
color: #000000; outline: none;
cursor: help; text-decoration: none;
position: relative;
width: 200px;
margin-left: 14px;

}
    a.toolt span {
display: none;
position: absolute;
}
    a.toolt:hover span {
position: absolute;
z-index: 99;
display: inline;
width: 200px;
}
    .tooltipIM {
    margin: -15px 0 0 -20px;
    float: left;
    height:20px;
    width:20px;
    }
    .classic {
        padding: 0.5em;
        background: #dce6f7;
        border: 1px solid #6982ad;
        border-radius: 5px;
    }
    .warning {
        padding: 0.5em;
        background: #FFFFAA;
        border: 1px solid #d3ba15;
        border-radius: 5px;
    }
    </style>
    <script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?php if (isset($message)) echo $message; ?>
<h1><?= lang("list_of_petroglyphs") ?></h1>
<!--<link rel="stylesheet" href="gallery.css" type="text/css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="../"><i title="Отобразить в виде списка" class="fa fa-th-list" aria-hidden="true"></i></a>
<a href="../viewtable/"><i title="Отобразить в виде таблицы" class="fa fa-table" aria-hidden="true"></i></a>
<?php
if ($admin or $reviewer): ?>
    <div class="clearfix">
        <input type="checkbox" id="hide-unpublished">
        <label for="hide-unpublished">
            <?= lang("hide unpublished") ?>
        </label>
    </div>
    <br>
<?php endif ?>


<?php $i = 1; ?>
<?php foreach ($petroglyphs as $petroglyph): ?>
<!--    <div--><?//= ($petroglyph->is_public ? null : ' class="unpublished"') ?><!-->
<!--        #--><?//= $i++ ?><!--.-->
    <a class="toolt" href="../<?= $petroglyph->id ?>" >
            <img dspace="10" vspace="10"  src="<?="http://petrogis/data/petroglyph/image/" . $petroglyph->image;?>" />
        <?php if (($petroglyph->level_quality)>= 0.6){?>
        <span class="classic"> <b><?= $petroglyph->name?></b><br>
            Показатель качетсва:<?= $petroglyph->level_quality?><br>
            Разрешение:<?= $petroglyph->xRes?>х<?= $petroglyph->yRes?><br>
            ISO:<?= $petroglyph->ISO?>
            Выдержка:<?= $petroglyph->exposure?>
            </span>
        <?php } elseif (($petroglyph->level_quality)< 0.6){?>
        <span class="warning">
<!--   КАК ПРОПИСАТЬ ПУТЬ         <img src="..//application/views/petroglyph/Warning.png" class="tooltipIM" alt="Предупреждение"/>-->
        <b><?= $petroglyph->name?></b><br>
        Плохое качество фотографии!<br>
        Рекомендуется заменить изображение. </span>
        <?php } else {?>
            <span class="classic"> <b><?= $petroglyph->name?></b><br>
            Разрешение:<?= $petroglyph->xRes?>х<?= $petroglyph->yRes?><br>
            ISO:<?= $petroglyph->ISO?>
            Выдержка:<?= $petroglyph->exposure?>
            </span>
        <?php }?>
    </a>
<!--        <a href="petroglyph/--><?//= $petroglyph->id ?><!--">--><?//= $petroglyph->name ?><!--</a>-->
<!--        --><?php //if ($admin): ?>
<!--            (<a href="petroglyph/admin/--><?//= $petroglyph->id ?><!--">--><?//= lang("edit"); ?><!--</a>)-->
<!--            (<a href="petroglyph/delete/--><?//= $petroglyph->id ?><!--">--><?//= lang("delete"); ?><!--</a>)-->
<!--        --><?php //endif ?>
<!--    </div>-->
<?php endforeach ?>

<?php if ($admin): ?>
    <form action="petroglyph/admin">
        <button class="btn btn-default"><?= lang("add_petroglyph"); ?></button>
    </form>
<?php endif ?>



<?php if ($admin or $reviewer): ?>
    <script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
    <script>
        $(document).ready(function () {
            if ($.cookie("hide_unpublished") != undefined && $.cookie("hide_unpublished") == 1) {
                $('#hide-unpublished').attr('checked', 'checked');
                hide_unpublished();
            }

            $('#hide-unpublished').click(function () {
                let is_hide = $.cookie("hide_unpublished") ? $.cookie("hide_unpublished") : 0;
                is_hide = is_hide == 1 ? 0 : 1;
                document.cookie = "hide_unpublished=" + is_hide + ";path=/";
                hide_unpublished();
            });

            function hide_unpublished() {
                $('.unpublished').toggle();
            }
        });
    </script>
<?php endif ?>