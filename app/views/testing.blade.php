@foreach($filters as $filter)

<strong>{{$filter->label}} </strong><br><br>	
	@foreach($filter->{'dimension-class'} as $class)
		{{$class->label}} <br>
	@endforeach
	<hr>
@endforeach