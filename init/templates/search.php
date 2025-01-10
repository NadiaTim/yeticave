  <main>
    <?php $categories_temp; ?>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
        <?php if (isset($lots)):?>
        <ul class="lots__list">
          <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot['image'];?>" width="350" height="260" alt="<?=$lot['name'];?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lot['category'];?> </span>
                    <h3 class="lot__title">
                        <a class="text-link" href="lot.php?lot_id=<?=$lot['lot_id']; ?>"><?=$lot['name'];?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=price_format($lot['start_price']); //стартовая цена c форматированием?> </span>
                            <span class="lot__cost"><?=price_format($lot['fin_price']); //текущая цена с форматированием?></span>
                        </div>
                        <?php $restTime=rest_time($lot['finish_date']);?>
                        <div class="lot__timer timer <?=($restTime[0]<1)&&($restTime[1]<1)?"timer--finishing":"";?>">
                            <?="$restTime[0]"."д ". "$restTime[1]:$restTime[2]"?>
                        </div>
                    </div>
                </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?= $pagination; ?>
     <?php else:  ?>
        <h3>По Вашему запросу ничего не найдено</h3>
      </section>
      <?php endif ?>
      
    </div>
  </main>