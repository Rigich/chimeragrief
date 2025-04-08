<div class="uk-container uk-container-xsmall">
<form action="/admin/category" method="POST">
  <fieldset class="uk-fieldset">
    <div class="uk-margin">
      <label for="">Название</label>
      <input name="name" class="uk-input" type="text" placeholder="Название">
    </div>
    <div class="uk-margin">
      <label for="">Изображение (/resources/images/category/ФАЙЛ)</label>
      <input name="background" class="uk-input" type="text" placeholder="Файл">
    </div>

    <div class="uk-flex uk-flex-middle uk-margin-bottom">
        <label for="" class="uk-margin-right">Доплата: </label>
        <div class="uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="on" name="supplement" checked>Включено</label>
            <label><input class="uk-radio uk-margin-small-right" type="radio" value="off" name="supplement">Выключено</label>
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
