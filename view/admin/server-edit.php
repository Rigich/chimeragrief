<?php
  $result = mysqli_query($connection, "SELECT * FROM servers WHERE id = " . $server_id);
  $row = mysqli_fetch_assoc($result);
?>

<div class="uk-container uk-container-xsmall">
<form action="/admin/server" method="POST">
  <fieldset class="uk-fieldset">
      <input name="old_id" style="display:none;" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    <div class="uk-margin">
      <label for="">Идентификатор (Бывают ошибки из-за того, что имеется продукты с этим идентификатором)</label>
      <input name="id" class="uk-input" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Название</label>
      <input name="name" class="uk-input" type="text" placeholder="Название" value="<? echo $row['name']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Айпи</label>
      <input name="ip" class="uk-input" type="text" placeholder="Айпи" value="<? echo $row['ip']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Порт</label>
      <input name="port" class="uk-input" type="text" placeholder="Порт" value="<? echo $row['port']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Пароль</label>
      <input name="password" class="uk-input" type="text" placeholder="Пароль" value="<? echo $row['password']; ?>">
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
