<form action="" method="post">
    <input type="hidden"name="category[id]"value="<?=$category->id ?? ''?>">
    <label for="categoryname">Enter category name:</label>
    <input type="text"id="categoryname"name="category[categoryname]"value="<?=$category->categoryname ?? ''?>" />
    <input type="submit" name="submit" value="Save">
</form>