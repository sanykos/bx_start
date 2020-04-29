<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<section class="account-section">
	<div class="w-100">
		<div class="row">
			<div class="account-menu col-12 col-md-4 col-lg-3">
				<?php echo file_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/sect_sidebar.php')?>
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<h5 class="section-title section-title-h5">Все отзывы</h5>
				<section class="reviews-content__empty mb-4">
					<div class="card bg-gray border-0 p-4 border-radius">
						<h6 class="section-title section-title-h6 pt-2 px-2">У вас еще нет отзывов</h5>
						<p class="text-gray px-2 mb-4">Исправьте это: перейдите в историю заказов и выберите товары, которые вы уже успели попробовать. Ваши отзывы помогут другим сделать правильный выбор.</p>
						<a class="btn btn-secondary orange-gradient border-0 py-0" href="">История заказов</a>
					</div>
				</section>
				<div class="card-detail__reviews">
					<section class="reviews-content text-gray mb-4">
						<div class="reviews-content__sort">
							<form action="" class="form-reviews__sort">
								<p>
									<select name="" id="">
										<option selected value="Самые последние">Самые последние</option>
										<option value="Самые первые">Самые первые</option>
										<option value="По количеству звезд">По количеству звезд</option>
									</select>
								</p>
							</form>
						</div>
						<div class="reviews-list">
							<section class="reviews-item">
								<div class="reviews-item__header">
									<a href="" class="reviews-author">
										<div class="reviews-author-img" style="background-image: url('http://agrolavka-shop.ru/local/templates/agrolavka/components/bitrix/catalog.element/.default/img/nophoto.svg')">

										</div>
										<div class="reviews-author-title">
											<div class="reviews-author__name"><strong>Иванов Иван</strong> 
										</div>  
									</div>
									</a>
									<div class="reviews-author__date">Вчера, 11:33</div>
								</div>
								<div class="reviews-stars__average">
									<div class="products-rating-stars">
										<div class="stars-div" title="Оценка 4 из 5">
											<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"></path></svg>
											<div class="stars-div-stat green-gradient" style="width:80%">4 из 5</div>
										</div>
									</div>
								</div>
								<div class="reviews-item__content">
									<p>Необходимость в приобретении инкубатора возникла у меня при увеличении заказов на утят мускусных уток. Четыре года назад я коренным образом изменил свой подход к птицеводству. Гуси, куры, пекинские утки, фазаны, цесарки - все осталось в прошлом по разным причинам.</p>
								</div>
								<div class="reviews-item__footer">
									<a href="" class="reviews-reply">Ответить</a>
									<div class="reviews-item__likes-dislikes d-flex align-items-center">
										<span class="text-mute">Отзыв полезен ?</span>
										<a href="#" title="Понравилось" class="d-flex align-items-center">
										<svg version="1.1" id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><path d="M17.39,8h-5.2C12.09,8,12,7.91,12,7.81V2c0-0.55-0.45-1-1-1C7,1,6,13,6,15.59v0.06C6,17.5,7.5,19,9.35,19h4.43c3.44,0,6.23-2.79,6.23-6.23v-2.16C20,9.17,18.83,8,17.39,8z M19,12.77c0,2.89-2.34,5.23-5.23,5.23H9.35C8.05,18,7,16.95,7,15.65C7,13.69,8,3,10.53,2.19C10.76,2.12,11,2.18,11,2.42l0,5.81C11,8.66,11.34,9,11.77,9h5.62C18.28,9,19,9.72,19,10.61V12.77z"/><path d="M4,8H3.49C1.57,8,0,9.57,0,11.49v4.01C0,17.43,1.57,19,3.49,19H4c0.55,0,1-0.45,1-1V9C5,8.45,4.55,8,4,8z M4,17.49C4,17.77,3.77,18,3.49,18C2.12,18,1,16.88,1,15.51v-4.01C1,10.12,2.12,9,3.49,9C3.77,9,4,9.23,4,9.51V17.49z"/></svg>
											<span class="likes__counter">12</span>
										</a>
										<a href="" title="Не понравилось">
										<svg version="1.1" id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><path d="M2.61,12h5.2C7.91,12,8,12.09,8,12.19V18c0,0.55,0.45,1,1,1c4,0,5-12,5-14.59V4.35C14,2.5,12.5,1,10.65,1H6.23C2.79,1,0,3.79,0,7.23v2.16C0,10.83,1.17,12,2.61,12z M1,7.23C1,4.34,3.34,2,6.23,2h4.43C11.95,2,13,3.05,13,4.35C13,6.31,12,17,9.47,17.81C9.24,17.88,9,17.82,9,17.58l0-5.81C9,11.34,8.66,11,8.23,11H2.61C1.72,11,1,10.28,1,9.39V7.23z"/><path d="M16,12h0.51C18.43,12,20,10.43,20,8.51V4.49C20,2.57,18.43,1,16.51,1H16c-0.55,0-1,0.45-1,1v9C15,11.55,15.45,12,16,12z M16,2.51C16,2.23,16.23,2,16.51,2C17.88,2,19,3.12,19,4.49v4.01C19,9.88,17.88,11,16.51,11C16.23,11,16,10.77,16,10.49V2.51z"/></svg>
											<span class="dislikes__counter">2</span>
										</a>
									</div>
								</div>
							</section>
						</div>
						<nav class="reviews__nav">
							<a href="#" title="Показать больше отзывов" class="reviews-show-more">Показать больше отзывов</a>
						</nav>    
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<?/*<section class="recent-products-section">
	<h4 class="section-title section-title-h5">Вы смотрели</h4>
	<div class="recent-products">
		<?php for($i=0;$i<8;$i++):?>
		<div class="item">
			<div class="recent-products-div">
				<div class="recent-products-img-div d-flex align-items-center justify-content-center">
					<a href="#">
						<img src="http://agrolavka-shop.ru/images/00.jpg">
					</a>
				</div>
			</div>
		</div>
		<?php endfor?>
	</div>
</section>*/?>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>