@php $editing = isset($club) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-12 col-lg-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $club->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-12 col-lg-12">
        <x-inputs.number
            name="notional_strength"
            label="Notional Strength"
            value="{{ old('notional_strength', ($editing ? $club->notional_strength : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
