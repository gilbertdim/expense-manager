<template>
    <table class="text-sm w-full mt-5 mb-4">
        <thead>
            <tr class="font-semibold text-center text-gray-900 bg-gray-200 border-gray-600">
                <th class="border-2 py-1">Display Name</th>
                <th class="border-2 py-1">Description</th>
                <th class="border-2 py-1">Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-gray-600 hover:bg-gray-100" v-on:click="update(category)" v-for="(category, i) in dataForm.data" :key="i">
                <td class="border-2 px-2 py-1">{{ category.name }}</td>
                <td class="border-2 px-2 py-1">{{ category.description }}</td>
                <td class="border-2 px-2 py-1">{{ category.created_date }}</td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button v-on:click="add" class="hover:text-white hover:border-black hover:bg-gray-900 border-2 border-gray-900 px-3 py-1 rounded-md shadow">Add Category</button>
    </div>

    <div v-if="dataForm.show" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="post" @submit.prevent @submit="saveRecord">
                    <input type="hidden" name="_token" value="">
                    <input type="hidden" v-model="id" name="id">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex w-full">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ dataForm.title }}
                                </h3>
                                <div class="mt-5 w-full">
                                    <div class="block">
                                        <div class="block text-left lg:flex lg:space-x-3 w-full">
                                            <label class="w-36" for="">Display Name</label>
                                            <input type="text" required name="name" v-model="name" class="text-sm rounded-md h-7 w-full">
                                        </div>
                                    </div>
                                    <div class="block mt-3">
                                        <div class="block text-left lg:flex lg:space-x-3 w-full">
                                            <label class="w-36" for="">Description</label>
                                            <input type="text" required name="description" v-model="description" class="text-sm rounded-md h-7 w-full">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between mt-2">
                        <div>
                            <button type="button" v-on:click="dataForm.show = !dataForm.show" class="mt-1 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                            </button>
                            <button v-if="dataForm.add" class="mt-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                            </button>
                            <button v-if="dataForm.update" class="mt-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                            </button>
                        </div>
                        <div v-if="dataForm.update">
                            <button type="button" v-on:click="deleteRecord" class="mt-1 bg-red-500 text-white mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                            </button>    
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['showModal', 'dataForm', 'systemAlert', 'header'],
    data(){
        return {
            id: null,
            name: '',
            description: '',
        }
    },
    beforeMount() {
        this.header.title = 'Expense Categories';
        this.header.path = 'Expenses Management > Expense Category';        
    },
    methods: {
        add(){
            this.id = null;
            this.name = '';
            this.description = '';

            this.dataForm.title = "Add Category"
            this.dataForm.show = true;
            this.dataForm.add = true;
            this.dataForm.update = false;
        },
        update(category)
        {
            this.id = category.id;
            this.name = category.name;
            this.description = category.description;

            this.dataForm.title = "Update Categeory"
            this.dataForm.show = true;
            this.dataForm.add = false;
            this.dataForm.update = true;
        },
        saveRecord(){
            this.systemAlert.type = '';
            this.systemAlert.message = '';
            
            this.dataForm.loader = true;
            this.dataForm.show = false;

            axios
                .post('/api'+window.location.pathname, {
                    id: this.id,
                    name: this.name,
                    description: this.description
                })
                .then(response => {
                    if('message' in response.data)
                    {
                        this.systemAlert.type = 'danger';
                        this.systemAlert.message = response.data.message;

                        this.dataForm.show = true;
                    }
                    else
                    {
                        this.id = null;
                        this.name = '';
                        this.description = '';

                        this.systemAlert.type = 'success';
                        this.systemAlert.message = 'Record was successfully saved!';
                        
                        this.dataForm.data = response.data;

                        this.dataForm.show = false;
                    }

                    this.dataForm.loader = false;
                })
                .catch(err => {
                    this.systemAlert.type = 'danger';
                    this.systemAlert.message = 'An error occured while processing your request!';

                    console.log(err.message);
                    this.dataForm.loader = false;
                    this.dataForm.show = true;
                });
        },
        deleteRecord(){
            this.dataForm.loader = true;
            this.dataForm.show = false;

            this.systemAlert.type = '';
            this.systemAlert.message = '';

            axios
                .post('/api'+window.location.pathname+'/delete', { 'id': this.id })
                .then(response => {
                if('message' in response.data)
                {
                    this.systemAlert.type = 'alert';
                    this.systemAlert.message = response.data.message;

                    this.dataForm.show = true;
                }
                else
                {
                    this.id = null;
                    this.name = '';
                    this.description = '';

                    this.systemAlert.type = 'success';
                    this.systemAlert.message = 'Record was successfully deleted!';
                    
                    this.dataForm.data = response.data;
                }

                this.dataForm.loader = false;
            })
                .catch(err => {
                console.log(err.message);
                this.dataForm.show = true;
                this.showLoader = false;
            });
        }
    }
}
</script>