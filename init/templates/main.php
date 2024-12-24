<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $key => $val): ?>
            <li class="promo__item promo__item--<?= $key; ?>">
                <a class="promo__link" href="pages/<?= $key; ?>.html"><?= $val; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($lots as $key => $value): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$value['url'];?>" width="350" height="260" alt="<?=$value['lot'];?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$value['category'];?> </span>
                    <h3 class="lot__title">
                        <a class="text-link" href="pages/lot.html"><?=$value['lot'];?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=price_format($value['price']); //стартовая цена c ajhvfnbhjdfybtv?> </span>
                            <span class="lot__cost"><?=price_format($value['price']); //текущая цена с форматированием?></span>
                        </div>
                        <div class="lot__timer timer">
                            12:23
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
</main>