<form action="" method="post" action="{{ route('feedback.store') }}">
            <!-- CROSS Site Request Forgery Protection -->
            @csrf
	<ul>
		<div class="form-group">
			<label>Descr</label>
			<textarea class="form-control" name="descr" id="descr" rows="4"></textarea>
		</div>
		<div class="form-group">
			<label>Status</label>
			<input type="text" class="form-control" name="status" id="status">
		</div>
		<div class="form-group">
			<label>Request</label>
			<input type="text" class="form-control" name="request" id="request">
		</div>
		<div class="form-group">
			<label>Type</label>
			<input type="text" class="form-control" name="type" id="type">
		</div>
		<div class="form-group">
			<label>Score</label>
			<input type="text" class="form-control" name="score" id="score">
		</div>
		<div class="form-group">
			<label>Master</label>
			<input type="text" class="form-control" name="master" id="master">
		</div>
		<div class="form-group">
			<label>Client</label>
			<input type="text" class="form-control" name="client" id="client">
		</div>
		<div class="form-group">
			<input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
		</div>
	</ul>
</form>