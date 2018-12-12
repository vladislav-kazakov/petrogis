</div>
<div id="map_canvas" style="width:100%; height:500px;"></div>
<div class="container">
    <? if (isset($message)): ?>
        <div class="alert alert-danger" role="alert"><?= $message ?></div>
    <? endif ?>
    <div class="alert alert-info text-center" role="alert">
        Для того, чтобы выбрать и добавить петроглиф в левую или правую часть, необходимо кликнуть левой или правой кнопкой мыши соответственно по маркеру на карте.
    </div>

    <form enctype="multipart/form-data" method="post">

        <table class="table table-hover">

            <col width="45%">
            <col width="10%">
            <col width="45%">

            <tr data-type="id">
                <td class="left">
                    <span></span>
                </td>
                <td></td>
                <td class="right">
                    <span></span>
                </td>
            </tr>

            <tr data-type="name">
                <td class="left">
                    <input type="text" name="left[name]" class="form-control" placeholder="<?= lang("name"); ?>">
                </td>
                <td>
                    <button type="button" class="btn pull-left transfer" data-transfer="right"><span
                                class="glyphicon glyphicon-chevron-right"></span></button>
                    <button type="button" class="btn pull-right transfer" data-transfer="left"><span
                                class="glyphicon glyphicon-chevron-left"></span></button>
                </td>
                <td class="right">
                    <input type="text" name="right[name]" class="form-control" placeholder="<?= lang("name"); ?>">
                </td>
            </tr>

            <tr data-type="description">
                <td class="left">
                    <textarea name="left[description]" rows="10" class="form-control"
                              placeholder="<?= lang("description") ?>"></textarea>
                </td>
                <td>
                    <button type="button" class="btn pull-left transfer" data-transfer="right"><span
                                class="glyphicon glyphicon-chevron-right"></span></button>
                    <button type="button" class="btn pull-right transfer" data-transfer="left"><span
                                class="glyphicon glyphicon-chevron-left"></span></button>
                </td>
                <td class="right">
                    <textarea name="right[description]" rows="10" class="form-control"
                              placeholder="<?= lang("description") ?>"></textarea>
                </td>
            </tr>

            <tr data-type="image">
                <td class="left"></td>
                <td>
                    <button type="button" class="btn pull-left transfer" data-transfer="right"><span
                                class="glyphicon glyphicon-chevron-right"></span></button>
                    <button type="button" class="btn pull-right transfer" data-transfer="left"><span
                                class="glyphicon glyphicon-chevron-left"></span></button>
                </td>
                <td class="right"></td>
            </tr>

            <tr data-type="materials">
                <td class="left">
                    <div class="row"></div>
                </td>
                <td>
                    <div class="form-group">
                        <button type="button" class="btn pull-left transfer" data-transfer="right"><span
                                    class="glyphicon glyphicon-chevron-right"></span></button>
                        <button type="button" class="btn pull-right transfer" data-transfer="left"><span
                                    class="glyphicon glyphicon-chevron-left"></span></button>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger delete-materials" style="width: 100%;" disabled>
                            <span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                </td>
                <td class="right">
                    <div class="row"></div>
                </td>
            </tr>

        </table>

        <br>

        <div class="form-group">
            <div id="hidden"></div>
            <button type="submit" name="save" class="btn btn-primary" value="1"><?= lang("save") ?></button>
        </div>
    </form>

    <script type="text/javascript">
        var arr = <?= $json_petroglyphs ?>,
            left = {},
            right = {};
    </script>

    <script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
    <? if ($map_provider == 'google'): ?>
        <script type="text/javascript" src="/assets/js/markerclusterer/src/markerclusterer.js"></script>
        <script type="text/javascript" src="/assets/js/map_edouble.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeYhPhJAnwj95GXDg5BRT7Q2dTj303dQU&callback=initMap&language=<?= lang("lang") == "" ? "ru" : "en" ?>"
                type="text/javascript"></script>
    <? else: ?>
        <script src="https://api-maps.yandex.ru/2.1/?lang=<?= lang("lang") == "" ? "ru_RU" : "en_US" ?>&mode=debug"
                type="text/javascript"></script>
        <script src="/assets/js/tiler-converter.js" type="text/javascript"></script>
        <script type="text/javascript" src="/assets/js/map_yandex.js"></script>
    <? endif ?>

