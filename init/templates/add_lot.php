<main>
    <?=$categories_temp; ?>
    <form class="form form--add-lot container <?= isset($errors)?"form--invalid":"";?>" action="../add_lot.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?= isset($errors['lot-name'])?"form__item--invalid":"";?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$new_lot['lot-name']; ?>">
          <span class="form__error"><?= isset($errors['lot-name'])?$errors['lot-name']:"";?></span>
        </div>
        <div class="form__item <?= isset($errors['category'])?"form__item--invalid":"";?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $key => $category): ?>
              <?php echo '<option value="'.$category['category_id']; 
                echo ($category['category_id']==$new_lot['category'])?'" selected> ':'">';
                echo $category['name']; ?>
            </option>
            <?php endforeach ?>
          </select>
          <span class="form__error"><?= isset($errors['category'])?$errors['category']:"";?></span>
        </div>
      </div>
      <div class="form__item form__item--wide <?= isset($errors['message'])?"form__item--invalid":"";?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$new_lot['message']; ?></textarea>
        <span class="form__error"><?= isset($errors['message'])?$errors['message']:"";?></span>
      </div>
      <div class="form__item form__item--file <?= isset($errors['file'])?"form__item--invalid":"";?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="lot-img" value="">
          <label for="lot-img">
            Добавить
          </label>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors['lot-rate'])?"form__item--invalid":"";?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=$new_lot['lot-rate']; ?>">
          <span class="form__error"><?= isset($errors['lot-rate'])?$errors['lot-rate']:"";?></span>
        </div>
        <div class="form__item form__item--small <?= isset($errors['lot-step'])?"form__item--invalid":"";?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=$new_lot['lot-step']; ?>">
          <span class="form__error"><?= isset($errors['lot-step'])?$errors['lot-step']:"";?></span>
        </div>
        <div class="form__item <?= isset($errors['lot-date'])?"form__item--invalid":"";?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$new_lot['lot-date']; ?>">
          <span class="form__error"><?= isset($errors['lot-date'])?$errors['lot-date']:"";?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">
        Пожалуйста, исправьте ошибки в форме:<br>
        <?php
        $errors_l=array_values($errors);
        $errors_l=array_unique($errors_l);
          foreach ($errors_l as $error) {
            if ($error=="Это обязательное поле") {
              print("Заполните обязательные поля".'<br>');
            } else {
              print($error.'<br>');
            }  
          }

        ?>
      </span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>