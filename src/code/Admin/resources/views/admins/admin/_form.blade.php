@include('partials.errors')

<div class="form-group">
	{!! Form::label('name', 'Name') !!}
	{!! Form::text(
			'name', 
			null, 
			[
				'class'    => 'form-control', 
				'id'       => 'name',
				'required' => 'required'
			]
		) 
	!!}
</div>
<div class="form-group">
	{!! Form::label('email', 'E-Mail Address') !!}
	{!! Form::input(
			'email', 
			'email', 
			null, 
			[
				'class'    => 'form-control', 
				'id'       => 'email',
				'required' => 'required'
			]
		) 
	!!}
	<p class="help-block">Email address should be valid and unique one</p>
</div>
<div class="form-group">
	{!! Form::label('password', 'Password') !!}
	{!! Form::input(
			'password', 
			'password', 
			null, 
			[
				'class'    => 'form-control', 
				'id'       => 'password',
			]
		) 
	!!}
	<p class="help-block">Password should be minimum of 8 characters</p>
</div>
<div class="form-group">
	@if (isset($record))
	<a href="{{ asset($record->image) }}" target="_blank" class="block">
		<img src="{{ asset($record->image) }}" alt="{{ admin()->image }}" width="50px">
	</a>
	@endif
	{!! Form::label('image', 'Image') !!}
	{!! Form::file('image') !!}
	<p class="help-block">Please upload valid images</p>
</div>
<?php $selectedRole = (isset($record) && isset($record->roles()->first()->id)) ? $record->roles()->first()->id : null; ?>
<div class="form-group">
	{!! Form::label('role_id', 'Role') !!}
	{!! Form::select(
			'role_id', 
			collect($roles)->pluck('display_name', 'id'),
			$selectedRole, 
			[
				'class'    => 'form-control', 
				'id'       => 'role_id',
				'required' => 'required'
			]
		) 
	!!}
</div>
<div class="form-group">
	{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
</div>