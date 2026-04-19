<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
	exit;
}

$error = '';
$msg = isset($_GET['msg']) ? trim($_GET['msg']) : '';
$detail = null;
$viewId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (isset($_POST['submit_reply']) && $viewId > 0) {
	$reply = trim($_POST['admin_reply'] ?? '');
	if ($reply === '') {
		$error = 'Vui lòng nhập nội dung phản hồi.';
	} else {
		try {
			$sql = 'UPDATE tblenquiry SET AdminReply = :reply, ReplyDate = NOW(), Status = 1 WHERE id = :id';
			$query = $dbh->prepare($sql);
			$query->bindParam(':reply', $reply, PDO::PARAM_STR);
			$query->bindParam(':id', $viewId, PDO::PARAM_INT);
			if ($query->execute()) {
				header('Location: ' . BASE_URL . 'admin/manage-enquires.php?msg=' . rawurlencode('Đã lưu phản hồi cho khách hàng.'));
				exit;
			}
		} catch (PDOException $e) {
			$error = 'Không lưu được. Chạy file database_patch_enquiry_reply.sql để thêm cột AdminReply và ReplyDate.';
		}
	}
}

if (isset($_GET['del'])) {
	$delid = intval($_GET['del']);
	$sql = 'DELETE FROM tblenquiry WHERE id=:delid';
	$query = $dbh->prepare($sql);
	$query->bindParam(':delid', $delid, PDO::PARAM_INT);
	$query->execute();
	$msg = 'Đã xóa liên hệ';
	if ($viewId === $delid) {
		$viewId = 0;
	}
}

if ($viewId > 0) {
	$q = $dbh->prepare('SELECT * FROM tblenquiry WHERE id = :id LIMIT 1');
	$q->bindParam(':id', $viewId, PDO::PARAM_INT);
	$q->execute();
	$detail = $q->fetch(PDO::FETCH_OBJ);
	if (!$detail) {
		$error = 'Không tìm thấy tin nhắn.';
		$viewId = 0;
	}
}

$pageTitle = 'GoTravel Admin | Liên hệ khách hàng';
$currentPage = 'manage-enquiries';
$sql = 'SELECT * FROM tblenquiry ORDER BY PostingDate DESC';
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
include 'includes/layout-start.php';
?>

<?php if ($viewId > 0 && $detail): ?>
	<section class="admin-page-head">
		<div>
			<h1>Trả lời tin nhắn #<?php echo htmlentities((string) $detail->id); ?></h1>
			<p><a href="<?php echo BASE_URL; ?>admin/manage-enquires.php" class="back-link">← Quay lại danh sách</a></p>
		</div>
	</section>
	<?php if ($error) { ?><div class="alert error"><?php echo htmlentities($error); ?></div><?php } ?>
	<?php if ($msg) { ?><div class="alert success"><?php echo htmlentities($msg); ?></div><?php } ?>

	<section class="card admin-enquiry-detail">
		<dl class="admin-enquiry-dl">
			<dt>Họ tên</dt><dd><?php echo htmlentities($detail->FullName); ?></dd>
			<dt>Email</dt><dd><a href="mailto:<?php echo htmlentities($detail->EmailId); ?>"><?php echo htmlentities($detail->EmailId); ?></a></dd>
			<dt>Số điện thoại</dt><dd><?php echo htmlentities($detail->MobileNumber); ?></dd>
			<dt>Tiêu đề</dt><dd><?php echo htmlentities($detail->Subject); ?></dd>
			<dt>Ngày gửi</dt><dd><?php echo htmlentities($detail->PostingDate); ?></dd>
		</dl>
		<div class="admin-enquiry-box">
			<h3>Tin nhắn từ khách</h3>
			<div class="admin-enquiry-body"><?php echo nl2br(htmlentities($detail->Description, ENT_QUOTES, 'UTF-8')); ?></div>
		</div>
		<?php if (!empty($detail->AdminReply)): ?>
			<div class="admin-enquiry-box admin-enquiry-box--reply">
				<h3>Phản hồi đã gửi <?php if (!empty($detail->ReplyDate)) { ?><span class="muted">(<?php echo htmlentities($detail->ReplyDate); ?>)</span><?php } ?></h3>
				<div class="admin-enquiry-body"><?php echo nl2br(htmlentities($detail->AdminReply, ENT_QUOTES, 'UTF-8')); ?></div>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo BASE_URL; ?>admin/manage-enquires.php?id=<?php echo (int) $detail->id; ?>" class="form-stack" style="margin-top:1.5rem;">
			<h3><?php echo !empty($detail->AdminReply) ? 'Cập nhật phản hồi' : 'Soạn phản hồi cho khách'; ?></h3>
			<div class="form-group">
				<label for="admin_reply">Nội dung phản hồi (khách hiển thị tại Hộp thư)</label>
				<textarea name="admin_reply" id="admin_reply" rows="8" required placeholder="Khách sẽ thấy phản hồi khi đăng nhập cùng email…"><?php echo isset($detail->AdminReply) ? htmlentities($detail->AdminReply, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
			</div>
			<button type="submit" name="submit_reply" class="btn btn-primary">Đăng phản hồi</button>
		</form>
	</section>

<?php else: ?>

	<section class="admin-page-head">
		<div>
			<h1>Liên hệ khách hàng</h1>
			<p>Tin nhắn gửi từ trang &quot;Gửi tin nhắn&quot; — mở từng dòng để trả lời.</p>
		</div>
	</section>
	<?php if ($error) { ?><div class="alert error"><?php echo htmlentities($error); ?></div><?php } ?>
	<?php if ($msg) { ?><div class="alert success"><?php echo htmlentities($msg); ?></div><?php } ?>

	<section class="card">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Họ tên</th>
						<th>Email</th>
						<th>Tiêu đề</th>
						<th>Tin nhắn</th>
						<th>Ngày gửi</th>
						<th>Trạng thái</th>
						<th>Thao tác</th>
					</tr>
				</thead>
				<tbody>
				<?php if (count($results) > 0) { ?>
					<?php foreach ($results as $result) { ?>
					<tr>
						<td>#<?php echo htmlentities((string) $result->id); ?></td>
						<td><?php echo htmlentities($result->FullName); ?></td>
						<td><?php echo htmlentities($result->EmailId); ?></td>
						<td><?php echo htmlentities($result->Subject); ?></td>
						<td class="cell-clip"><?php echo htmlentities(mb_substr($result->Description, 0, 80, 'UTF-8')); ?><?php echo mb_strlen($result->Description, 'UTF-8') > 80 ? '…' : ''; ?></td>
						<td><?php echo htmlentities($result->PostingDate); ?></td>
						<td>
							<?php if (!empty($result->AdminReply)) { ?>
								<span class="status-chip is-approved">Đã trả lời</span>
							<?php } elseif (isset($result->Status) && (int) $result->Status === 1) { ?>
								<span class="status-chip is-approved">Đã xử lý</span>
							<?php } else { ?>
								<span class="status-chip is-pending">Chưa trả lời</span>
							<?php } ?>
						</td>
						<td>
							<a class="btn btn-primary" href="<?php echo BASE_URL; ?>admin/manage-enquires.php?id=<?php echo (int) $result->id; ?>">Trả lời</a>
							<a class="btn btn-ghost" href="<?php echo BASE_URL; ?>admin/manage-enquires.php?del=<?php echo (int) $result->id; ?>" onclick="return confirm('Xóa tin nhắn này?');">Xóa</a>
						</td>
					</tr>
					<?php } ?>
				<?php } else { ?>
					<tr><td colspan="8"><div class="empty-state">Chưa có tin nhắn nào.</div></td></tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</section>
<?php endif; ?>

<?php include 'includes/layout-end.php'; ?>
