<x-app-layout>
    <x-slot name="header">
        Roles
    </x-slot>
    <x-slot name="header_path">
        User Management > Role
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
            <tr v-on:click="updateRole(role)" v-for="role in data" class="border-gray-600 hover:bg-gray-100">
                <td class="border-2 px-2 py-1">${ role.name }</td>
                <td class="border-2 px-2 py-1">${ role.description }</td>
                <td class="border-2 px-2 py-1">${ role.created_date }</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button v-on:click="dataForm.show = true" class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Add Role</button>
    </div>

</x-app-layout>
