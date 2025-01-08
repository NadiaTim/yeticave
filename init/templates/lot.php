<main>
      <?=$categories_temp;?>
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
        <?php if(isset($new_bet['notallowed'])): ?>
          <p><?= $new_bet['notallowed']; ?></p>
  
        <?php else: ?>
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
                Мин. ставка <span><?= price_format($lot['min_bet']);?> </span>
              </div>
            </div>
            <form class="lot-item__form" action="lot.php?lot_id=<?= $lot['lot_id']; ?>" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item <?= isset($new_bet['error'])?"form__item--invalid":""; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= $lot['min_bet']; ?>" value="<?= isset($new_bet['error'])?$new_bet['cost']:"" ?>">
                <span class="form__error"><?= isset($new_bet['error'])?$new_bet['error']:""; ?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
        <?php endif; ?>
          <div class="history">
            <h3>История ставок <?= isset($bets)>0?"(<span>".count($bets)."</span>)":"";?></h3>
            <?php if(isset($bets)): ?>
            <table class="history__list">
              <?php foreach ($bets as $bet):?>
              <tr class="history__item">
                <td class="history__name"><?= $bet['name'];?></td>
                <td class="history__price"><?= price_format($bet['price']);?></td>

                <?php 
                $time = time_ago_text($bet['bet_date']);
                ?>
                <td class="history__time"><?= $time;?></td>
              </tr>
            <?php endforeach; ?>
            </table>
            <?php else: ?>
            <p>Ставок нет</p>
            <?php  endif;?>
          </div>
        </div>
      </div>
    </section>
  </main>