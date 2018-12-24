<div class="bottom-20"></div>
<div id="map_canvas" style="width:800px; height:600px; float:left; margin-right: 20px;"></div>

<?php if ($admin or $reviewer): ?>
        <input type="checkbox" id="hide-unpublished"<?= (isset($_COOKIE['hide_unpublished']) and $_COOKIE['hide_unpublished'] == 1) ? ' checked' : null ?>>
        <label for="hide-unpublished">
            <?= lang("hide unpublished") ?>
        </label>
<?php endif ?>

<div>
    <a href="?map_provider=google">Google Maps</a>
    <a href="?map_provider=yandex">Yandex Maps</a>
</div>
<div id="search_container">
    <form method="post">
        <input type="text" name="name" placeholder="<?=lang("title");?>...">
        <button type="submit" name="filter" class="btn btn-default"><?=lang("filter");?></button>
    </form>
</div>

<script type="text/javascript">
    var arr = <?=$json_petroglyphs?>;
</script>

<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<?php if ($map_provider == 'google'):?>
    <script type="text/javascript" src="/assets/js/markerclusterer/src/markerclusterer.js"></script>
    <script type="text/javascript" src = "/assets/js/map.js?201812241129"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeYhPhJAnwj95GXDg5BRT7Q2dTj303dQU&callback=initMap&language=<?=lang("lang")==""?"ru":"en"?>"
            type="text/javascript"></script>
<?php else:?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=<?=lang("lang")==""?"ru_RU":"en_US"?>&mode=debug" type="text/javascript"></script>
    <script src="/assets/js/tiler-converter.js" type="text/javascript"></script>
    <script type="text/javascript" src = "/assets/js/map_yandex.js"></script>
<?php endif?>
