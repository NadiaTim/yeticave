  <main>
    <?php $categories_temp;?>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../img/rate1.jpg" width="54" height="40" alt="Сноуборд">
            </div>
            <?php if($bet['status']=='win'): ?>
              <div>
                <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
                <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
              </div>
            <?php else: ?>
              <h3 class="rates__title"><a href="lot.html">2014 Rossignol District Snowboard</a></h3>
            <?php endif; ?>
          </td>
          <td class="rates__category">
            Доски и лыжи
          </td>
          <td class="rates__timer">
            <div class="timer timer--finishing">07:13:34</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            5 минут назад
          </td>
        </tr>
      </table>
    </section>
  </main>