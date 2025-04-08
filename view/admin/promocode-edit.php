<?php
  $result = mysqli_query($connection, "SELECT * FROM promocodes WHERE id = " . $promocode_id);
  $row = mysqli_fetch_assoc($result);
?>

<div class="uk-container uk-container-xsmall">
<form action="/admin/promocode" method="POST">
  <fieldset class="uk-fieldset">
      <input name="old_id" style="display:none;" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    <div class="uk-margin">
      <label for="">Идентификатор</label>
      <input name="id" class="uk-input" type="number" placeholder="Название" value="<? echo $row['id']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Промокод</label>
      <input name="promocode" class="uk-input" type="text" placeholder="Название" value="<? echo $row['promocode']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Скидка</label>
      <input name="discount" class="uk-input" type="number" placeholder="Айпи" value="<? echo $row['discount']; ?>">
    </div>
    <div class="uk-margin">
      <label for="">Количество</label>
      <input name="amount" class="uk-input" type="number" placeholder="Порт" value="<? echo $row['amount']; ?>">
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
