@extends('layouts.basic')

@section('content')

<div class="min-h-screen flex justify-center items-center flex-col">
    <h1 class="text-3xl font-semibold">Create a new Enquiry</h1>
    <form class="bg-base-100 shadow-md rounded-lg p-6 w-full max-w-md space-y-2" method="POST" action="{{ route('enquiries.store') }}">
        @csrf
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Name <span class="text-[red]">*</span></legend>
            <input type="text" class="input w-full" name="name" required autocomplete="name" placeholder="John Doe" />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Email <span class="text-[red]">*</span></legend>
            <input type="email" class="input w-full" name="email" required autocomplete="username" placeholder="example@mail.com" />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Start Date <span class="text-[red]">*</span></legend>
            <input type="date" class="input w-full" name="travel_start_date" required />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">End Date <span class="text-[red]">*</span></legend>
            <input type="date" class="input w-full" name="travel_end_date" required />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Number of People <span class="text-[red]">*</span></legend>
            <input type="number" class="input w-full" min="1" value="1" name="number_of_people" required />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Budget <span class="text-[red]">*</span></legend>
            <input type="number" class="input w-full" min="1" value="1" name="budget" required />
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Preferred Destinations <span class="text-[red]">*</span></legend>
            <select class="select h-[80px] p-2 w-full" name="preferred_destinations[]" multiple>
                <option value="sigiriya">Sigiriya</option>
                <option value="mihintale">Mihintale</option>
                <option value="deegawapiya">Deegawapiya</option>
            </select>
        </fieldset>
        <button class="btn w-full">
            Submit
        </button>
    </form>

    @if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</div>

@endsection
