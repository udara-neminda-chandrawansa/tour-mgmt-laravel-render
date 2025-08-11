@extends('layouts.basic')

@section('content')

<div class="min-h-screen flex flex-col space-y-4 p-4">
    <h1 class="text-3xl">Welcome to your Dashboard</h1>
    <div id="dashboard-content">Loading...</div>

    <form id="logoutForm">
        <button class="btn">Logout</button>
    </form>

    <!-- tab control -->
    <div id="tabControl" class="tabs tabs-box">
        <!-- enq display tab -->
        <input type="radio" name="my_tabs_1" class="tab" aria-label="View Enquiries" checked="checked" />
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-2xl mb-4">View Enquiries</h2>
            <!--filter section-->
            <form id="filter-enq-form" class="mb-4">
                <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-2">
                    <input type="text" name="search" class="input w-full" placeholder="Search name/email">

                    <select name="status" class="select w-full">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in-progress">In-Progress</option>
                        <option value="converted">Converted</option>
                        <option value="rejected">Rejected</option>
                    </select>

                    <input type="date" name="from" class="input w-full">
                    <input type="date" name="to" class="input w-full">

                    <div id="assigned-to-wrapper" class="w-full"></div>
                </div>

                <div class="pt-4">
                    <button class="btn" type="submit">Apply Filters</button>
                </div>
            </form>
            <!--table-->
            <div class="overflow-x-auto">
                <table id="enquiry-table" class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Number of People</th>
                            <th>Preferred Destinations</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Assigned Agent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="enqPagination" class="flex justify-center items-center space-x-1 mt-4 w-fit"></div>
        </div>

        <!--itineraries tab-->
        <input type="radio" name="my_tabs_1" class="tab" aria-label="View Itineraries" />
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-2xl mb-4">View Itineraries</h2>

            <form id="filter-iti-form" class="mb-4">
                <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-2">
                    <input type="text" name="id" id="iti-id" class="input w-full" placeholder="Search by id">
                    <button class="btn" type="submit">Search</button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enquiry Name</th>
                            <th>Title / Days / Activities</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="itineraries-table-body">

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="itiPagination" class="flex justify-center items-center space-x-1 mt-4 w-fit"></div>
        </div>

        <!--quotations tab-->
        <input type="radio" name="my_tabs_1" class="tab" aria-label="View Quotations" />
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-2xl mb-4">View Quotations</h2>

            <form id="filter-quo-form" class="mb-4">
                <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-2">
                    <input type="text" name="id" id="quo-id" class="input w-full" placeholder="Search by id">
                    <button class="btn" type="submit">Search</button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Unique Id</th>
                            <!--<th>Itinerary Title</th>-->
                            <th>Title</th>
                            <th>Price Per Person</th>
                            <th>Currency</th>
                            <th>Notes</th>
                            <th>Is Final</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="quotations-table-body">

                    </tbody>
                </table>
            </div>
        </div>

        <!--payments tab-->
        <input type="radio" name="my_tabs_1" class="tab" aria-label="View Payments" />
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-2xl mb-4">View Payments</h2>

            <form id="filter-pay-form" class="mb-4">
                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-2">

                    <select name="payment_method" class="select w-full">
                        <option value="">Select a payment method</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="other">Other</option>
                    </select>

                    <input type="date" name="from" class="input w-full">
                    <input type="date" name="to" class="input w-full">

                    <div id="assigned-to-wrapper-pay" class="w-full"></div>

                </div>

                <button class="btn mt-4" type="submit">Apply Filters</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Quotation Title</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Transaction Reference</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody id="payments-table-body">

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="payPagination" class="flex justify-center items-center space-x-1 mt-4 w-fit"></div>
        </div>
    </div>
</div>

<!-- Assign Agent Modal -->
<dialog id="assignAgentModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Assign an agent to this enquiry</h3>
        <div class="pt-4">
            <form id="assignAgentForm" class="space-y-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Select Agent</legend>
                    <select name="select_agent_to_assign" id="select_agent_to_assign" class="select w-full">
                        <option value="">Select an agent</option>
                    </select>
                </fieldset>
                <button type="submit" class="btn">Assign Agent</button>
            </form>
        </div>
    </div>
</dialog>

<!-- Create Itinerary Modal (also used for updating itineraries) -->
<dialog id="createItineraryModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Create an Itinerary to this enquiry</h3>
        <div class="pt-4">
            <form id="createItineraryForm" class="space-y-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Title</legend>
                    <input type="text" name="title" class="input w-full" placeholder="Insert Title" required>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Notes</legend>
                    <input type="text" name="notes" class="input w-full" placeholder="Insert Notes">
                </fieldset>

                <div id="daysContainer"></div>

                <button type="button" id="addDayBtn" class="btn btn-primary mb-0 mr-4">Add Day</button>
                <button type="submit" class="btn btn-success">Create Itinerary</button>
            </form>

        </div>
    </div>
</dialog>

<!-- View Itinerary Modal -->
<dialog id="viewItineraryModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">View Specific Itinerary</h3>
        <div class="pt-4">
            <ul class="space-y-4" id="specificItinerary"></ul>
        </div>
    </div>
</dialog>

<!-- Create Quotation Modal -->
<dialog id="createQuotationModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Create an Quotation to this itinerary</h3>
        <div class="pt-4">
            <form id="createQuotationForm" class="space-y-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Title</legend>
                    <input type="text" name="title" class="input w-full" placeholder="Insert Title" required>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Price Per Person</legend>
                    <input type="number" min="1" name="price_per_person" class="input w-full" required placeholder="Insert Price Per Person">
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Currency</legend>
                    <select name="currency" class="select w-full">
                        <option value="">Select a currency</option>
                        <option value="lkr">LKR</option>
                        <option value="usd">USD</option>
                    </select>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Notes</legend>
                    <input type="text" name="notes" class="input w-full" placeholder="Insert notes">
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Final ?</legend>
                    <input type="checkbox" name="is_final" class="checkbox">
                </fieldset>

                <button type="submit" class="btn btn-success">Create Quotation</button>
            </form>

        </div>
    </div>
</dialog>

<!-- View Quotation Modal -->
<dialog id="viewQuotationModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">View Specific Quotation</h3>
        <div class="pt-4">
            <ul class="space-y-4" id="specificQuotation"></ul>
        </div>
    </div>
</dialog>

<!-- Create payment Modal -->
<dialog id="createPaymentModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Create an Payment to this Quotation</h3>
        <div class="pt-4">
            <form id="createPaymentForm" class="space-y-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Amount</legend>
                    <input type="number" min="1" name="amount" class="input w-full" placeholder="Insert Amount" required>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Payment Method</legend>
                    <select name="payment_method" class="select w-full">
                        <option value="">Select a payment method</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="other">Other</option>
                    </select>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Transaction Reference</legend>
                    <input type="text" name="transaction_reference" class="input w-full" placeholder="Reference" required>
                </fieldset>

                <button type="submit" class="btn btn-success">Create Payment</button>
            </form>
        </div>
    </div>
</dialog>

<!-- js logic -->
<script>
    // 
    // ** global vars **
    //

    // Check if the user is logged in by checking for a token
    const token = localStorage.getItem('api_token');

    // all users
    const users = [];

    // logged in user
    let currentUser = null;

    // pagination vars (enq)
    let currentEnqPage = 1;
    let lastEnqPage = 1;

    // pagination vars (iti)
    let currentItiPage = 1;
    let lastItiPage = 1;

    // pagination vars (pay)
    let currentPayPage = 1;
    let lastPayPage = 1;

    // 
    // ** auth logic **
    //

    if (!token) {
        alert("You're not logged in.");
        window.location.href = '/login';
    }

    // get logged-in user details
    fetch('/api/user', {
            headers: {
                'Authorization': 'Bearer ' + token
                , 'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            currentUser = data;
            //loadEnquiries();

            document.getElementById('dashboard-content').innerHTML = `
                <p>Hello, ${data.name}</p>
                <p>Email: ${data.email}</p>
            `;

            if (data.role === 'admin') {
                // const assignedToSelect = document.getElementById('assigned_to');
                // if (!assignedToSelect) {
                //     alert('assigned_to select not found');
                //     return;
                // }
                document.getElementById('assigned-to-wrapper').innerHTML = `
                    <select name="assigned_to" id="assigned_to" class="select w-full">
                        <option value="">All Agents</option>
                    </select>
                `;
                document.getElementById('assigned-to-wrapper-pay').innerHTML = `
                    <select name="assigned_to" id="assigned_to_pay" class="select w-full">
                        <option value="">All Agents</option>
                    </select>
                `;

                // Now fetch users *after* the select is in the DOM
                loadAllUsers(true);
            } else {
                // load all users for the logged in agent's use (for the equiries table)
                loadAllUsers(false);
            }

            // load enqs /payments after loading user data / all users
            loadEnquiries();
            loadPayments();
        })
        .catch(error => {
            console.error(error);
            alert('Error loading user data.');
            window.location.href = '/login';
        });


    // method to load all users (used to populate agent select tags, "Assigned Agent" column in enq table)
    function loadAllUsers(admin) {
        fetch('/api/users', {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                users.push(...data.users);

                // if the logged in user is admin, populate the agent select tags
                if (admin) {
                    const assignedToSelect = document.getElementById('assigned_to');
                    const assignedToSelectPay = document.getElementById('assigned_to_pay');
                    const selectAgentToAssign = document.getElementById('select_agent_to_assign');
                    if (!assignedToSelect || !selectAgentToAssign || !assignedToSelectPay) {
                        //alert('Select elements missing in DOM');
                        return;
                    }

                    users.forEach(user => {
                        if (user.role === 'agent') {
                            assignedToSelect.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                            selectAgentToAssign.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                            assignedToSelectPay.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                        }
                    });
                }
            })
            .catch(error => {
                console.error(error);
                alert('Error loading users.');
            });
    }

    // logout form handling
    document.getElementById('logoutForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        fetch('/api/auth/logout', {
                method: 'POST'
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(() => {
                alert('Logged out successfully');
                localStorage.removeItem('api_token');
                window.location.href = '/login';
            });
    });

    // 
    // ** filtering / loading enqs logic **
    //

    // global method to filter enquiries
    function filterEnquiries(form, params) {
        if (form.search.value) params.append('search', form.search.value);
        if (form.status.value) params.append('status', form.status.value);
        if (form.from.value) params.append('from', form.from.value);
        if (form.to.value) params.append('to', form.to.value);

        if (currentUser.role === 'agent') {
            params.append('assigned_to', currentUser.id);
        } else {
            if (form.assigned_to.value) params.append('assigned_to', form.assigned_to.value);
        }
    }

    // global method to populate the enquiries table
    function populateEnquiries(data, tbody) {
        data.forEach(enquiry => {
            tbody.innerHTML += `
            <tr>
                <td>${enquiry.name}</td>
                <td>${enquiry.email}</td>
                <td>${enquiry.travel_start_date}</td>
                <td>${enquiry.travel_end_date}</td>
                <td>${enquiry.number_of_people}</td>
                <td>${enquiry.preferred_destinations}</td>
                <td>${enquiry.budget}</td>
                <td>${enquiry.status}</td>
                <td>
                    ${
                        enquiry.assigned_to
                        ? (users.find(user => user.id === enquiry.assigned_to)?.name || 'Unknown')
                        : 'Unassigned'
                    }
                </td>
                <td class="flex flex-wrap gap-2 justify-end">
                    ${
                        currentUser.role === 'admin'
                        ? `<button class="btn btn-sm" onclick="assignAgent(${enquiry.id})">Assign Agent</button>`
                        : ''
                    }
                    ${
                        currentUser.role === 'agent'
                        ? `<button class="btn btn-sm" onclick="createItinerary(${enquiry.id})">Create Itinerary</button>`
                        : ''
                    }
                    <button class="btn btn-sm" onclick="changeStatus(${enquiry.id})">Change Status</button>
                </td>
            </tr>
          `;
        });
    }

    // render pagination for any table that needs
    function renderPagination(containerId, methodName, currentPage, lastPage) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';

        // Prev button
        const prevBtn = `<button ${currentPage === 1 ? 'disabled' : ''} onclick="${methodName}(${currentPage - 1})"
        class="btn ${currentPage === 1 ? 'bg-gray-200' : 'hover:bg-gray-100'}"><i class="bi bi-caret-left-fill"></i></button>`;
        container.innerHTML += prevBtn;

        // Page numbers
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
            container.innerHTML += `<button onclick="${methodName}(${i})"
            class="btn ${i === currentPage ? 'bg-blue-500 text-white' : 'hover:bg-gray-100'}">
            ${i}
        </button>`;
        }

        // Next button
        const nextBtn = `<button ${currentPage === lastPage ? 'disabled' : ''} onclick="${methodName}(${currentPage + 1})"
        class="btn ${currentPage === lastPage ? 'bg-gray-200' : 'hover:bg-gray-100'}"><i class="bi bi-caret-right-fill"></i></button>`;
        container.innerHTML += nextBtn;
    }

    // load enquiries based on user role
    function loadEnquiries(page = 1) {
        let route = '/api/enquiries';

        let form = document.getElementById('filter-enq-form');
        let params = new URLSearchParams();

        filterEnquiries(form, params);

        if (currentUser.role === 'agent') {
            //route += '?assigned_to=' + currentUser.id; // agents only see their own enquiries
        }

        route += '?' + params.toString(); // add other filters

        route += '&page=' + page; // for pagination

        //alert(route);

        fetch(route, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#enquiry-table tbody');
                tbody.innerHTML = '';

                // populate table using global method
                populateEnquiries(data.data, tbody);

                // Pagination log
                console.log('Total pages:', data.last_page);

                // for pagination
                currentEnqPage = data.current_page;
                lastEnqPage = data.last_page;
                renderPagination('enqPagination', 'loadEnquiries', currentEnqPage, lastEnqPage);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch enquiries.');
            });
    }

    // filter enq form handling
    document.getElementById('filter-enq-form').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = e.target;
        let params = new URLSearchParams();

        filterEnquiries(form, params);

        params.append('page', 1); // Always start from page 1 when filtering

        fetch('/api/enquiries?' + params.toString(), {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#enquiry-table tbody');
                tbody.innerHTML = '';

                // populate table using global method
                populateEnquiries(data.data, tbody);

                // for pagination
                currentEnqPage = data.current_page;
                lastEnqPage = data.last_page;
                renderPagination('enqPagination', 'loadEnquiries', currentEnqPage, lastEnqPage);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch enquiries.');
            });
    });

    //
    // ** enq management logic **
    //

    let selectedEnquiryId = null;

    // open assign agent modal
    function assignAgent(enquiryId) {
        selectedEnquiryId = enquiryId;
        assignAgentModal.showModal();
    }

    // change status of an enquiry
    function changeStatus(enquiryId) {
        const newStatus = prompt("Enter new status (pending/in-progress/converted/rejected):");

        if (!newStatus || (newStatus !== 'pending' && newStatus !== 'in-progress' && newStatus !== 'converted' && newStatus !== 'rejected')) {
            alert("Invalid status. Please enter a valid status.");
            return;
        }

        fetch(`/api/enquiries/${enquiryId}/status`, {
                method: 'PATCH'
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                    , 'Content-Type': 'application/json'
                }
                , body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Status updated successfully.");
                    loadEnquiries(currentEnqPage); // Refresh the enquiries list
                } else {
                    alert("Failed to update status: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Failed to change status.');
            });
    }

    // assign agent to an enquiry
    document.getElementById('assignAgentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const selectedAgent = document.getElementById('select_agent_to_assign').value;

        fetch(`/api/enquiries/${selectedEnquiryId}/assign`, {
                method: 'PUT'
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                    , 'Content-Type': 'application/json'
                }
                , body: JSON.stringify({
                    agent_id: selectedAgent
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Agent Assigned successfully.");
                    loadEnquiries(currentEnqPage); // Refresh the enquiries list
                } else {
                    alert("Failed to assign agent: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Failed to assign agent.');
            });
    });


    //
    // ** itinerary logic **
    //

    let selectedItineraryId = null;

    function loadItineraries(page = 1) {
        let route = "/api/itineraries";

        route += '?page=' + page; // for pagination

        fetch(route, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // load data to 'itineraries-table-body'
                const tableBody = document.getElementById('itineraries-table-body');

                tableBody.innerHTML = '';

                data.data.forEach(itinerary => {
                    // Create main itinerary row
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${itinerary.id}</td>
                        <td>${itinerary.enquiry?.name || 'Unknown'}</td>
                        <td>${itinerary.title}</td>
                        <td>${itinerary.notes || ''}</td>
                        <td>${new Date(itinerary.created_at).toDateString()}</td>
                        <td>${new Date(itinerary.updated_at).toDateString()}</td>
                        <td class="flex flex-wrap justify-end gap-2">
                            <button class="btn btn-sm" onclick="createQuotation(${itinerary.id})">Create Quotation</button>
                            <button class="btn btn-sm" onclick="updateItinerary(${itinerary.id})">Update</button>
                            <button class="btn btn-sm btn-error" onclick="deleteItinerary(${itinerary.id})">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(tr);

                    // Create extra rows for each day
                    itinerary.days.forEach(day => {
                        const dayTr = document.createElement('tr');
                        dayTr.innerHTML = `
                            <td colspan="2"></td> <!-- Empty cell to indent -->
                            <td colspan="5">
                                <strong>Day ${day.day} - ${day.location}</strong><br>
                                ${day.activities.map(act => `* ${act}`).join('<br>')}
                            </td>
                        `;
                        tableBody.appendChild(dayTr);
                    });
                });

                //console.log(data.data);

                // for pagination
                currentItiPage = data.current_page;
                lastItiPage = data.last_page;
                renderPagination('itiPagination', 'loadItineraries', currentItiPage, lastItiPage);
            })
            .catch(error => {
                console.error(error);
                alert('Error loading itineraries.');
            });
    }

    // method to reset the itinerary form
    function resetItineraryForm() {
        document.getElementById('createItineraryForm').reset();
        daysContainer.innerHTML = '';
        dayIndex = 0;
        addDayBtn.textContent = "Add Day";
        addDayBtn.disabled = false;
        addDayBtn.click();
    }

    // load once on page load
    loadItineraries();

    // creating itinerary modal open
    function createItinerary(enquiryId) {
        selectedItineraryId = null;
        selectedEnquiryId = enquiryId;
        resetItineraryForm();
        document.getElementById('createItineraryModal').showModal();
    }

    // updating itinerary modal open (same modal as above)
    async function updateItinerary(itineraryId) {
        selectedItineraryId = itineraryId;
        resetItineraryForm();

        // display current data in the modal form fields
        try {
            const res = await fetch(`/api/itineraries/${itineraryId}`, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            });
            const data = await res.json();

            document.querySelector('#createItineraryForm [name="title"]').value = data.title || '';
            document.querySelector('#createItineraryForm [name="notes"]').value = data.notes || '';

            // clr default day
            daysContainer.innerHTML = '';
            dayIndex = 0;

            // add days
            data.days.forEach((day, i) => {
                const dayEntry = createDayEntry(i);
                dayEntry.querySelector('[name^="days"][name$="[day]"]').value = day.day;
                dayEntry.querySelector('[name^="days"][name$="[location]"]').value = day.location;
                dayEntry.querySelector('[name^="days"][name$="[activities]"]').value = day.activities.join(', ');
                daysContainer.appendChild(dayEntry);
                dayIndex++;
            });

            // show modal
            document.getElementById('createItineraryModal').showModal();
        } catch (err) {
            alert('Failed to load itinerary.');
        }
    }

    // Delete Itinerary
    async function deleteItinerary(id) {
        if (!confirm("Are you sure you want to delete this itinerary?")) return;

        try {
            const res = await fetch(`/api/itineraries/${id}`, {
                method: "DELETE"
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , "Accept": "application/json"
                }
            });

            const data = await res.json();

            if (res.ok) {
                alert("Itinerary deleted successfully!");
                loadItineraries(currentItiPage);
            } else {
                alert("Error: " + (data.message || "Delete failed"));
            }
        } catch (err) {
            console.error(err);
            alert("Something went wrong.");
        }
    }

    // day adding / removing logic for create itinerary modal -> form
    let dayIndex = 0;
    const daysContainer = document.getElementById('daysContainer');
    const addDayBtn = document.getElementById('addDayBtn');

    function createDayEntry(index) {
        const div = document.createElement('div');
        div.classList.add('card', 'bg-base-100', 'shadow-md', 'p-4', 'mb-4', 'day-entry');
        div.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold">Day <span class="day-number">${index + 1}</span></h3>
                <button type="button" class="btn btn-sm btn-error remove-day-btn">Remove</button>
            </div>
            <input type="number" name="days[${index}][day]" min="1" class="input input-bordered w-full mb-2" placeholder="Day Number" value="${index + 1}" readonly />
            <input type="text" name="days[${index}][location]" class="input input-bordered w-full mb-2" placeholder="Location" required />
            <textarea name="days[${index}][activities]" class="textarea textarea-bordered w-full" placeholder="Activities (comma separated)" required></textarea>
        `;
        return div;
    }

    addDayBtn.addEventListener('click', () => {
        const dayEntry = createDayEntry(dayIndex);
        daysContainer.appendChild(dayEntry);
        dayIndex++;
    });

    daysContainer.addEventListener('click', e => {
        if (e.target.classList.contains('remove-day-btn')) {
            e.target.closest('.day-entry').remove();
            // Optional: reindex day numbers and input names here
        }
    });

    // add one day on page load
    addDayBtn.click();

    // single submit handler for create/update
    document.getElementById('createItineraryForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = {
            title: formData.get('title')
            , notes: formData.get('notes')
            , days: []
        };

        // if creating, add enquiry_id
        if (!selectedItineraryId) {
            data.enquiry_id = selectedEnquiryId;
        }

        // get days
        const dayEntries = daysContainer.querySelectorAll('.day-entry');
        dayEntries.forEach((entry, i) => {
            const day = formData.get(`days[${i}][day]`);
            const location = formData.get(`days[${i}][location]`);
            const activitiesStr = formData.get(`days[${i}][activities]`);
            const activities = activitiesStr.split(',').map(s => s.trim()).filter(Boolean);

            data.days.push({
                day: parseInt(day)
                , location
                , activities
            });
        });

        // send to correct endpoint
        try {
            let url = '/api/itineraries';
            let method = 'POST';
            if (selectedItineraryId) {
                url += `/${selectedItineraryId}`;
                method = 'PUT';
            }

            const response = await fetch(url, {
                method
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify(data)
            });

            const result = await response.json();
            alert(result.message || (selectedItineraryId ? 'Itinerary updated!' : 'Itinerary created!'));
            loadItineraries();
            document.getElementById('createItineraryModal').close();
        } catch (err) {
            alert('Error saving itinerary.');
        }
    });

    // itinerary search form handling
    document.getElementById('filter-iti-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('iti-id').value;

        fetch(`/api/itineraries/${id}`, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                const specificItinerary = document.getElementById('specificItinerary');

                specificItinerary.innerHTML = `
                    <li><strong>Enquiry Name: </strong> ${data.enquiry?.name || 'Unknown'}</li>
                    <li><strong>Customer Email: </strong> ${data.enquiry?.email || 'Unknown'}</li>
                    <li><strong>Title: </strong> ${data.title}</li>
                    <li><strong>Notes: </strong> ${data.notes || 'No Notes'}</li>
                `;

                data.days.forEach(day => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                            <strong>Day ${day.day} - ${day.location}</strong><br>
                            ${day.activities.map(act => `* ${act}`).join('<br>')}
                        `;
                    specificItinerary.appendChild(li);
                });

                specificItinerary.innerHTML += `
                    <li><strong>Created At: </strong> ${new Date(data.created_at).toDateString()}</li>
                    <li><strong>Updated At: </strong> ${new Date(data.updated_at).toDateString()}</li>
                `;

                viewItineraryModal.showModal();

                console.log(data);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch itinerary.');
            });
    });

    //
    // ** quotation logic **
    //

    let selectedQuotationId = null;

    function createQuotation(itineraryId) {
        selectedItineraryId = itineraryId;
        createQuotationModal.showModal();
    }

    // quotation create form handling
    document.getElementById('createQuotationForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);

        const data = {
            itinerary_id: selectedItineraryId
            , title: formData.get('title')
            , notes: formData.get('notes')
            , price_per_person: formData.get('price_per_person')
            , currency: formData.get('currency')
            , is_final: formData.get('is_final') !== null
        , };

        // send to endpoint
        try {
            const response = await fetch('/api/quotations/', {
                method: 'POST'
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify(data)
            });

            const result = await response.json();

            alert(result.message);

            loadItineraries();

            document.getElementById('createQuotationModal').close();
        } catch (err) {
            alert('Error saving quotation.');
        }
    });

    function loadQuotations(page = 1) {
        let route = "/api/quotations";

        route += '?page=' + page; // for pagination

        fetch(route, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // load data to 'quotations-table-body'
                const tableBody = document.getElementById('quotations-table-body');

                tableBody.innerHTML = '';

                console.log(data);

                data.forEach(quotation => {
                    // Create main itinerary row /// <td>${quotation.itinerary.title}</td>
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${quotation.id}</td>
                        <td>${quotation.uniqueId}</td>
                        
                        <td>${quotation.title}</td>
                        <td>${quotation.price_per_person}</td>
                        <td>${quotation.currency}</td>
                        <td>${quotation.notes}</td>
                        <td>${quotation.is_final}</td>
                        <td>${new Date(quotation.created_at).toDateString()}</td>
                        <td>${new Date(quotation.updated_at).toDateString()}</td>
                        <td class="flex flex-wrap justify-end gap-2">
                            <button class="btn btn-sm" onclick="createPayment(${quotation.id});">Create Payment</button>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });

                //console.log(data.data);

                // for pagination
                // currentItiPage = data.current_page;
                // lastItiPage = data.last_page;
                // renderPagination('itiPagination', 'loadItineraries', currentItiPage, lastItiPage);
            })
            .catch(error => {
                console.error(error);
                alert('Error loading quotations.');
            });
    }

    // load quotations once on page load
    loadQuotations();

    // quotation search form handling
    document.getElementById('filter-quo-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('quo-id').value;

        fetch(`/api/quotations/${id}`, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
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

                viewQuotationModal.showModal();

                console.log(data);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch quotation.');
            });
    });

    //
    // ** payment logic **
    //

    // open payment creation modal
    function createPayment(quotationId) {
        selectedQuotationId = quotationId;
        createPaymentModal.showModal();
    }

    // global method to filter payments
    function filterPayments(form, params) {
        if (form.payment_method.value) params.append('payment_method', form.payment_method.value);
        if (form.from.value) params.append('from', form.from.value);
        if (form.to.value) params.append('to', form.to.value);

        if (currentUser.role === 'agent') {
            params.append('assigned_to', currentUser.id);
        } else {
            if (form.assigned_to.value) params.append('assigned_to', form.assigned_to.value);
        }
    }

    // global method to populate the payments table
    function populatePayments(data, tbody) {
        data.forEach(payment => {
            tbody.innerHTML += `
            <tr>
                <td>${payment.id}</td>
                <td>${payment.quotation.title}</td>
                <td>${payment.amount}</td>
                <td>${payment.payment_method}</td>
                <td>${payment.transaction_reference}</td>
                <td>${new Date(payment.created_at).toDateString()}</td>
                <td>${new Date(payment.updated_at).toDateString()}</td>
            </tr>
          `;
        });
    }

    // Payment create form handling
    document.getElementById('createPaymentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);

        const data = {
            quotation_id: selectedQuotationId
            , amount: formData.get('amount')
            , payment_method: formData.get('payment_method')
            , transaction_reference: formData.get('transaction_reference')
        , };

        // send to endpoint
        try {
            const response = await fetch('/api/payments/', {
                method: 'POST'
                , headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify(data)
            });

            const result = await response.json();

            alert(result.message);

            loadPayments();

            document.getElementById('createPaymentModal').close();
        } catch (err) {
            alert('Error saving payment.');
        }
    });

    // load payments based on user role
    function loadPayments(page = 1) {
        let route = '/api/payments';

        let form = document.getElementById('filter-pay-form');
        let params = new URLSearchParams();

        filterPayments(form, params);

        route += '?' + params.toString(); // add other filters

        route += '&page=' + page; // for pagination

        //alert(route);

        fetch(route, {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#payments-table-body');
                tbody.innerHTML = '';

                // populate table using global method
                populatePayments(data.data, tbody);

                // Pagination log
                console.log('Total pages:', data.last_page);

                // for pagination
                currentPayPage = data.current_page;
                lastPayPage = data.last_page;
                renderPagination('payPagination', 'loadPayments', currentPayPage, lastPayPage);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch payments.');
            });
    }

    // filter payments form handling
    document.getElementById('filter-pay-form').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = e.target;
        let params = new URLSearchParams();

        filterPayments(form, params);

        params.append('page', 1); // Always start from page 1 when filtering

        fetch('/api/payments?' + params.toString(), {
                headers: {
                    'Authorization': 'Bearer ' + token
                    , 'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#payments-table-body');
                tbody.innerHTML = '';

                // populate table using global method
                populatePayments(data.data, tbody);

                // for pagination
                currentPayPage = data.current_page;
                lastPayPage = data.last_page;
                renderPagination('payPagination', 'loadPayments', currentPayPage, lastPayPage);
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch payments.');
            });
    });

</script>


@endsection
