<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- <link rel="stylesheet" href="http://gilbertdim-expense-manager.test/css/app.css"> -->
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/build.js') }}"></script>

        <style>
            [v-cloak] {
                display: none;
            }
        </style>

        @stack('script')
    </head>    
    <body id="app" v-cloak class="font-sans antialiased">
        <div class="block w-full h-screen">
            <div class="flex w-full h-full min-h-screen">
                <span id="sideBarClose" class="hidden top-0 right-0 px-4 py-3 z-20" onclick="$('#sideBar, #sideBarClose').addClass('hidden');" style="float:right">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <div id="sideBar" class="hidden md:block lg:block w-screen md:w-56 lg:w-56 bg-gray-800 text-white h-full min-h-screen fixed z-10">
                    <ul class="relative min-h-screen">
                        <li class="flex mt-8">
                            <a class="mx-auto" href="{{ route('profile') }}">
                                <img class="h-20 rounded-full" src="https://www.clipartmax.com/png/middle/171-1717870_stockvader-predicted-cron-for-may-user-profile-icon-png.png" alt="">
                            </a>
                        </li>
                        <li class="text-center h-12">
                            <label class="">
                                <a href="{{ route('profile') }}">${ user.name } (${ user.role })</a>
                            </label>
                        </li>
                        <li class="block relative py-2">
                            <a href="{{ route('dashboard') }}" :class="{'bg-gray-500': selectedSideBar == '/dashboard'}" class="py-3 hover:bg-gray-300 hover:text-black px-2 block relative w-full h-full">Dashboard</a>
                        </li>
                        <li v-if="user.isAdmin" class="block relative py-2">
                            <a href="#" class="px-2 block relative w-full h-full">User Management</a>
                            <ul>
                                <li class="block relative">
                                    <a href="{{ route('user.roles') }}" :class="{'bg-gray-500': selectedSideBar == '/user/roles'}" class="py-3 hover:bg-gray-300 hover:text-black block" style="padding-left: 2rem">Roles</a>
                                </li>
                                <li class="block relative">
                                    <a href="{{ route('users') }}" :class="{'bg-gray-500': selectedSideBar == '/users'}" class="py-3 hover:bg-gray-300 hover:text-black block" style="padding-left: 2rem">User</a>
                                </li>
                            </ul>
                        </li>
                        <li class="block relative py-2">
                            <a href="#" class="px-2 block relative w-full h-full">Expense Management</a>
                            <ul class="">
                                <li v-if="user.isAdmin" class="block relative">
                                    <a href="{{ route('expenses.category') }}" :class="{'bg-gray-500': selectedSideBar == '/expenses/category'}" class="py-3 hover:bg-gray-300 hover:text-black block" style="padding-left: 2rem">Expense Category</a>
                                </li>
                                <li class="block relative">
                                    <a href="{{ route('expenses') }}" :class="{'bg-gray-500': selectedSideBar == '/expenses'}" class="py-3 hover:bg-gray-300 hover:text-black block" style="padding-left: 2rem">Expenses</a>
                            </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="w-full bg-white h-12 text-white fixed border-2">
                    <div class="px-4 py-1">
                        <nav class="flex justify-between md:justify-end">
                            <div class="-mr-2 flex items-center md:hidden">
                                <button onclick="$('#sideBar, #sideBarClose').removeClass('hidden')" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                                
                            </div>
                            <ul class="flex mt-2 space-x-5">
                                <li>
                                    <span class="text-gray-500 pl-2">Welcome to Expense Manager</span>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <a href="#" onclick="this.closest('form').submit()" class="font-medium text-indigo-600 hover:text-indigo-900">
                                            Log out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="w-full fixed mt-10 pt-5 pl-4 md:pl-64 lg:pl-64 pr-4">
                    <div class="block md:flex justify-between">
                        <h2 class="text-xl font-semibold">${ header.title }</h2>
                        <h1 class="font-semibold">${ header.path }</h1>
                    </div>

                    <div v-if="systemAlert.type == 'danger'" class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">${ systemAlert.message }</span>
                        <span v-on:click="systemAlert.type = ''" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>

                    <div v-if="systemAlert.type == 'primary'" class="mt-2 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">${ systemAlert.message }</span>
                        <span v-on:click="systemAlert.type = ''" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>

                    <div v-if="systemAlert.type == 'success'" class="mt-2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">${ systemAlert.message }</span>
                        <span v-on:click="systemAlert.type = ''" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>

                    <form-data 
                        :system-alert="systemAlert"
                        :data-form="dataForm"
                        :header="header"
                    />
                </div>
            </div>
        </div>

        <div v-if="dataForm.loader" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex w-full my-5">
                            <div class="flex mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Processing Request
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>