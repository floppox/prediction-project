@php $editing = isset($role) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-12 col-lg-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $role->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <div class="form-group col-sm-12 mt-4">
        <h4>Assign Permissions</h4>
    
        @foreach ($permissions as $permission)
        <div>
            <x-inputs.checkbox
                id="permission{{ $permission->id }}"
                name="permissions[]"
                label="{{ ucfirst($permission->name) }}"
                value="{{ $permission->id }}"
                :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
