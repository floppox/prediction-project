@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('permissions.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                Show Permission
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>Name</h5>
                    <span>{{ $permission->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>Roles</h5>
                    <div>
                        @forelse ($permission->roles as $role)
                            <div class="badge badge-primary">{{ $role->name }}</div>
                            <br>
                        @empty
                            -
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('permissions.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i> Back to Index
                </a>

                <a href="{{ route('permissions.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> Create
                </a>
            </div>
        </div>
    </div>
</div>
@endsection