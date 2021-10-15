<x-app-layout>
    <x-slot name="header">
        Users
    </x-slot>
    <x-slot name="header_path">
        User Management > Users
    </x-slot>

    <table class="text-sm w-full mt-5 mb-4">
        <thead>
            <tr class="font-semibold text-center text-gray-900 bg-gray-200 border-gray-600">
                <th class="border-2 py-1">Name</th>
                <th class="border-2 py-1">Email Address</th>
                <th class="border-2 py-1">Role</th>
                <th class="border-2 py-1">Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr v-on:click="updateUser(user)" v-for="user in data.users" class="border-gray-600 hover:bg-gray-100">
                <td class="border-2 px-2 py-1">${ user.name }</td>
                <td class="border-2 px-2 py-1">${ user.email }</td>
                <td class="border-2 px-2 py-1">${ user.role_name }</td>
                <td class="border-2 px-2 py-1">${ user.created_date }</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button v-on:click="addUser" class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Add User</button>
    </div>
</x-app-layout>
