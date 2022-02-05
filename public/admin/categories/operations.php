<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';

setReferer($_SERVER['HTTP_REFERER']);
$active_category = ['categories' => true];

$operation_type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$operation_type = sanitizeString($operation_type);
$id = sanitizeNumber($id);

if($operation_type === 'edit' && $id){
  try{
    $get_query = 'SELECT * FROM categories WHERE id = ?';
    $stmt = $conn->prepare($get_query);
    $stmt->execute([$id]);
    $category = $stmt->fetchAll(PDO::FETCH_OBJ)[0];

    $category ? '' : throwException('Error');
  }
  catch(Exception $e){
    redirect(url() . '/public/admin/categories');
  }
}

include_once PUBLIC_DIR . '/admin/categories/actions.php';

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/categories/operations.php';
include_once TEMPLATES . '/admin/layout/footer.php';
