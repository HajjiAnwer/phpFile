<form action="" method="post">
    <input type="hidden" name="idjoke"value="<?=$joke['idjoke'];?>">
    <label for="joketext" class="h4 text-danger mt-3">Type your joke here:</label>
    <textarea id="joketext" name="joketext" required rows="6" class="rounded  form-control border-dark mt-3">
    <?=$joke['joketext']?></textarea>
    <input type="submit" value="Save" class="bg-success rounded border-success mt-3">
</form>