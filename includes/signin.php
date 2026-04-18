<div class="modal" id="signin-modal" aria-hidden="true">
	<div class="modal__dialog">
		<button class="modal__close" data-modal-close aria-label="Đóng">&times;</button>
		<h3>Đăng nhập</h3>
		<p class="helper-text">Truy cập để quản lý lịch sử tour và gửi yêu cầu hỗ trợ.</p>
		<form method="post" class="form-stack" action="<?php echo BASE_URL; ?>user/login">
			<div class="form-group">
				<label for="signin-email">Email</label>
				<input type="email" name="email" id="signin-email" placeholder="you@example.com" required>
			</div>
			<div class="form-group">
				<label for="signin-password">Mật khẩu</label>
				<input type="password" name="password" id="signin-password" required>
			</div>
			<div class="form-group" style="margin-top:-0.5rem;">
				<a class="link-muted" href="<?php echo BASE_URL; ?>user/forgot-password">Quên mật khẩu?</a>
			</div>
			<button type="submit" name="signin" class="btn w-100">Đăng nhập</button>
			<p class="helper-text">Bằng việc đăng nhập, bạn đồng ý với <a href="<?php echo BASE_URL; ?>page/terms">Điều khoản</a> và <a href="<?php echo BASE_URL; ?>page/privacy">Chính sách bảo mật</a>.</p>
		</form>
	</div>
</div>