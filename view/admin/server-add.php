<div class="uk-container uk-container-xsmall">
<form action="/admin/server" method="POST">
  <fieldset class="uk-fieldset">
    <div class="uk-margin">
      <label for="">Название</label>
      <input name="name" class="uk-input" type="text" placeholder="Название">
    </div>
    <div class="uk-margin">
      <label for="">Айпи</label>
      <input name="ip" class="uk-input" type="text" placeholder="Айпи">
    </div>
    <div class="uk-margin">
      <label for="">Порт</label>
      <input name="port" class="uk-input" type="text" placeholder="Порт">
    </div>
    <div class="uk-margin">
      <label for="">Пароль</label>
      <input name="password" class="uk-input" type="text" placeholder="Пароль">
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
