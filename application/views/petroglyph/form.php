<div class="col-md-12">
    <h1><?if (isset($petroglyph['id'])):?>Редактировать петроглиф <?else:?>Создать петроглиф<?endif?> </h1>
</div>
<?if (isset($message)):?>
    <div class="alert alert-danger" role="alert"><?=$message?></div>
<?endif?>
<form enctype="multipart/form-data" method="post">
    <div class="col-md-6 form-group">
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="name" class="form-control"
                   value="<?if (isset($petroglyph['name'])) echo $petroglyph['name']?>">
        </div>

        <label>Изображение</label>
        <?if (isset($petroglyph['img_src'])):?>
            <img id="imageContainer" class="img-responsive img-thumbnail bottom-20" src="<?=$petroglyph['img_src']?>">
        <?else:?>
            <img id="imageContainer" class="img-responsive img-thumbnail bottom-20 invisible">
        <?endif?>
        <input type="file" name="image" id="imageInput" class="form-control bottom-20">

        <label>Описание</label>
        <textarea name="description" rows="10" class="form-control"><?if (isset($petroglyph['description'])) echo $petroglyph['description']?></textarea>
    </div>
    <div class="col-md-6 form-group">
        <div class="col-md-6 form-group">
            <label>Эпоха</label>
            <select size="12" name="epoch[]" multiple class="form-control">
                <option value="neolithic" <?=isset($petroglyph['epoch']) && in_array('neolithic', $petroglyph['epoch'])?'selected':''?> >неолит</option>
                <option value="p_neolithic" <?=isset($petroglyph['epoch']) && in_array('p_neolithic', $petroglyph['epoch'])?'selected':''?> >неолит (?)</option>
                <option value="bronze" <?=isset($petroglyph['epoch']) && in_array('bronze', $petroglyph['epoch'])?'selected':''?> >эпоха бронзы</option>
                <option value="p_bronze" <?=isset($petroglyph['epoch']) && in_array('p_bronze', $petroglyph['epoch'])?'selected':''?> >эпоха бронзы (?)</option>
                <option value="early_iron" <?=isset($petroglyph['epoch']) && in_array('early_iron', $petroglyph['epoch'])?'selected':''?> >ранний железный век</option>
                <option value="p_early_iron" <?=isset($petroglyph['epoch']) && in_array('p_early_iron', $petroglyph['epoch'])?'selected':''?> >ранний железный век (?)</option>
                <option value="middle" <?=isset($petroglyph['epoch']) && in_array('middle', $petroglyph['epoch'])?'selected':''?> >средневековье</option>
                <option value="p_middle" <?=isset($petroglyph['epoch']) && in_array('p_middle', $petroglyph['epoch'])?'selected':''?> >средневековье (?)</option>
                <option value="modern" <?=isset($petroglyph['epoch']) && in_array('modern', $petroglyph['epoch'])?'selected':''?> >новое время</option>
                <option value="p_modern" <?=isset($petroglyph['epoch']) && in_array('p_modern', $petroglyph['epoch'])?'selected':''?> >новое время (?)</option>
                <option value="contemporary" <?=isset($petroglyph['epoch']) && in_array('contemporary', $petroglyph['epoch'])?'selected':''?> >новейшее время</option>
                <option value="p_contemporary" <?=isset($petroglyph['epoch']) && in_array('p_contemporary', $petroglyph['epoch'])?'selected':''?> >новейшее время (?)</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label>Метод</label>
            <select size="2" name="method[]" multiple class="form-control">
                <option value="pecking" <?=isset($petroglyph['method']) && in_array('pecking', $petroglyph['method'])?'selected':''?> >выбивка</option>
                <option value="engraving" <?=isset($petroglyph['method']) && in_array('engraving', $petroglyph['method'])?'selected':''?> >гравировка</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 form-group">
            <label>Широта</label>
            <input type="text" name="lat" class="form-control"
                   value="<?if (isset($petroglyph['lat'])) echo $petroglyph['lat']?>">
            <label >Долгота</label>
            <input type="text" name="lng" class="form-control"
                   value="<?if (isset($petroglyph['lng'])) echo $petroglyph['lng']?>">
        </div>
        <div class="col-md-6 form-group">
            <label>Культура</label>
            <select size="2" name="culture[]" multiple class="form-control">
                <option value="scythian" <?=isset($petroglyph['culture']) && in_array('scythian', $petroglyph['culture'])?'selected':''?> >скифская</option>
                <option value="turk" <?=isset($petroglyph['culture']) && in_array('turk', $petroglyph['culture'])?'selected':''?> >тюркская</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <button type="submit" name="SavePetroglyph" class="btn btn-default" value="1">Сохранить</button>
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
