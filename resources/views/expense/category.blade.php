<x-app-layout>
    <x-slot name="header">
        Expense Category
    </x-slot>
    <x-slot name="header_path">
        Expense Management > Expense Category
    </x-slot>

    <table class="text-sm w-full mt-5 mb-4">
        <thead>
            <tr class="font-semibold text-center text-gray-900 bg-gray-200 border-gray-600">
                <th class="border-2 py-1">Display Name</th>
                <th class="border-2 py-1">Description</th>
                <th class="border-2 py-1">Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-gray-600 hover:bg-gray-100" v-on:click="updateExpenseCategory(category)" v-for="category in data.expenseCategories">
                <td class="border-2 px-2 py-1">${ category.name }</td>
                <td class="border-2 px-2 py-1">${ category.description }</td>
                <td class="border-2 px-2 py-1">${ category.created_date }</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button v-on:click="addExpenseCategory" class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Add Category</button>
    </div>
</x-app-layout>
