<?php

session_start();

require_once('settings.php');

$title = "Результаты поиска";

// если пользователь уже залогинен
if (isset($_SESSION['user'])) {
    $user_name = strip_tags($_SESSION['user']['name']);
} else {
    $user_name = "";
}

// получение категорий из БД
$sql_category = "SELECT id, name, code_name FROM category";
$categories = sql_query_result($con, $sql_category);

$lots = [];
$not_found = "";

// если отправлен запрос на поиск
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $search = trim($_GET['search']);

    // извлекаем из URL текущую страницу
    //$page = $_GET['page'];

    // если строка запроса непустая
    if(!empty($search)) {

        //считаем количество записей по запросу
        $sql_count_query = "SELECT COUNT(id) as count FROM lot WHERE MATCH(lot.name, lot.description) AGAINST('%s')";
        $sql_count = sprintf($sql_count_query, $search);
        $result = sql_query_result($con, $sql_count);
        $count = $result[0]['count'];

        // количество лотов на странице
        $num_lot = 9;

        // считаем общее количество страниц
        $pages_total = intval(($count - 1)/$num_lot) + 1;
        //echo $pages_total;

        // определяем начало вывода лотов для текущей страницы
        $page = intval($page);

        // если значени $page меньше 1, переходим на первую страницу выдачи результатов поиска
        // а если слишком большое, на последнюю
        if(empty($page) or $page < 0) {
            $page = 1;
        } elseif ($page > $pages_total) {
            $page = $pages_total;
        }

        // находим, с какого лота выводить на странице результаты
        // offset??? 

        // получение соответствующих лотов из БД
        $sql_format = "SELECT lot.id, lot.name, lot.start_price as price, lot.img_link as url, lot.end_date as expire, category.name as category FROM lot
                    LEFT JOIN category ON lot.categoryID = category.ID WHERE MATCH(lot.name, lot.description) AGAINST('%s') ORDER BY create_date";
        $sql_lots = sprintf($sql_format, $search);
        $lots = sql_query_result($con, $sql_lots);

        // если ничего не найдено
        if (empty($lots)) {
            $content = include_template('not_found.php');
        } else {
            $content = include_template( // показать лоты
                'search_template.php',
                [
                    'lots' => $lots,
                    'categories' => $categories
                ]
            );
        }

    } else { // если пустая
        $content = include_template('not_found.php');
    }   
}

// подключение лейаута и контента 
$layout = include_template(
    'page_layout.php',
    [
        'content' => $content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => $title
    ]
);

print($layout);
