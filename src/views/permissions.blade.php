
<h1>Permissions</h1>
        
{{ Form::open(array('route' => 'user.permissions.save')) }}
        
@foreach($permissionRepository->getPermissions() as $title => $permissions)

<div class="page-header">
	<h2>{{ $title }}</h2>
</div>

<table class="table table-striped">
    
    <thead>
        <tr>            
            <th class="col-lg-6"></th>

            @foreach($groups as $group)

            <th>{{ $group->name }}</th>

            @endforeach
            
        </tr>
    </thead>

    <tbody>

        @foreach($permissions as $permission => $label)

        <tr>

            <td>{{ $label }}</td>

            @foreach($groups as $group)

            <td class="">{{ Form::checkbox($permission . '[]', $group->id, isset($group->permissions[$permission]) && ($group->permissions[$permission] == 1)) }}</td>

            @endforeach

        </tr>

        @endforeach
        
    </tbody>
</table>

<div class="row">
    <div class="col-lg-12">
        {{ Form::button('Save changes', array('type' => 'submit', 'class' => 'btn btn-large btn-primary')) }}
    </div>
</div>
        
@endforeach

{{ Form::close() }}