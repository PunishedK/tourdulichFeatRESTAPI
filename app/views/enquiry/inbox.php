<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GoTravel | Hộp thư liên hệ</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<?php include ROOT . "/includes/header.php"; ?>
<main class="page">
	<div class="container">
		<section class="page-head">
			<h1>Hộp thư liên hệ</h1>
			<p>Các tin nhắn bạn đã gửi và phản hồi từ GoTravel (theo email đăng nhập).</p>
		</section>
		<?php if (!empty($error)) { ?><div class="alert error"><?php echo htmlentities($error); ?></div><?php } ?>
		<?php if (!empty($msg)) { ?><div class="alert success"><?php echo htmlentities($msg); ?></div><?php } ?>

		<p style="margin-bottom:1rem;"><a class="btn btn-ghost" href="<?php echo BASE_URL; ?>enquiry">← Gửi tin nhắn mới</a></p>

		<?php if (empty($items) || count($items) === 0): ?>
			<div class="empty-state card">Bạn chưa gửi tin nhắn nào. <a href="<?php echo BASE_URL; ?>enquiry">Gửi tin nhắn đầu tiên</a></div>
		<?php else: ?>
			<ul class="enquiry-inbox-list">
				<?php foreach ($items as $row): ?>
					<li class="card enquiry-thread">
						<div class="enquiry-thread__meta">
							<strong><?php echo htmlentities($row->Subject); ?></strong>
							<span class="muted"><?php echo htmlentities(date('d/m/Y H:i', strtotime($row->PostingDate))); ?></span>
						</div>
						<div class="enquiry-thread__msg">
							<span class="enquiry-thread__label">Bạn đã gửi</span>
							<p><?php echo nl2br(htmlentities($row->Description, ENT_QUOTES, 'UTF-8')); ?></p>
						</div>
						<?php if (!empty($row->AdminReply)): ?>
							<div class="enquiry-thread__reply">
								<span class="enquiry-thread__label">Phản hồi từ GoTravel<?php if (!empty($row->ReplyDate)): ?> · <?php echo htmlentities(date('d/m/Y H:i', strtotime($row->ReplyDate))); ?><?php endif; ?></span>
								<p><?php echo nl2br(htmlentities($row->AdminReply, ENT_QUOTES, 'UTF-8')); ?></p>
							</div>
						<?php else: ?>
							<p class="enquiry-thread__pending muted"><i class="fas fa-clock"></i> Chưa có phản hồi — chúng tôi sẽ trả lời sớm.</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</main>
<?php include ROOT . "/includes/footer.php"; ?>
<?php include ROOT . "/includes/signup.php"; ?>
<?php include ROOT . "/includes/signin.php"; ?>
<?php include ROOT . "/includes/write-us.php"; ?>
</body>
</html>
