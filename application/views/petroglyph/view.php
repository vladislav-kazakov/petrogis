<?if (isset($message)) echo $message;?>
<p>Petroglyphs #<?=$petroglyph->id?></p>

    Name: <?=$petroglyph->name?><br>
    Lat: <?=$petroglyph->lat?><br>
    Lng: <?=$petroglyph->lng?><br>
    <?if (isset($img_src)):?>
    Image:<br>
    <img class="petroglyph_view" src="<?=$img_src?>">
    <?endif?>
<br>
Method:
<br>
    <?=$petroglyph->method==1?'выбивка':''?>
    <?=$petroglyph->method==2?'гравировка':''?>
    <?=$petroglyph->method==3?'гравировка и выбивка':''?>
<br>
Culture:
<br>
    <?=$petroglyph->culture==1?'скифская':''?>
    <?=$petroglyph->culture==2?'тюркская':''?>
    <?=$petroglyph->culture==3?'современная':''?>
<br>
Description:
<br>
<?=$petroglyph->description?>

    <br><br>
    <a href="admin/<?=$petroglyph->id?>">Edit</a><br>
    <a href="delete/<?=$petroglyph->id?>">Delete</a><br>

