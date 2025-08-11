@extends('layouts.basic')

@section('content')

<div class="min-h-screen flex justify-center items-center flex-col">
    <h1 class="text-3xl font-semibold">Search Quotation</h1>
    <form class="bg-base-100 shadow-md rounded-lg p-6 w-full max-w-md space-y-2" id="public-quo-form">
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Unique Id </legend>
            <input type="text" class="input w-full" name="uniqueId" id="uniqueId" required placeholder="UUID" />
        </fieldset>
        <button class="btn w-full">
            Submit
        </button>

        <ul id="specificQuotation"></ul>
    </form>

    @if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</div>
<script>
    // quotation search form handling
    document.getElementById('public-quo-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const uniqueId = document.getElementById('uniqueId').value;

        fetch(`/api/quotations/public/${uniqueId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                console.log(data);

                const specificQuotation = document.getElementById('specificQuotation');

                specificQuotation.innerHTML = `
                    <li><strong>Quotation Unique Id: </strong> ${data.uniqueId}</li>
                    <li><strong>Price Per Customer: </strong> ${data.price_per_person}</li>
                    <li><strong>Title: </strong> ${data.title}</li>
                    <li><strong>Notes: </strong> ${data.notes || 'No Notes'}</li>
                    <li><strong>Final: </strong> ${data.is_final}</li>
                    <li><strong>Currency: </strong> ${data.currency}</li>
                    <li><strong>Created At: </strong> ${new Date(data.created_at).toDateString()}</li>
                    <li><strong>Updated At: </strong> ${new Date(data.updated_at).toDateString()}</li>
                `;

                console.log(data);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch quotation.');
            });
    });
</script>
@endsection
