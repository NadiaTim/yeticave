<main>
    <?= $categories_temp;?>
    <form class="form container <?= count($errors)>0?"form--invalid":""; ?>" action="https://echo.htmlacademy.ru" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?= div_invalid('email',$errors); ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item form__item--last <?= div_invalid('password',$errors); ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>