
<?php if($_SESSION['id'])
{ ?><div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px; color:#fff">Портал общежития НГУ</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Аккаунт <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="my-profile.php">Мой Аккаунт</a></li>
					<li><a href="logout.php">Выйти</a></li>
				</ul>
			</li>
		</ul>
	</div>

<?php
} else { ?>
<div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px;">Портал общежития НГУ</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		
	</div>
	<?php } ?>