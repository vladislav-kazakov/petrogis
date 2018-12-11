<div class="col-md-12">
    <h1><?php if (isset($petroglyph['id'])):?><?=lang("edit_petroglyph");?> <?php else:?><?=lang("create_petroglyph");?><?php endif?> </h1>
</div>
<?php if (isset($message)):?>
    <div class="alert alert-danger" role="alert"><?=$message?></div>
<?php endif?>
<form enctype="multipart/form-data" method="post">
    <div class="col-md-6 form-group">
        <div class="form-group">
            <label><?=lang("name");?></label>
            <input type="text" name="name" class="form-control"
                   value="<?php if (isset($petroglyph['name'])) echo $petroglyph['name']?>">
        </div>

        <label><?=lang("image");?></label>
        <?php if (isset($petroglyph['img_src'])):?>
            <img id="imageContainer" class="img-responsive img-thumbnail bottom-20" src="<?=$petroglyph['img_src']?>">
        <?php else:?>
            <img id="imageContainer" class="img-responsive img-thumbnail bottom-20 invisible">
        <?php endif?>
        <input type="file" name="image" id="imageInput" class="form-control bottom-20">

        <label><?=lang("description");?></label>
        <textarea name="description" rows="10" class="form-control"><?php if (isset($petroglyph['description'])) echo $petroglyph['description']?></textarea>
    </div>
    <div class="col-md-6 form-group">
        <div class="col-md-6 form-group">
            <label><?=lang("epoch");?></label>
            <select size="12" name="epoch[]" multiple class="form-control">
                <option value="neolithic" <?=isset($petroglyph['epoch']) && in_array('neolithic', $petroglyph['epoch'])?'selected':''?> ><?=lang("neolithic");?></option>
                <option value="p_neolithic" <?=isset($petroglyph['epoch']) && in_array('p_neolithic', $petroglyph['epoch'])?'selected':''?> ><?=lang("neolithic");?> (?)</option>
                <option value="early_bronze" <?=isset($petroglyph['epoch']) && in_array('early_bronze', $petroglyph['epoch'])?'selected':''?> ><?=lang("early_bronze_epoch");?></option>
                <option value="middle_bronze" <?=isset($petroglyph['epoch']) && in_array('middle_bronze', $petroglyph['epoch'])?'selected':''?> ><?=lang("middle_bronze_epoch");?></option>
                <option value="late_bronze" <?=isset($petroglyph['epoch']) && in_array('late_bronze', $petroglyph['epoch'])?'selected':''?> ><?=lang("late_bronze_epoch");?></option>
                <option value="bronze" <?=isset($petroglyph['epoch']) && in_array('bronze', $petroglyph['epoch'])?'selected':''?> ><?=lang("bronze_epoch");?></option>
                <option value="p_bronze" <?=isset($petroglyph['epoch']) && in_array('p_bronze', $petroglyph['epoch'])?'selected':''?> ><?=lang("bronze_epoch");?> (?)</option>
                <option value="early_iron" <?=isset($petroglyph['epoch']) && in_array('early_iron', $petroglyph['epoch'])?'selected':''?> ><?=lang("early_iron_age");?></option>
                <option value="middle_iron" <?=isset($petroglyph['epoch']) && in_array('middle_iron', $petroglyph['epoch'])?'selected':''?> ><?=lang("middle_iron_age");?></option>
                <option value="late_iron" <?=isset($petroglyph['epoch']) && in_array('late_iron', $petroglyph['epoch'])?'selected':''?> ><?=lang("late_iron_age");?></option>
                <option value="early_iron" <?=isset($petroglyph['epoch']) && in_array('early_iron', $petroglyph['epoch'])?'selected':''?> ><?=lang("early_iron_age");?></option>
                <option value="p_early_iron" <?=isset($petroglyph['epoch']) && in_array('p_early_iron', $petroglyph['epoch'])?'selected':''?> ><?=lang("early_iron_age");?> (?)</option>
                <option value="middle" <?=isset($petroglyph['epoch']) && in_array('middle', $petroglyph['epoch'])?'selected':''?> ><?=lang("middle_age");?></option>
                <option value="p_middle" <?=isset($petroglyph['epoch']) && in_array('p_middle', $petroglyph['epoch'])?'selected':''?> ><?=lang("middle_age");?> (?)</option>
                <option value="modern" <?=isset($petroglyph['epoch']) && in_array('modern', $petroglyph['epoch'])?'selected':''?> ><?=lang("modern_period");?></option>
                <option value="p_modern" <?=isset($petroglyph['epoch']) && in_array('p_modern', $petroglyph['epoch'])?'selected':''?> ><?=lang("modern_period");?> (?)</option>
                <option value="contemporary" <?=isset($petroglyph['epoch']) && in_array('contemporary', $petroglyph['epoch'])?'selected':''?> ><?=lang("contemporary_period");?></option>
                <option value="p_contemporary" <?=isset($petroglyph['epoch']) && in_array('p_contemporary', $petroglyph['epoch'])?'selected':''?> ><?=lang("contemporary_period");?> (?)</option>
                <option value="ethnographic" <?=isset($petroglyph['epoch']) && in_array('ethnographic', $petroglyph['epoch'])?'selected':''?> ><?=lang("ethnographic_period");?></option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label><?=lang("method");?></label>
            <select size="2" name="method[]" multiple class="form-control">
                <option value="pecking" <?=isset($petroglyph['method']) && in_array('pecking', $petroglyph['method'])?'selected':''?> ><?=lang("pecking");?></option>
                <option value="engraving" <?=isset($petroglyph['method']) && in_array('engraving', $petroglyph['method'])?'selected':''?> ><?=lang("engraving");?></option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 form-group">
            <label><?=lang("latitude");?></label>
            <input type="text" name="lat" class="form-control"
                   value="<?php if (isset($petroglyph['lat'])) echo $petroglyph['lat']?>">
            <label ><?=lang("longitude");?></label>
            <input type="text" name="lng" class="form-control"
                   value="<?php if (isset($petroglyph['lng'])) echo $petroglyph['lng']?>">
        </div>
        <div class="col-md-6 form-group">
            <label><?=lang("culture");?></label>
            <select size="2" name="culture[]" multiple class="form-control">
                <option value="scythian" <?=isset($petroglyph['culture']) && in_array('scythian', $petroglyph['culture'])?'selected':''?> ><?=lang("scythian");?></option>
                <option value="turk" <?=isset($petroglyph['culture']) && in_array('turk', $petroglyph['culture'])?'selected':''?> ><?=lang("turkic");?></option>
            </select>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <button type="submit" name="SavePetroglyph" class="btn btn-default" value="1"><?=lang("save");?></button>
    </div>
</form>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageContainer').attr('src', e.target.result);
                $('#imageContainer').removeClass('invisible');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageInput").change(function(){
        readURL(this);
    });
</script>
