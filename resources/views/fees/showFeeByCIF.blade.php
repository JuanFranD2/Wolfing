<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Fee Details') }} #{{ $fee->id }}
            </h2>
            <button onclick="window.history.back()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Back
            </button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h1 class="mb-4 text-xl font-semibold">Fee #{{ $fee->id }}</h1>

                    <table class="table-auto w-full border border-gray-700 dark:border-gray-600">
                        <tbody class="divide-y divide-gray-700">
                            <tr>
                                <td class="px-4 py-2 font-semibold">CIF:</td>
                                <td>{{ $fee->cif }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Client:</td>
                                <td>
                                    @if ($fee->client)
                                        {{ $fee->client->name }}
                                    @else
                                        Client not found
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Concept:</td>
                                <td>{{ $fee->concept }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Amount:</td>
                                <td>{{ $fee->amount }} €</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Status:</td>
                                <td>{{ $fee->passed == 'S' ? 'Paid' : 'Pending' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Issue Date:</td>
                                <td>{{ $fee->issue_date->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Payment Date:</td>
                                <td>{{ $fee->payment_date ? $fee->payment_date->format('Y-m-d') : 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Notes:</td>
                                <td>{{ $fee->notes ?? 'No notes provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Created At:</td>
                                <td>{{ $fee->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Updated At:</td>
                                <td>{{ $fee->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PayPal SDK -->
                    <div id="paypal-button-container" class="w-full mt-4"></div>

                    <script
                        src="https://www.paypal.com/sdk/js?client-id=AUqmdgiYrcZO39Nkr5nMV0Bq0aXtvTEbBQjJtGOApe5QEfUtiBL97U5oBVO2viMWBnHDirLmlDcLVkoi">
                    </script>
                    <script>
                        paypal.Buttons({
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '{{ $fee->amount }}'
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
