<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý Bài Viết</h1>
	</div>
	<div class="content-header-right">
		<a href="post-add.php" class="btn btn-primary btn-sm">Thêm Bài Viết</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Tiêu đề</th>
								<th>Slug</th>
								<th>Ngày đăng</th>
								<th>Ảnh</th>
								<th>Lượt xem</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("
								SELECT * FROM tbl_post
							");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);

							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo htmlspecialchars($row['post_title']); ?></td>
									<td><?php echo htmlspecialchars($row['post_slug']); ?></td>
									<td><?php echo date('d-m-Y', strtotime($row['post_date'])); ?></td>
									<td>
										<?php if($row['photo']): ?>
											<img src="uploads/<?php echo $row['photo']; ?>" alt="Ảnh" style="width:50px;">
										<?php else: ?>
											<span>Không có ảnh</span>
										<?php endif; ?>
									</td>
									<td><?php echo $row['total_view']; ?></td>
									<td>
										<a href="post-edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Sửa</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="post-delete.php?id=<?php echo $row['post_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Xóa</a>
									</td>
								</tr>
								<?php
							}
							?>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa bài viết này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <a class="btn btn-danger btn-ok">Xóa</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?> 