<?php
  $result = mysqli_query($connection, "SELECT * FROM products WHERE id = " . $product_id);
  $row = mysqli_fetch_assoc($result);
?>

<div class="uk-container uk-container-xsmall">
<form action="/admin/product" method="POST">
  <fieldset class="uk-fieldset">
    <input name="old_id" style="display:none;" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    <div class="uk-margin">
      <label for="">Идентификатор</label>
      <input name="id" class="uk-input" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Название</label>
      <input name="name" class="uk-input" type="text" placeholder="Название" value="<? echo $row['name']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Название для вида</label>
      <input name="displayname" class="uk-input" type="text" placeholder="Название для вида" value="<? echo $row['displayname']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Описание</label>
      <textarea name="description" class="uk-textarea" rows="5" placeholder="Описание" style="resize: none;"><? echo $row['description']; ?></textarea>
    </div>
    <div class="uk-margin">
      <label for="">Цена</label>
      <input name="price" class="uk-input" type="number" placeholder="Цена" value="<? echo $row['price']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Скидка</label>
      <input name="discount" class="uk-input" type="number" placeholder="Скидка" value="<? echo $row['discount']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Изображение (/resources/images/category/ФАЙЛ)</label>
      <input name="background" class="uk-input" type="text" placeholder="Файл" value="<? echo $row['background']; ?>">
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="category">Категория</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="category" name="category_id">
                <?php
                    $result = mysqli_query($connection, "SELECT id, name FROM categories");
                    while ($category = mysqli_fetch_assoc($result)) {
                        if($category['id'] == $row['category_id']) {
                            echo '<option value="' . $category['id'] . '" selected>' . $category['id'] . " - " . $category['name'] . '</option>';
                        } else {
                            echo '<option value="' . $category['id'] . '">' . $category['id'] . " - " . $category['name'] . '</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    
    <div class="uk-margin">
      <label for="">Команды</label>
      <textarea name="commands" class="uk-textarea" rows="5" placeholder="Команды" style="resize: none;"><? echo $row['commands']; ?></textarea>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="server">Сервера</label>
        <div class="uk-form-controls">
            <?php
                $result = mysqli_query($connection, "SELECT id, name FROM servers");
                $servers = explode(',', $row['servers']);
                $checked = false;
                while ($server = mysqli_fetch_assoc($result)) {
                    foreach($servers as $server_id) {
                        if($server['id'] == $server_id) {
                            $checked = true;
                        }
                    }
                    if($checked) {
                        echo '<label style="display: block;" class="uk-margin-small"><input class="uk-checkbox uk-margin-small-right" type="checkbox" name="server-' . $server['id'] . '" checked>' . $server['id'] . " - " . $server['name'] . '</label>';
                        $checked = false;
                    } else {
                        echo '<label style="display: block;" class="uk-margin-small"><input class="uk-checkbox uk-margin-small-right" type="checkbox" name="server-' . $server['id'] . '">' . $server['id'] . " - " . $server['name'] . '</label>';
                    }
                }
            ?>
        </div>
    </div>

    <div class="uk-flex uk-flex-middle uk-margin-bottom">
        <label for="" class="uk-margin-right">Количество: </label>
        <div class="uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="on" name="amounted" <? echo $row['amounted'] ? "checked" : ""; ?>>Разрешено</label>
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="off" name="amounted"<? echo !$row['amounted'] ? "checked" : ""; ?>>Запрешено</label>
        </div>
    </div>

    <div class="uk-flex uk-flex-middle uk-margin-bottom">
        <label for="" class="uk-margin-right">Статус: </label>
        <div class="uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="on" name="status" <? echo $row['status'] ? "checked" : ""; ?>>Включено</label>
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="off" name="status"<? echo !$row['status'] ? "checked" : ""; ?>>Выключено</label>
        </div>
    </div>
    <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
  </fieldset>
</form>
</div>
