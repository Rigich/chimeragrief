<div class="uk-container uk-container-xsmall">
<form action="/admin/promocode" method="POST">
  <fieldset class="uk-fieldset">
    <div class="uk-margin">
      <label for="">Промокод</label>
      <input name="promocode" class="uk-input" type="text" placeholder="Промокод">
    </div>
    <div class="uk-margin">
      <label for="">Скидка</label>
      <input name="discount" class="uk-input" type="number" placeholder="Скидка">
    </div>
    <div class="uk-margin">
      <label for="">Количество</label>
      <input name="amount" class="uk-input" type="number" placeholder="Количество">
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
