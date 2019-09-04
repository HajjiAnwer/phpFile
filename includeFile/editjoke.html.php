<?php if (empty($joke->idjoke) || $userid ==$joke->authorid):?>
<form action="" method="post">
<input type="hidden" name="joke[idjoke]"value="<?=$joke->idjoke ?? ''?>">
<label for="joketext">Type your joke here:</label>
<textarea id="joketext" name="joke[joketext]" rows="3" cols="40">
<?=$joke->joketext ??''?>
</textarea>
<input type="submit" name="submit" value="Save">
</form>
<?php else:?>
<p>You may only edit jokes that you posted.</p>
<?php endif; ?>