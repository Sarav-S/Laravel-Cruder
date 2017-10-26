@include('partials.notifications')
@include('partials.errors')
<div class="form-group">
	{!! Form::label('display_name', 'Name') !!}
	{!! Form::text(
			'display_name', 
			null, 
			[
				'class'    => 'form-control', 
				'id'       => 'display_name',
				'required' => 'required'
			]
		) 
	!!}
</div>
<div class="form-group">
	{!! Form::label('description', 'Description') !!}
	{!! Form::textarea(
			'description', 
			null, 
			[
				'class'    => 'form-control', 
				'id'       => 'description',
				'required' => 'required'
			]
		) 
	!!}
</div>
<?php $i = 0; ?>
<?php $selectedPermissions = (isset($selectedPermissions)) ? $selectedPermissions : []; ?>

@foreach(collect($permissions)->groupBy('display_name') as $title => $groups)
	<div class="panel-default panel">
		<div class="panel-heading">
			<h3>{{ $title }}</h3>
		</div>
		<div class="panel-body">
			@foreach ($groups as $permission)
				<div class="form-group">
					<div class="form-group">
						{!! Form::checkbox(
								'permission_id[]', 
								$permission->id, 
								in_array($permission->id, $selectedPermissions) ? true : false,
								[
									'id' => 'permission_id['.$i.']',	
								]
							) 
						!!}
						{!! Form::label('permission_id['.$i.']', $permission->description) !!}
					</div>
				</div>
				<?php $i++; ?>
			@endforeach
		</div>
	</div>
@endforeach
<div class="form-group">
	{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
</div>