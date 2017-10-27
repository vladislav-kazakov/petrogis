<script>
    document.cookie = "referrer=" + document.URL + ";path=/";
</script>
<?if (isset($message)) echo $message;?>
<h1>Список петроглифов</h1>
<?foreach ($petroglyphs as $petroglyph):?>
    #<?=$petroglyph->id?>. <a href="petroglyph/<?=$petroglyph->id?>"><?=$petroglyph->name?></a>
    (<a href="petroglyph/admin/<?=$petroglyph->id?>">Редактировать</a>)
    (<a href="petroglyph/delete/<?=$petroglyph->id?>">Удалить</a>)
        <br>
<?endforeach?>

<form action="petroglyph/admin">
    <button class="btn btn-default">Добавить петроглиф</button>
</form>
