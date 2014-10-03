<?
// --------------------------------------------------------
// --- начало шапки ---------------------------------------

// с такой или подобной шапкой тебе придется начинать каждый файл. раз уж у нас не динамическое ядро
// хотя можно и сделать его динамическим (как у меня в админке (admin/index.php))

include_once('include/config.php');
include_once('include/db_functions.php');
include_once('functions/all_functions.php');

$db = db_connect();

// если будет кнопка выхода из личного кабинета, то она будет называться user-log-out-button
// ее обработчик:
if ($_POST['user-log-out-button'])
    log_out_user();

// соответственно обработчик формы логина. я думаю тут понятно какие должны быть поля у формы
if ($_POST['user-login-button'])
{
    log_in_user($_POST['email'], $_POST['password']);
}

// ...

// по аналогии с тем что выше ты можешь использовать функции типа функций
// восстановления пароля и регистрации. все они лежат в functions/user_functions.php
// посмотри че они принимают и использую по аналогии

// --- конец шапки ----------------------------------------
// --------------------------------------------------------

// далее примеры использования функций в разделах
// функции, назначение которых я не объяснил, должны быть интуитивно понятны для использования

// фунцкия is_admin_logged_in() проверяет залогинен ли юзер


$articles = get_popular_articles(); // для главной
$goods = get_popular_goods(); // для главной


// если не объясняю в каком формате возвращаются данные,
// то это двумерные массивы с полями как в базе
// если что, можешь использовать функцию print_r(массив), чтобы понять че внутри
$slider1 = get_slider_data(1); // слайдер на главной
$slider2 = get_slider_data(2); // слайдер в товарах


// тексты:
$text1 = get_text_data(1); // "О нас"
$text2 = get_text_data(2); // "Контакты"
$text3 = get_text_data(3); // "Доставка". Подробнее смотри в базе и в админке


// для блога:
$writers = get_writers_list(); // список писателей
$writer_data = get_writer_data($writers[0]['id']); // инфо о писателе

$all_articles = get_articles_list(); // интуитивно понятно
$articles_by_writer_id = get_articles_list_by_writer_id($writers[0]['id']);
$article_data = get_article_data($articles_by_writer_id[0]['id']);


// функции для корзины смотри в functions/cart_functions.php там все интуитивно понятно, а где нет - расписано
// для оформления заказа функции находятся в functions/orders_functions.php . там тож все понятно
// аналогично для писем обртной связи functions/feedback_messages_functions.php
// !!!!! не реализовал возмоджность комментировать сам сайт. надо обсудить потом. изи доделать
// !!!!! пока нет поиска...


// товары:
$main_categories = get_main_categories_list(); // см. первые 4 категории в базе - они из тз. почти константы
$subcategories = get_categories_list_by_parent_id($main_categories[0]['id']);
$category_data = get_category_data($subcategories[0]['id']);

$goods_list = get_goods_list_by_category_id($category_data['id']);
$good_data = get_good_data($goods_list[0]['id']);


// --------------------------------------------------------
// --- начало ног -----------------------------------------
exit_index($db);


function exit_index($db)
{
    db_disconnect($db);
    exit();
}
// --- конец ног ------------------------------------------
// --------------------------------------------------------
?>
