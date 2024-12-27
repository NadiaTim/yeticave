<nav class="nav">
  <ul class="nav__list container">
    <?php foreach($categories as $category): ?>
      <li class="nav__item">
        <a href="lots_by_categories.php?category_code=<?=$category['code']; ?>"><?=$category['name']; ?> 
        </a>
      </li>
    <?php endforeach; ?>  
</ul>
</nav>
