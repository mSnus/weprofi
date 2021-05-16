<form method="post" action="{{ url('store-offer') }}">
            <!-- CROSS Site Request Forgery Protection -->
            @csrf
	<ul>
		<div class="form-group">
			<label>Короткое описание: что случилось, какая машина?</label>
			<input type="text" class="form-control" name="title" id="title" value="Каропка йок">
		</div>
		<div class="form-group">
			<label>Полное описание: что нужно починить?</label>
			<textarea class="form-control" name="descr" id="descr" rows="4">Машина совсем сломалась</textarea>
		</div>
		<div class="form-group">
			<label>Где вы?</label>
			<input type="text" class="form-control" name="location" id="location">
		</div>
		<div class="form-group">
			<label>Как вас зовут?</label>
			<input type="text" class="form-control" name="name" id="name">
		</div>
		<div class="form-group">
			<label>Контактный телефон</label>
			<input type="text" class="form-control" name="phone" id="phone">
		</div>
		<div class="form-group">
			<label>Email:</label>
			<input type="text" class="form-control" name="email" id="email">
		</div>
		<!--
		<div class="form-group">
			<label>Price</label>
			<input type="text" class="form-control" name="price" id="price">
		</div>
		<div class="form-group">
			<label>Client</label>
			<input type="text" class="form-control" name="client" id="client">
		</div>
		<div class="form-group">
			<label>Master</label>
			<input type="text" class="form-control" name="master" id="master">
		</div>
		<div class="form-group">
			<label>Status</label>
			<input type="text" class="form-control" name="status" id="status">
		</div>
		<div class="form-group">
			<label>Created</label>
			<input type="text" class="form-control" name="created" id="created">
		</div>
		<div class="form-group">
			<label>Accepted</label>
			<input type="text" class="form-control" name="accepted" id="accepted">
		</div>
		<div class="form-group">
			<label>Finished</label>
			<input type="text" class="form-control" name="finished" id="finished">
		</div>
		-->
		<div class="form-group">
			<input type="submit" name="send" value="Отправить заявку" class="btn btn-dark btn-block">
		</div>
	</ul>
</form>
