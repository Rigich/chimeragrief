<div class="uk-container uk-container-xsmall">
<form action="/admin/product" method="POST">
  <fieldset class="uk-fieldset">
    <div class="uk-margin">
      <label for="">Название</label>
      <input name="name" class="uk-input" type="text" placeholder="Название">
    </div>
    <div class="uk-margin">
      <label for="">Название для вида</label>
      <input name="displayname" class="uk-input" type="text" placeholder="Название для вида">
    </div>
    <div class="uk-margin">
      <label for="">Описание</label>
      <textarea name="description" class="uk-textarea" rows="5" placeholder="Описание" style="resize: none;"></textarea>
    </div>
    <div class="uk-margin">
      <label for="">Цена</label>
      <input name="price" class="uk-input" type="number" placeholder="Цена">
    </div>
    <div class="uk-margin">
      <label for="">Скидка</label>
      <input name="discount" class="uk-input" type="number" placeholder="Скидка">
    </div>
    <div class="uk-margin">
      <label for="">Изображение (/resources/images/product/ФАЙЛ)</label>
      <input name="background" class="uk-input" type="text" placeholder="Файл">
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="category">Категория</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="category" name="category_id">
                <?php
                    $result = mysqli_query($connection, "SELECT id, name FROM categories");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['id'] . '">' . $row['id'] . " - " . $row['name'] . '</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    
    <!-- 
    lp user {nickname} group add {name}
    broadcast &7* &fИгрок &e{name} &fкупил привилегию &e{displayname}
    -->
    
    <div class="uk-margin">
      <label for="">Команды</label>
      <textarea name="commands" class="uk-textarea" rows="5" placeholder="Команды" style="resize: none;"></textarea>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="server">Сервера</label>
        <div class="uk-form-controls">
            <?php
                $result = mysqli_query($connection, "SELECT id, name FROM servers");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<label style="display: block;" class="uk-margin-small"><input class="uk-checkbox uk-margin-small-right" type="checkbox" name="server-' . $row['id'] . '">' . $row['id'] . " - " . $row['name'] . '</label>';
                }
            ?>
        </div>
    </div>

    <div class="uk-flex uk-flex-middle uk-margin-bottom">
        <label for="" class="uk-margin-right">Количество: </label>
        <div class="uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="on" name="amounted" checked>Разрешено</label>
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="off" name="amounted">Запрещено</label>
        </div>
    </div>

    <div class="uk-flex uk-flex-middle uk-margin-bottom">
        <label for="" class="uk-margin-right">Статус: </label>
        <div class="uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="on" name="status" checked>Включено</label>
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="off" name="status">Выключено</label>
        </div>
    </div>
    <button class="uk-button uk-button-primary uk-width-1-1">Добавить</button>
  </fieldset>
</form>
</div>
