<form action="" method="post" action="{{ route('client.store') }}">
            <!-- CROSS Site Request Forgery Protection -->
            @csrf
	<ul>
		<div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" name="username" id="username">
		</div>
		<div class="form-group">
			<label>Pass</label>
			<input type="text" class="form-control" name="pass" id="pass">
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="text" class="form-control" name="email" id="email">
		</div>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" id="name">
		</div>
		<div class="form-group">
			<label>Phone</label>
			<input type="text" class="form-control" name="phone" id="phone">
		</div>
		<div class="form-group">
			<label>Status</label>
			<input type="text" class="form-control" name="status" id="status">
		</div>
		<div class="form-group">
			<label>Score</label>
			<input type="text" class="form-control" name="score" id="score">
		</div>
		<div class="form-group">
			<input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
		</div>
	</ul>
</form>