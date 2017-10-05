<h1>petro form</h1>
<form enctype="multipart/form-data" method="post">
    Name: <input type="text" name="name" value="<?if (isset($petroglyph['name'])) echo $petroglyph['name']?>"><br>
    Lat: <input type="text" name="lat" value="<?if (isset($petroglyph['lat'])) echo $petroglyph['lat']?>"><br>
    Lng: <input type="text" name="lng" value="<?if (isset($petroglyph['lng'])) echo $petroglyph['lng']?>"><br>
    Image: <input type="file" name="image"><br>

    Method:
    <br>
    <select size="10" name="method">
        <option value="1" <?=isset($petroglyph['method']) && $petroglyph['method']==1?'selected':''?> >выбивка</option>
        <option value="2" <?=isset($petroglyph['method']) && $petroglyph['method']==2?'selected':''?> >гравировка</option>
        <option value="3" <?=isset($petroglyph['method']) && $petroglyph['method']==3?'selected':''?> >гравировка и выбивка</option>
    </select>
<br>
    Culture:
    <br>
    <select size="10" name="culture">
        <option value="1" <?=isset($petroglyph['culture']) && $petroglyph['culture']==1?'selected':''?> >скифская</option>
        <option value="2" <?=isset($petroglyph['culture']) && $petroglyph['culture']==2?'selected':''?> >тюркская</option>
        <option value="3" <?=isset($petroglyph['culture']) && $petroglyph['culture']==3?'selected':''?> >современная</option>
    </select>
    <br>
    Description:
    <br>
    <textarea name="description"><?if (isset($petroglyph['description'])) echo $petroglyph['description']?></textarea>
    <br>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
<br>
<?= $_SESSION['referrer']? $_SESSION['referrer'] : 'petroglyph'?>
