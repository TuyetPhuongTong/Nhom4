<?php
require_once('header.php');

$statement = $pdo->prepare("SELECT * FROM tbl_posts ORDER BY created_at DESC");
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Quản lý bài viết</h1>
<a href="add_post.php" class="btn btn-primary">Thêm bài viết</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['created_at']; ?></td>
                <td>
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>">Chỉnh sửa</a>
                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
