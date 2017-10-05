<?if (isset($message)) echo $message;?>
<p>List of petroglyphs</p>
<?foreach ($petroglyphs as $petroglyph):?>
    #<?=$petroglyph->id?>. <a href="petroglyph/<?=$petroglyph->id?>"><?=$petroglyph->name?></a>
    (<a href="petroglyph/admin/<?=$petroglyph->id?>">Edit</a>)
    (<a href="petroglyph/delete/<?=$petroglyph->id?>">Delete</a>)
        <br>
<?endforeach?>

<form action="petroglyph/admin">
    <button class="btn btn-default">Add petroglyph</button>
</form>
