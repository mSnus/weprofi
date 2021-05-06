<script src="<?php echo e(asset('js/suggestions.js')); ?>"></script>
<div class="d-flex justify-content-center">
				<?php if(isset($mode) && $mode == 'edit'): ?>
				<h3>Редактирование заявки:</h3>
				<?php else: ?>

				<?php endif; ?>

</div>

<div class="d-flex justify-content-center section-requests">

    <div class="map-container">
		<h3>Где находится машина?</h3>
		<div class="subhead">поставьте точку на карте</div>
		 <?php echo $__env->make('mapbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

	 <div class="newoffer-form mr-0">
		<!-- Validation Errors -->
		<?php if($errors->any()): ?>
			 <div class="alert alert-danger">
				 <ul>
						 <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							 <li><?php echo e($error); ?></li>
						 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				 </ul>
			 </div>
		 <?php endif; ?>

		<form method="post" action="<?php echo e((isset($mode) && $mode == 'edit') ? route('offer.update', $offer_id) : route('offer.store')); ?>" id="formNewOffer" class="form-with-map">
			 <!-- CROSS Site Request Forgery Protection -->
			 <?php echo csrf_field(); ?>
			 <?php if(isset($mode) && $mode == 'edit'): ?>
				 <?php echo method_field('PUT'); ?>
			 <?php endif; ?>

			 <h3>Какая у вас машина?</h3>
			 <div class="subhead">начните вводить марку и модель</div>

			 <div class="mt-4">
				  <?php if (isset($component)) { $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormInput::class, ['type' => 'text','name' => 'title']); ?>
<?php $component->withName('form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','placeholder' => 'Марка и модель','class' => 'block mt-1 w-full predictable','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((isset($mode) && $mode == 'edit') ? $offer_title : old('title')),'required' => true,'autocomplete' => 'off']); ?>
<?php if (isset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4)): ?>
<?php $component = $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4; ?>
<?php unset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
			 </div>

			 <div class="suggestions-list" id="suggestions-title">
			 </div>

			 <div class="hints" data-realtarget="title">
				<div class="hint"data-realvalue="легковая">легковая</div>
				<div class="hint"data-realvalue="грузовая">грузовая</div>
				<div class="hint"data-realvalue="кран">кран</div>
				<div class="hint"data-realvalue="автобус">автобус</div>
				<div class="hint"data-realvalue="минивэн">минивэн</div>
				<div class="hint"data-realvalue="Hyundai Solaris">Hyundai Solaris</div>
				<div class="hint"data-realvalue="Volkswagen Polo">VW Polo</div>
				<div class="hint"data-realvalue="Kia">Kia Magentis</div>
				<div class="hint"data-realvalue="Ford Focus">Ford Focus</div>
				<div class="hint"data-realvalue="Газель тентованная">Газель</div>
				<div class="hint"data-realvalue="Mitsubishi Canter">Mitsu Canter</div>
				<div class="hint"data-realvalue="Mercedes-Benz Sprinter">MB Sprinter</div>
				<div class="hint"data-realvalue="Автобус  Икарус">Икарус</div>
				<div class="hint"data-realvalue="Автобус Neoplan">Neoplan</div>
			 </div>

			 <h3>Что надо починить?</h3>
			 <div class="subhead">начните печатать, а мы попробуем угадать и подсказать</div>

			 <div class="mt-4">
				  <?php if (isset($component)) { $__componentOriginal83693b8429d83ac47ac0f5a27736a9481ab05e28 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormTextarea::class, ['type' => 'text','name' => 'descr']); ?>
<?php $component->withName('form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'descr','class' => 'block mt-1 w-full predictable','required' => true]); ?><?php echo e((isset($mode) && $mode == 'edit') ? $offer_descr : old('descr')); ?> <?php if (isset($__componentOriginal83693b8429d83ac47ac0f5a27736a9481ab05e28)): ?>
<?php $component = $__componentOriginal83693b8429d83ac47ac0f5a27736a9481ab05e28; ?>
<?php unset($__componentOriginal83693b8429d83ac47ac0f5a27736a9481ab05e28); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
			 </div>

			 <div class="suggestions-list" id="suggestions-descr">
			</div>

			 <div class="hints" data-realtarget="descr">
				<div class="hint" data-realvalue="ремень ГРМ">ремень ГРМ</div>
				<div class="hint" data-realvalue="заменить колодки">заменить колодки</div>
				<div class="hint" data-realvalue="прокачать тормоза">прокачать тормоза</div>
				<div class="hint" data-realvalue="починить пробитое колесо">пробитое колесо</div>
				<div class="hint" data-realvalue="грузовой шиномонтаж">грузовой шиномонтаж</div>
				<div class="hint" data-realvalue="нужен эвакуатор">нужен эвакуатор</div>
				<div class="hint" data-realvalue="заменить свечи">заменить свечи</div>
			</div>


			 <div class="mt-4">
				  <?php if (isset($component)) { $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormInput::class, ['type' => 'hidden','name' => 'location']); ?>
<?php $component->withName('form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'location','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('location')),'required' => true]); ?>
<?php if (isset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4)): ?>
<?php $component = $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4; ?>
<?php unset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
			 </div>

			 <?php if(auth()->guard()->guest()): ?>

			 <h3>Как с вами связаться?</h3>
			 <div class="subhead">имя и фамилия, ваш телефон и Телеграм</div>

			 <div class="mt-4">
				  <?php if (isset($component)) { $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormInput::class, ['type' => 'text','name' => 'fullname']); ?>
<?php $component->withName('form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'fullname','placeholder' => 'Как к вам обращаться?','class' => 'block mt-1 w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('fullname')),'autocomplete' => 'name','required' => true]); ?>
<?php if (isset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4)): ?>
<?php $component = $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4; ?>
<?php unset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
			 </div>

			 <div class="mt-4">
				<?php if (isset($component)) { $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormInput::class, ['type' => 'text','name' => 'name']); ?>
<?php $component->withName('form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'name','placeholder' => 'Номер телефона (+7 xxx xxx-xxxx)','class' => 'block mt-1 w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name')),'autocomplete' => 'phone','required' => true]); ?>
<?php if (isset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4)): ?>
<?php $component = $__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4; ?>
<?php unset($__componentOriginalc6dc29918f642c0cf8bf87f6c59d196df1a6e1b4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
		  	</div>

			 <p class="subhead">наш бот пришлёт пароль и известит об откликах Мастеров:</p>
			 <p><a href="https://telegram.me/PochinimOnline_bot?start=welcome"><img src="/img/telegram.png" width="200"></a></p>

			 <?php endif; ?>

			 <div class="d-flex justify-content-end mt-4 align-items-center">
				 <?php if(auth()->guard()->guest()): ?>
				  <a class="pt-3 pr-3" href="<?php echo e(route('login')); ?>">
						<?php echo e(__('Уже зарегистрированы?')); ?>

				  </a>
				  <?php endif; ?>

				   <?php if(isset($mode) && $mode == 'edit'): ?>
				  		<?php if (isset($component)) { $__componentOriginald49072503c687d5977279cc274621cb08ed343b1 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormSubmit::class, []); ?>
<?php $component->withName('form-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'ml-4']); ?>
						 	Сохранить
						 <?php if (isset($__componentOriginald49072503c687d5977279cc274621cb08ed343b1)): ?>
<?php $component = $__componentOriginald49072503c687d5977279cc274621cb08ed343b1; ?>
<?php unset($__componentOriginald49072503c687d5977279cc274621cb08ed343b1); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
					<?php else: ?>
						<img src="/img/big_request.png" onclick="submit();" style="width: 217px; cursor: pointer;">
					 <?php endif; ?>

			 </div>
		</form>
  </div>
</div>

<?php /**PATH /home/admin/web/pochinim.online/public_html/app/resources/views/requests.blade.php ENDPATH**/ ?>