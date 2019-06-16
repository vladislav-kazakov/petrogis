<style>
    table {
        overflow:hidden;
        border:1px solid #14142d;
        width:80%;
        margin:1% auto 0;
        border-radius:5px;
    }

    th, td {
        padding:15px 20px 15px;
        text-align:center;
    }
    th {
        padding-top:20px;
        text-shadow: 1px 1px 1px #fff;
        background:#e8eaeb;
    }

    td {
        border-top:1px solid #e0e0e0;
        border-right:1px solid #e0e0e0;
    }

    select{
        margin-left: 20px;
        padding: 10px;
        background:#e8eaeb;
        font-weight:bold;
        border-radius: 6px;
    }
    select:hover{
background:white;
transition: all 0.3s ease-in-out;
}

</style>

<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?php if (isset($message)) echo $message; ?>
<h1><?= lang("list_of_petroglyphs") ?></h1>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="http://petrogis/petroglyph/"><i title="Отобразить в виде списка" class="fa fa-th-list" aria-hidden="true"></i></a>
<a href="../viewpictu/"><i title="Отобразить в виде галереи" class="fa fa-th" aria-hidden="true"></i></a>
<!--<link rel="stylesheet" href="../assets/css/table.css" >-->
<?php
//if ($admin or $reviewer): ?>
<!--    <div class="clearfix">-->
<!--        <input type="checkbox" id="hide-unpublished">-->
<!--        <label for="hide-unpublished">-->
<!--            --><?//= lang("hide unpublished") ?>
<!--        </label>-->
<!--    </div>-->
<!--    <br>-->
<?php //endif ?>
<form method="get">
<select size="1" name="choosesort" value="Сортируем по ..">
    <option value='id'>По времени добавления</option>
    <option value='ISO'>По значению ISO </option>
    <option value='exposure'>По значению выдержки</option>
    <option value='level_quality'>По качеству</option>
</select>
    <button type="submit" name="ASC" value="ASC"> <img width="30px" height="30px" src="<?=base_url()?>assets/img/up.png" > </button>
    <button type="submit" name="DESC" value="DESC"> <img width="30px" height="30px" src="<?=base_url()?>assets/img/down.png" > </button>
</form>
<?
?>
<table style=" border:1px solid #14142d;">
    <tr>
        <th>Название</th>
        <th>Модель камеры</th>
        <th>Яркость</th>
        <th>Резкость</th>
        <th>Контрастность</th>
        <th>ISO</th>
        <th>Диафрагма</th>
        <th>Выдержка</th>
        <th>Миниатюра</th>
        <th>Замечание</th>
    </tr>

    <?php  $i = 1;
    foreach ($petroglyphs as $petroglyph): ?>
    <div<?= ($petroglyph->is_public ? null : ' class="unpublished"') ?>
        <tr>
    <td><a href="http://petrogis/petroglyph/<?= $petroglyph->id ?>"><?= $petroglyph->name ?></a></td>
    <td><p> <?= $petroglyph->NameModel ?></p></td>
    <td><p><?= $petroglyph->sharp ?></p></td>
    <td><p><?= $petroglyph->brightn ?></p></td>
    <td><p><?= $petroglyph->contr ?></p></td>
    <td><p> <? echo $petroglyph->ISO;?></p></td>
    <td><p> <?= $petroglyph->Diaphragma ?></p></td>
    <td><p> <?= $petroglyph->exposure?></p></td>
    <td><a href="http://petrogis/petroglyph/<?= $petroglyph->id ?>">
        <img width="100px" src="<?="http://petrogis/data/petroglyph/image/".$petroglyph->image;?>"/> </a> </td>
        <td><p><? if(($petroglyph->level_quality)>0.6){echo "Фотография хорошего качества";
        } elseif(($petroglyph->level_quality)==0){echo "Нет данных о качестве фотографии";
        } else {echo "Плохое качество фотографии! Рекомендуется заменить изображение.";} ?></p></td>
        </tr>
    <?php endforeach ?>
</table>
<br>


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