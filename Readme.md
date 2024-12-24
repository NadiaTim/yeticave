# Личный проект «{{Yeticave}}»

* Студент: [{{Надежда Тимакова}}]({{id2375083}}).
* Наставник: `Нет`.

---
### Статусы выполнения задания

#### 2. Из чего состоит язык

##### hw2.5 Итерация по массивам

На площадке YetiCave пользователи публикуют объявления о продаже самых разных видов горнолыжного снаряжения: крепления, одежда, доски и многое другое. Чтобы облегчить покупателю поиск нужной ему вещи, каждое объявление назначается одной из существующих категорий.

Вам следует вывести в HTML-коде список из существующих категорий, а также показать сами объявления.

##### hw2.6 Пишем первую функцию

Все товары на сайте YetiCave продаются по принципу аукциона. Владелец вещи указывает только минимальную цену, а затем заинтересованные покупатели делают свои ставки. Автор самой последней ставки на момент окончания аукциона становится победителем и получает право купить товар из лота по этой цене.

В нижней части карточки объявления указана начальная цена лота, заданная его автором. Для удобства пользователя эта цена выводится в формате с делением на разряды и добавлением знака рубля.

Карточка объявления на сайте показывается в двух местах: список объявлений (на главной странице) и на странице просмотра объявления.

#### 3. Из верстки в шаблоны

##### hw3.6 Шаблонизация проекта

Шаблонизация — это преобразование HTML-верстки страниц в специально подготовленные шаблоны.

Шаблон — это PHP-сценарий, который содержит только HTML-код с включениями PHP-переменных и простыми условными конструкциями.

Шаблоны нужны для двух целей:

избавиться от дублирования HTML-кода на разных страницах;
отделить бизнес-логику веб-сайта от его представления.
Большинство веб-сайтов состоят из блоков, которые повторяются на каждой странице: шапка, подвал, боковое меню и т. д. Чтобы не дублировать HTML-код этих блоков на каждой странице, имеет смысл выделить каждый такой блок в отдельный файл-шаблон. Так мы сможем редактировать содержимое шаблона в одном месте, а его обновленный контент будет показан на всех страницах, которые его включают.

Бизнес-логикой в программировании называют программный код, который отвечает за обработку данных, но не за их представление. Работа с данными массивов, подсчет дат, обработка форм — это примеры бизнес-логики сайта. Включение PHP-переменных в HTML-коде, форматирование строк — это примеры представления.

Шаблоны помогают отделить бизнес-логику от представления, что упрощает поддержку кода, делает его более легким для чтения. Теперь работа с данными происходит в одном месте, а их показ — в другом. В этом задании вы перенесете HTML-код страниц в PHP-шаблоны

---

<a href="https://htmlacademy.ru/intensive/php"><img align="left" width="50" height="50" alt="HTML Academy" src="https://up.htmlacademy.ru/static/img/intensive/php/logo-for-github-2.png"></a>

Репозиторий создан для обучения на профессиональном онлайн‑курсе «[PHP, уровень 1](https://htmlacademy.ru/intensive/php)» от [HTML Academy](https://htmlacademy.ru).
