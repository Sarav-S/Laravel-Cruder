@extends('layouts.admin')

@section('title', $module.' Management')

@section('content')

	@include('partials.notifications')

	@if ($model->canAdd())
		@include('admin.add', [
			'url' => route($route.'create')
		])
	@endif
	@if (count($records))
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					@foreach ($records->first()->columns as $key => $column)
						<th>{{ $column['name'] }}</th>
					@endforeach
					@if ($model->canEdit() || $model->canDelete() || $record->canShow())
					<th>Action</th>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($records as $record)
				<tr>
					@foreach ($records->first()->columns as $key => $column)
						<td>{!! renderField($record, $column) !!}</td>
					@endforeach

					@if ($record->canEdit() || $record->canDelete() || $record->canShow())
					<td>
						@if ($record->canShow())
							@include('admin.show', [
								'url' => route($route.'show', $record->id)
							])
						@endif
						@if ($record->canEdit())
							@include('admin.edit', [
								'url' => route($route.'edit', $record->id)
							])
						@endif
						@if ($record->canDelete())
							@include('admin.delete', [
								'url' => route($route.'destroy', $record->id)
							])
						@endif
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@if (method_exists($records, "links"))
	<div class="text-center">
		{!! $records->links() !!}
	</div>
	@endif
	@else
		<p class="alert alert-info text-center">No records found</p>
	@endif
@endsection