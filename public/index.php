<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Simple Blog';
$main_posts = $conn->query("SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id ORDER BY COALESCE(p.updated_at, p.created_at) DESC;");
$main_posts = $main_posts->fetchAll(PDO::FETCH_OBJ);

include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/home/header.php';
include_once TEMPLATES . '/layout/main.php';
include_once TEMPLATES . '/home/homeMain.php';
include_once TEMPLATES . '/layout/footer.php';
?>