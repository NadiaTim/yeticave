  <main>
    <?php $categories_temp;?>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <?php if (isset($bets)): ?>
      <table class="rates__list">
      <?php foreach ($bets as $bet): ?>
        <?php 
        switch ($bet['status_id']):
          case "win": $class_tr = "rates__item--win"; 
            $class_timer = "timer--win";
            break;
          case "end": $class_tr = "rates__item--end"; 
            $class_timer = "timer--end";
            break;
          case "finishing": $class_tr = ""; 
            $class_timer = "timer--finishing";
            break;
          default: $class_tr = ""; $class_timer = "";break;
        endswitch; 
        ?>

        <tr class="rates__item <?= $class_tr;?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $bet['image'];?>" width="54" height="40" alt="<?= $bet['lot_name'];?>">
            </div>
            <?php if($bet['status_id']=='win'): ?>
              <div>
                <h3 class="rates__title"><a href="lot.html?lot_id=<?= $bet['lot_id'];?>"><?= $bet['lot_name'];?></a></h3>
                <p><?= $bet['contact'];?></p>
              </div>
            <?php else: ?>
              <h3 class="rates__title"><a href="lot.html?lot_id=<?= $bet['lot_id'];?>"><?= $bet['lot_name'];?></a></h3>
            <?php endif; ?>
          </td>
          <td class="rates__category">
            <?= $bet['cat_name'];?>
          </td>
          <td class="rates__timer">
            <div class="timer <?= $class_timer;?>"><?= $bet['status'];?></div>
          </td>
          <td class="rates__price">
            <?= price_format($bet['price']);?>
          </td>
          <td class="rates__time">
            <?= $bet['time_ago'];?>
          </td>
        </tr>
      <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p>У вас нет ставок</p>
      <?php endif; ?>
    </section>
  </main>