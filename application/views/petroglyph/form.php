<div class="col-md-12">
    <h1><? if (isset($petroglyph['id'])): ?><?= lang("edit_petroglyph"); ?><? else: ?><?= lang("create_petroglyph"); ?><? endif ?> </h1>
</div>
<? if (isset($message)): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<? endif ?>
<form enctype="multipart/form-data" method="post">
    <div class="col-md-6 form-group">
        <div class="form-group">
            <input type="checkbox" name="is_public" <?= $petroglyph['is_public'] ? 'checked' : null ?> id="is_public">
            <?= lang("is_public", 'is_public'); ?>
        </div>

        <div class="form-group">
            <label><?= lang("name"); ?></label>
            <input type="text" name="name" class="form-control"
                   value="<? if (isset($petroglyph['name'])) echo $petroglyph['name'] ?>">
        </div>

        <label><?= lang("image"); ?></label>
        <? if (isset($petroglyph['img_src'])): ?>
            <div class="control-rotate bottom-20">
<!--                <a class="btn btn-default" href="/petroglyph/rotateLeft/--><?//= $petroglyph['id']?><!--">↺</a>-->
<!--                <a class="btn btn-default" href="/petroglyph/rotateRight/--><?//= $petroglyph['id']?><!--">↻</a>-->
                <input type="hidden" name="imageRotate" value="0">
                <button type="button" onclick="rotate(90)" class="btn btn-default"><?= lang("turn"); ?> ↻</button>
            </div>
            <div id="boxImage">
                <img id="imageContainer" class="img-responsive img-thumbnail" src="<?= $petroglyph['img_src'] ?>">
            </div>
        <? else: ?>
            <img id="imageContainer" class="img-responsive img-thumbnail bottom-20 invisible">
        <? endif ?>
        <input type="file" name="image" id="imageInput" class="form-control bottom-20">

        <label><?= lang("description"); ?></label>
        <textarea name="description" rows="10"
                  class="form-control"><? if (isset($petroglyph['description'])) echo $petroglyph['description'] ?></textarea>
    </div>
    <div class="col-md-6 form-group">
        <div class="col-md-6 form-group">
            <label><?= lang("epoch"); ?></label>
            <select size="12" name="epoch[]" multiple class="form-control">
                <option value="neolithic" <?= isset($petroglyph['epoch']) && in_array('neolithic', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("neolithic"); ?></option>
                <option value="p_neolithic" <?= isset($petroglyph['epoch']) && in_array('p_neolithic', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("neolithic"); ?>
                    (?)
                </option>
                <option value="bronze" <?= isset($petroglyph['epoch']) && in_array('bronze', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("bronze_epoch"); ?></option>
                <option value="p_bronze" <?= isset($petroglyph['epoch']) && in_array('p_bronze', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("bronze_epoch"); ?>
                    (?)
                </option>
                <option value="early_iron" <?= isset($petroglyph['epoch']) && in_array('early_iron', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("early_iron_age"); ?></option>
                <option value="p_early_iron" <?= isset($petroglyph['epoch']) && in_array('p_early_iron', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("early_iron_age"); ?>
                    (?)
                </option>
                <option value="middle" <?= isset($petroglyph['epoch']) && in_array('middle', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("middle_age"); ?></option>
                <option value="p_middle" <?= isset($petroglyph['epoch']) && in_array('p_middle', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("middle_age"); ?>
                    (?)
                </option>
                <option value="modern" <?= isset($petroglyph['epoch']) && in_array('modern', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("modern_period"); ?></option>
                <option value="p_modern" <?= isset($petroglyph['epoch']) && in_array('p_modern', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("modern_period"); ?>
                    (?)
                </option>
                <option value="contemporary" <?= isset($petroglyph['epoch']) && in_array('contemporary', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("contemporary_period"); ?></option>
                <option value="p_contemporary" <?= isset($petroglyph['epoch']) && in_array('p_contemporary', $petroglyph['epoch']) ? 'selected' : '' ?> ><?= lang("contemporary_period"); ?>
                    (?)
                </option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label><?= lang("method"); ?></label>
            <select size="2" name="method[]" multiple class="form-control">
                <option value="pecking" <?= isset($petroglyph['method']) && in_array('pecking', $petroglyph['method']) ? 'selected' : '' ?> ><?= lang("pecking"); ?></option>
                <option value="engraving" <?= isset($petroglyph['method']) && in_array('engraving', $petroglyph['method']) ? 'selected' : '' ?> ><?= lang("engraving"); ?></option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 form-group">
            <label><?= lang("latitude"); ?></label>
            <input type="text" name="lat" class="form-control"
                   value="<? if (isset($petroglyph['lat'])) echo $petroglyph['lat'] ?>">
            <label><?= lang("longitude"); ?></label>
            <input type="text" name="lng" class="form-control"
                   value="<? if (isset($petroglyph['lng'])) echo $petroglyph['lng'] ?>">
        </div>
        <div class="col-md-6 form-group">
            <label><?= lang("culture"); ?></label>
            <select size="2" name="culture[]" multiple class="form-control">
                <option value="scythian" <?= isset($petroglyph['culture']) && in_array('scythian', $petroglyph['culture']) ? 'selected' : '' ?> ><?= lang("scythian"); ?></option>
                <option value="turk" <?= isset($petroglyph['culture']) && in_array('turk', $petroglyph['culture']) ? 'selected' : '' ?> ><?= lang("turkic"); ?></option>
            </select>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <button type="submit" name="SavePetroglyph" class="btn btn-default" value="1"><?= lang("save"); ?></button>
    </div>
</form>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageContainer').attr('src', e.target.result);
                $('#imageContainer').removeClass('invisible');
                // $('.control-rotate').hide();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageInput").change(function () {
        readURL(this);
    });
</script>

<script>
    var angle = 0,
        image = $("#imageContainer"),
        box = $("#boxImage"),
        w_i = image.width(),
        h_i = image.height(),
        w_b = box.width(),
        h_b = box.height();

    function rotate(deg) {
        angle = (angle + deg) % 360;

        if (angle % 180) {
            if(h_i > w_i) {
                image.css({'width': w_i*w_b/h_b});
            }
        } else {
            if(h_i > w_i) {
                image.css({'width': w_i});
            }
        }

        box.attr('class', 'rotate' + angle);
        $("input[name=imageRotate]").val(angle);
    }
</script>

<style>
    #boxImage {
        margin-bottom: 22px;
        overflow: hidden;
    }

    #imageContainer {
        transform-origin: top left;
        /* IE 10+, Firefox, etc. */
        -webkit-transform-origin: top left;
        /* Chrome */
        -ms-transform-origin: top left;
        /* IE 9 */
    }

    #boxImage.rotate90 #imageContainer {
        transform: rotate(90deg) translateY(-100%);
        -webkit-transform: rotate(90deg) translateY(-100%);
        -ms-transform: rotate(90deg) translateY(-100%);
    }

    #boxImage.rotate180 #imageContainer {
        transform: rotate(180deg) translate(-100%, -100%);
        -webkit-transform: rotate(180deg) translate(-100%, -100%);
        -ms-transform: rotate(180deg) translateX(-100%, -100%);
    }

    #boxImage.rotate270 #imageContainer {
        transform: rotate(270deg) translateX(-100%);
        -webkit-transform: rotate(270deg) translateX(-100%);
        -ms-transform: rotate(270deg) translateX(-100%);
    }

    #boxImage.rotate0 #imageContainer {
        transform: rotate(0deg);
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
    }
</style>
