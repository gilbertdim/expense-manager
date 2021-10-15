<x-app-layout>
    <x-slot name="header">
        Expenses
    </x-slot>
    <x-slot name="header_path">
        Expense Management > Expenses
    </x-slot>

    <table class="text-sm w-full mt-5 mb-4">
        <thead>
            <tr class="font-semibold text-center text-gray-900 bg-gray-200 border-gray-600">
                <th class="border-2 py-1">Expense Category</th>
                <th class="border-2 py-1">Amount</th>
                <th class="border-2 py-1">Entry Date</th>
                <th class="border-2 py-1">Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr v-on:click="updateExpense(expense)" v-for="expense in data.expenses" class="border-gray-600 hover:bg-gray-100">
                <td class="border-2 px-2 py-1">${ expense.category_name }</td>
                <td class="border-2 px-2 py-1">$ ${ expense.amount }</td>
                <td class="border-2 px-2 py-1">${ expense.entry_date }</td>
                <td class="border-2 px-2 py-1">${ expense.created_date }</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button v-on:click="addExpense" class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Add Expense</button>
    </div>
</x-app-layout>
