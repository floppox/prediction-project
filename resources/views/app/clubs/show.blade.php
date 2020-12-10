@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('clubs.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                Show Club
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>Name</h5>
                    <span>{{ $club->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Notional Strength</h5>
                    <span>{{ $club->notional_strength ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('clubs.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i> Back to Index
                </a>

                @can('create', App\Models\Club::class)
                <a href="{{ route('clubs.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> Create
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
