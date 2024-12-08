<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $statement = $pdo->prepare("DELETE FROM tbl_posts WHERE id=?");
    $statement->execute([$_GET['id']]);
    header("Location: manage_posts.php");
}
?>
