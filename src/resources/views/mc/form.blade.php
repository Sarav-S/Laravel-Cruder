<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>Laravel - Module Creator</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="/css/admin/admin.css">
</head>
<body>
	<header>
		<div class="container">
			<h1 class="main-logo">
				<a href="">Module Creator</a>
			</h1>
		</div>
	</header>
	<div class="main-wrapper" id="app">
		<div class="container">
			@if (session()->has('success'))
				<p class="alert alert-success">
					{!! session('success') !!}
				</p>
			@endif
			<div class="overflow-hidden  mb-20">
				<a href="{{ route('mc.initialize') }}" class="btn btn-success pull-right">
					Initialize Core Modules
				</a>
			</div>
			<div class="module-wrapper">
				<div class="form-group">
					<label for="module_name">Module Name</label>
					<input type="text" 
					name="module_name" 
					id="module_name" 
					class="form-control"
					v-model="module">
				</div>
				<div class="form-group">
					<button class="btn btn-success" 
					v-on:click="generate">
						Generate
					</button>
				</div>

				

				<form action="{{ route('mc.create.post') }}" 
				method="POST" v-if="routes.length > 0">
					{!! csrf_field() !!}
					<input type="hidden" name="module" :value="module">
					<div class="table-responsive">
						<h3>Select your routes</h3>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="40px">SELECT</th>
									<th>ACTION</th>
									<th>NAME</th>
									<th>Explanation</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="route in routes">
									<td  class="text-center"> 
										<input type="checkbox" 
										name="routes[]"
										:value="route.action" 
										checked="checked">
									</td>
									<td>
										@{{ route.action }}
									</td>
									<td>
										@{{ route.name }}
									</td>
									<td>
										@{{ route.explanation }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<h3>Add Database columns</h3>
						<div class="overflow-hidden mb-20">
							<a href="" class="pull-right btn btn-success" v-on:click="addRow">
								Add Row
							</a>
						</div>
						<table class="table table-bordered add-pad">
							<thead>
								<tr>
									<th>Field</th>
									<th>Data Type</th>
									<th width="30px">Length</th>
									<th width="30px">Default</th>
									<th>Allow Null</th>
									<th>Has Relationship</th>
									<th>Fillable(Model)</th>
									<th>Fillable(Form)</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="n, index in rows">
									<td>
										<input type="text" 
										name="field[]" 
										class="form-control"
										v-model="fields[index]">
									</td>
									<td>
										<select name="datatype[]" class="form-control">
											<option value="increments">INCREMENTS</option>
											<option value="tinyInteger">TINYINT</option>
											<option value="smallInteger">SMALLINIT</option>
											<option value="mediumInteger">MEDIUMINT</option>
											<option value="integer">INTEGER</option>
											<option value="bigInteger">BIGINTEGER</option>
											<option value="float">FLOAT</option>
											<option value="double">DOUBLE</option>
											<option value="decimal">DECIMAL</option>
											<option value="string">VARCHAR</option>
											<option value="text">TEXT</option>
											<option value="mediumText">MEDIUMTEXT</option>
											<option value="longText">LONGTEXT</option>
											<option value="date">DATE</option>
											<option value="dateTime">DATETIME</option>
											<option value="timestamp">TIMESTAMP</option>
											<option value="time">TIME</option>
											<option value="point">POINT</option>
										</select>
									</td>
									<td>
										<input type="text" name="length[]" class="form-control">
									</td>
									<td>
										<input type="text" name="default[]" class="form-control">
									</td>
									<td class="text-center">
										<input type="checkbox" name="allowNull[]" 
										:value="fields[index]">
									</td>
									<td>
										<input type="checkbox" 
										v-on:change="addRelationshipfield(fields[index])"
										:value="fields[index]">
									</td>
									<td>
										<input type="checkbox" name="fillable[]" :value="fields[index]">
									</td>
									<td>
										<input type="checkbox" name="formFillable[]" 
										v-on:change="addFormfield(fields[index])"
										:value="fields[index]">
									</td>
								</tr>
							</tbody>
						</table>
						<div class="form-group">
							<input type="checkbox" name="timestamps" id="timestamps" value="1">
							<label for="timestamps">Include Timestamps</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="softdeletes" id="softdeletes" value="1">
							<label for="softdeletes">Include SoftDeletes</label>
						</div>
					</div>
					
					<div class="table-responsive" v-if="relationshipsFields.length > 0">
						<h3>Map Relationships</h3>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Field</th>
									<th>Model</th>
									<th>Relationship</th>
									<th>Foreign Table Name</th>
									<th>Foreign Key</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="field in relationshipsFields">
									<td>
										<input type="text" 
										name="local_key[]" 
										class="form-control" :value="field" readonly>
									</td>
									<td>
										<select name="model[]" class="form-control">
											@foreach ($list as $model)
											<option value="{{ $model }}">{{ $model }}</option>
											@endforeach
										</select>
									</td>
									<td>
										<select name="relationship[]" class="form-control">
											<option value="hasOne">One To One (hasOne)</option>
											<option value="belongsTo">One To One Inverse (belongsTo)</option>
											<option value="hasMany">One To Many (hasMany)</option>
											<option value="belongsToMany">Many To Many (belongsToMany)</option>
										</select>
									</td>
									<td>
										<input type="text" name="table[]" class="form-control">
									</td>
									<td>
										<input type="text" name="foreign_key[]" class="form-control">
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="table-responsive" v-if="fields.length > 0">
						<h3>Fields Rules</h3>
						<table class="table table-bordered add-pad">
							<thead>
								<tr>
									<th>Field</th>
									<th>Rules : Creating</th>
									<th>Rules : Updating</th>
									<th>Show on Admin Listing</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="field in fields">
									<td>
										@{{ field }}
									</td>
									<td>
										<input type="text" :name="fieldName(field, 'create')" class="form-control">
									</td>
									<td>
										<input type="text" :name="fieldName(field, 'update')" class="form-control">
									</td>
									<td>
										<input type="checkbox" :name="fieldName(field, 'show')" value="1">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					 
					<div class="table-responsive" v-if="formFields.length > 0">
						<h3>Fields Input Type</h3>
						<table class="table table-bordered add-pad">
							<thead>
								<tr>
									<th>Field</th>
									<th>Display Name</th>
									<th>Input Type</th>
									<th>Required</th>
									<th>Has Relationship</th>
									<th>Models</th>
									<th>Field to pluck</th>
									<th>Help Block</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="field, index in formFields">
									<td>
										@{{ field }}
										<input type="hidden" name="formFields[]" :value="field">
									</td>
									<td>
										<input type="text" name="display_name[]" class="form-control">
									</td>
									<td>
										<select name="inputs[]" id="inputs" class="form-control">
											<option value="text">Text</option>
											<option value="textarea">Textarea</option>
											<option value="file">File</option>
											<option value="select">Select</option>
											<option value="checkbox">Checkbox</option>
											<option value="radio">Radio</option>
										</select>
									</td>
									<td>
										<input type="checkbox" name="requiredField[]" :value="field">
									</td>
									<td>
										<input type="checkbox" name="hasFieldRelationship[]" :value="field">
									</td>
									<td>
										<select name="modelFields[]" class="form-control">
											@foreach ($list as $model)
											<option value="{{ $model }}">{{ $model }}</option>
											@endforeach
										</select>
									</td>
									<td>
										<input type="text" name="pluckKey[]" class="form-control">
									</td>
									<td>
										<input type="text" name="helpBlock[]" class="form-control">
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="form-group">
						<button class="btn btn-success">
							<span>Generate Module</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/vue@2.3.3"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.js"></script>
	<script src="{{ asset('js/admin/mc.vue.js') }}"></script>
</body>
</html>