<main>
    <?= $categories_temp;?>
    <form class="form container <?= count($errors)>0?"form--invalid":""; ?> " action="../sign_up.php" method="post" autocomplete="off"> <!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= div_invalid('email', $errors); ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= isset($new_user['email'])?$new_user['email']:"";?>">
        <span class="form__error"><?= isset($errors['email'])?$errors['email']:"" ?></span>
      </div>
      <div class="form__item <?= div_invalid('password', $errors); ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item <?= div_invalid('name', $errors); ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= isset($new_user['name'])?$new_user['name']:"";?>">
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item <?= div_invalid('message', $errors); ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= isset($new_user['message'])?$new_user['message']:"";?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
  </main>