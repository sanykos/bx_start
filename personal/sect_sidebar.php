<?global $USER;?>

<div class="mb-5">
					<dl>
						<dt class="mb-4"><h5 class="section-title section-title-h5">Профиль</h5></dt>
						<dd class="mb-3"><a href="/personal/">Личная информация</a></dd>
						<!-- <dd class="mb-3"><a href="#">Бонусы</a></dd> -->
						<!-- <dd class="mb-3"><a href="/personal/subscribes/">Подписка</a></dd> -->
					</dl>
				</div>
				<div class="mb-5">
					<dl>
						<dt class="mb-4"><h5 class="section-title section-title-h5">Заказы</h5></dt>
						<dd class="mb-3"><a href="/personal/cart/">Корзина</a></dd>
						<dd class="mb-3"><a href="/personal/comincdelivery/">Ближайшие доставки</a></dd>
						<dd class="mb-3"><a href="/personal/history/?filter_history=Y">История заказов</a></dd>
						<dd class="mb-3"><a href="/personal/kuplennye-tovary/">Купленные товары</a></dd>
					</dl>
				</div>
				<div class="mb-5">
					<dl>
						<dt class="mb-4"><h5 class="section-title section-title-h5">Товары и бренды</h5></dt>
						<dd class="mb-3"><a href="/personal/favorites/">Избранные товары</a></dd>
						<dd class="mb-3"><a href="/personal/brands/">Любимые бренды</a></dd>
					</dl>
				</div>
				<div class="mb-5">
					<dl>
						<dt class="mb-4"><h5 class="section-title section-title-h5">Отзывы и вопросы</h5></dt>
						<dd class="mb-3"><a href="/personal/questions/">Заданные вопросы</a></dd>
						<dd class="mb-3"><a href="/personal/feedbacks/">Все отзывы</a></dd>
					</dl>
				</div>
				<?//if($USER->IsAuthorized()):?>
				<div class="mb-5">
					<dl>
						<dd class="mb-3"><a class="text-secondary" href="?logout=yes">Выйти</a></dd>
					</dl>
				</div>
				<?//endif;?>

