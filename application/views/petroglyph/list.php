<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?php if (isset($message)) echo $message;?>
<h1><?=lang("list_of_petroglyphs")?></h1>
<?php foreach ($petroglyphs as $petroglyph):?>
    #<?=$petroglyph->id?>. <a href="petroglyph/<?=$petroglyph->id?>"><?=$petroglyph->name?></a>
    <?php if ($admin):?>
        (<a href="petroglyph/admin/<?=$petroglyph->id?>"><?=lang("edit");?></a>)
        (<a href="petroglyph/delete/<?=$petroglyph->id?>"><?=lang("delete");?></a>)
    <?php endif?>
        <br>
<?php endforeach?>
<?php if ($admin):?>
<form action="petroglyph/admin">
    <button class="btn btn-default"><?=lang("add_petroglyph");?></button>
</form>
<?php endif?>
