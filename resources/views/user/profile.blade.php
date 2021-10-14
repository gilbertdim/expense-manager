<x-app-layout>
    <x-slot name="header">
        Change Password
    </x-slot>
    <x-slot name="header_path">
        User Profile        
    </x-slot>

    @push('script')
        <script>
            $(function(){
                @if(session('error'))
                    $('#alertDanger').html("{{ session('error') }}").parent().removeClass('hidden');
                @endif

                @if(session('success'))
                    $('#alertSuccess').html("{{ session('success') }}").parent().removeClass('hidden');
                @endif
            });
        </script>
    @endpush

    <div class="hidden mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline" id="alertDanger"></span>
        <span onclick="$(this).parent().addClass('hidden')" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>

    <div class="hidden mt-2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline" id="alertSuccess"></span>
        <span onclick="$(this).parent().addClass('hidden')" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>


    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 mx-auto w-1/2">
            <div class="sm:flex w-full">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <div class="mt-5 w-full">
                        <div class="block">
                            <div class="block text-left lg:flex lg:space-x-3 w-full">
                                <label class="w-64" for="">Old Password</label>
                                <input type="password" required name="old_pass" value="" class="text-sm rounded-md h-7 w-full">
                            </div>
                        </div>
                        <div class="mt-5 block">
                            <div class="block text-left lg:flex lg:space-x-3 w-full">
                                <label class="w-64" for="">New Password</label>
                                <input type="password" required name="new_pass" value="" class="text-sm rounded-md h-7 w-full">
                            </div>
                        </div>
                        <div class="mt-5 block">
                            <div class="block text-left lg:flex lg:space-x-3 w-full">
                                <label class="w-64" for="">Confirm Password</label>
                                <input type="password" required name="confirm_pass" value="" class="text-sm rounded-md h-7 w-full">
                            </div>
                        </div>
                        <div class="mt-5 block">
                            <div class="flex justify-end">
                                <button class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>
