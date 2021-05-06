<script src="<?php echo e(asset('js/suggestions.js')); ?>"></script>
<div class="d-flex justify-content-center">
				<?php if(isset($mode) && $mode == 'edit'): ?>
				<h3>Редактирование заявки:</h3>
				<?php else: ?>

				<?php endif; ?>

</div>

<div class="d-flex justify-content-center section-requests">

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


			 <div class="h1">Мы - профи. Кто вам нужен?</div>
			 <div class="subhead">начните печатать, а мы попробуем угадать и подсказать</div>

			 <?php
				$specs = App\Models\Spec::get()->all(); 
			 ?>
			 <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				 <div class="spec"><?php echo e($spec->title); ?> </div>
			 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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
				<div class="hint" data-realvalue="Домашний ремонт / сантехника">Домашний ремонт / сантехника</div>
				<div class="hint" data-realvalue="Ремонт авто">Ремонт авто</div>
				<div class="hint" data-realvalue="Красота и здоровье">Красота и здоровье</div>
				<div class="hint" data-realvalue="Перевод">Перевод</div>
				<div class="hint" data-realvalue="Няни / сиделки">Няни / сиделки</div>
				<div class="hint" data-realvalue="Репетитор">Репетитор</div>
				<div class="hint" data-realvalue="Нотариус">Нотариус</div>
				<div class="hint" data-realvalue="Маклер">Маклер</div>
				<div class="hint" data-realvalue="Страховка">Страховка</div>
				<div class="hint" data-realvalue="Ремонт компьютеров и телефонов">Ремонт компьютеров и телефонов</div>
				<div class="hint" data-realvalue="Уборка">Уборка</div>
				<div class="hint" data-realvalue="Доставка">Доставка</div>
				<div class="hint" data-realvalue="Разнорабочие">Разнорабочие</div>
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

			 <div class="map-container">
				<h3>Где вы находитесь?</h3>
				<div class="subhead">поставьте точку на карте</div>
				 <?php echo $__env->make('mapbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
		</form>
  </div>
</div>

<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/requests.blade.php ENDPATH**/ ?>