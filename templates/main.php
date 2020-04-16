
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($category as $value) : ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= strip_tags($value); ?></a>
            </li>
        <?php endforeach ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($adverts as $key => $value) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= strip_tags($value['url']); ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $value['category']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= strip_tags($value['name']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= price_format($value['price']); ?></span>
                        </div>
                        <!-- Вызов функции по расчету, сколько часов и минут до конца аукциона-->
                          <?php 
                            $auc_end_hr = auction_end($value['expire']);
                            
                            // если осталось меньше часа, то будет выделено красным
                            // добавление блоку класса timer--finishing
                            $timer_finishing = "";
                            if($auc_end_hr[0] < 1) {
                            $timer_finishing = "timer--finishing";
                            }
                          ?>
                        <div class="lot__timer timer <?= $timer_finishing; ?>">
                        <?php echo($auc_end_hr[0].":".$auc_end_hr[1]); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>