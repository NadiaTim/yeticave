<main>
    <nav class="nav">
      
      <ul class="nav__list container">
      <?=$categories_temp;?>
      </ul>
    </nav>
    <section class="lot-item container">
      <h2><?=$lot['name']; ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="../<?=$lot['image']; ?>" width="730" height="548" alt="<?=$lot['name']; ?> ">
          </div>
          <p class="lot-item__category">Категория: <span><?=$lot['category']; ?></span></p>
          <p class="lot-item__description"><?=$lot['discription']; ?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state ">
            <?php $restTime=rest_time($lot['finish_date']); ?>
            <div class="lot-item__timer timer <?=($restTime[0]<1)&&($restTime[1]<1)?"timer--finishing":"";?>">
              <?= "$restTime[0]"."д ". "$restTime[1]:$restTime[2]" ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= price_format($lot['fin_price']);?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span>
                  <?php
                  $min_bet = $lot['fin_price']+ $lot['bet_stage'];
                  print(price_format($min_bet));
                  ?>
                </span>
              </div>
            </div>
            <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item form__item--invalid">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="12 000">
                <span class="form__error">Введите наименование лота</span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <div class="history">
            <h3>История ставок (<span>10</span>)</h3>
            <table class="history__list">
              <tr class="history__item">
                <td class="history__name">Иван</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">5 минут назад</td>
              </tr>
              
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>