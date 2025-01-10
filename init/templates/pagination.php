<?php if ($page_count>1): ?>
    <ul class="pagination-list">
    <?php 
    $url = $_SERVER['REQUEST_URI'];
    $url0 = stristr($url, '&&page', true)?stristr($url, '&&page', true):$url;
    $url0 = stristr($url0, '?page', true)?stristr($url0, '?page', true):$url0;;
    ?>
        <li class="pagination-item pagination-item-prev">
            <a href="<?= str_contains($url0, '?')?$url0."&&page=".$cur_page-1:$url0."?page=".$cur_page-1;?>">Назад</a>
        </li>
        <?php for ($i=1; $i <= $page_count; $i++):
            $url = stristr($url, '&&page', true);
            $url = str_contains($url, '?')?$url."&&page=".$i:$url."?page=".$i; 
        ?>
        <li class="pagination-item <?= $i===$cur_page?"pagination-item-active":""; ?>">
            <a href="<?= $url;?>"><?=$i;?></a>
        </li>
        <?php endfor; ?>
        <li class="pagination-item pagination-item-next">
            <a href="<?= str_contains($url0, '?')?$url0."&&page=".$cur_page+1:$url0."?page=".$cur_page+1;?>">Вперед</a>
        </li>
    </ul>
<?php endif;?>