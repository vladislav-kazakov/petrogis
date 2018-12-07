<div class="col-md-12">
    <h1>Добавить файл в петроглиф</h1>
</div>
<?php if (isset($message)):?>
    <div class="alert alert-danger" role="alert"><?=$message?></div>
<?php endif?>
<form enctype="multipart/form-data" method="post">
    <div class="col-md-6 form-group">
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="name" class="form-control"
                   value="<?php if (isset($material['name'])) echo $material['name']?>">
        </div>

        <label>Файл</label>
        <img id="imageContainer" class="img-responsive img-thumbnail bottom-20 invisible">
        <input type="file" name="material" id="imageInput" class="form-control bottom-20">

    </div>
    <div class="col-md-6 form-group">

        <label>Описание</label>
        <textarea name="description" rows="10" class="form-control"><?php if (isset($petroglyph['description'])) echo $petroglyph['description']?></textarea>
    </div>
    <div class="col-md-12 form-group">
        <button type="submit" name="AddMaterial" class="btn btn-default" value="1">Сохранить</button>
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