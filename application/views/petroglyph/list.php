<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?php if (isset($message)) echo $message; ?>
<h1><?= lang("list_of_petroglyphs") ?></h1>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<a href="petroglyph/viewtable/"><i title="Отобразить в виде таблицы" class="fa fa-table" aria-hidden="true"></i></a>
<a href="petroglyph/viewpictu/"><i title="Отобразить в виде галереи" class="fa fa-th" aria-hidden="true"></i></a>
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
    <div<?= ($petroglyph->is_public ? null : ' class="unpublished"') ?>>
        #<?= $i++ ?>.
        <a href="petroglyph/<?= $petroglyph->id ?>"><?= $petroglyph->name ?></a>
        <?php if ($admin): ?>
            (<a href="petroglyph/admin/<?= $petroglyph->id ?>"><?= lang("edit"); ?></a>)
            (<a href="petroglyph/delete/<?= $petroglyph->id ?>"><?= lang("delete"); ?></a>)
        <?php endif ?>
    </div>
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