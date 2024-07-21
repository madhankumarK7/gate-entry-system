<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Entry List
            </h2>
        </template>
        <div class="mt-3 ml-3">
            <Alert v-if="$page.props.flash.message" :duration="5000" class="text-red-600">
                {{ $page.props.flash.message }}
            </Alert>            
            <!-- <div class="text-right">
                <Link :href="route('entry.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Visitor</Link>            
            </div> -->
        </div>

        <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex mb-3">
                <form @submit.prevent="applyFilter" class="mb-4 ml-8">
                    <div class="flex space-x-4">
                        <div>
                            <label for="start_date" class="block font-bold text-gray-700">Start Date</label>
                            <input
                                type="date"
                                id="start_date"
                                v-model="form.start_date"
                                class="mt-1 block w-full"
                            />
                        </div>
                        <div>
                            <label for="end_date" class="block font-bold text-gray-700">End Date</label>
                            <input
                                type="date"
                                id="end_date"
                                v-model="form.end_date"
                                class="mt-1 block w-full"
                            />
                        </div>
                        <div>
                            <label for="gate" class="block font-bold text-gray-700">Gate</label>
                            <select
                                id="gate"
                                v-model="form.gate"
                                class="mt-1 block w-full"
                            >
                                <option value="">Select Gate</option>
                                <option v-for="gate in gateList" :key="gate.id" :value="gate.id">{{ gate.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="visitor" class="block font-bold text-gray-700">Visitor</label>
                            <select
                                id="visitor"
                                v-model="form.visitor"
                                class="mt-1 block w-full"
                            >
                                <option value="">Select Visitor</option>
                                <option v-for="visitor in visitorList" :key="visitor.id" :value="visitor.id">{{ visitor.name }}</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Apply Filter
                            </button>
                            <button title="Reset" class="btn text-sm py-3 px-3 text-gray rounded ml-3"  @click="reset()" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>

                        </div>
                    </div>
                </form>

                <!-- <input type="text"  placeholder="Search ..." class="text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" v-model="form.search" />
                <button title="Reset" class="btn text-sm py-3 px-3 text-gray rounded ml-3"  @click="reset()" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button> -->
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Visitor Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Gate Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Entry Time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Exit Time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white" v-if="(Object.keys(entryList.data).length==0)">
                    <tr><td colspan="8" class="px-3 py-4 text-sm text-gray-500 text-center">No Entry found</td></tr>
                </tbody>

                <tbody>
                    <tr v-for="entry in entryList.data" :key="entry.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ entry.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ entry.gate_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ entry.formatted_entry_time }}
                        </td>
                        <td class="px-6 py-4">
                            {{ entry.formatted_exit_time }}
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('entry.edit', entry.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                            <a href="javascript:void(0);" class="pl-3 font-medium text-red-600 dark:text-red-500 hover:underline" @click="deleteEntry(entry.id)">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>            
        </div>
        <div class="pt-5 d-flex justify-content-end">
            <Pagination  class="mt-6" :links="entryList.links" v-if="(Object.keys(entryList.data).length>0)"  />
        </div>

    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Pagination from '@/Pages/Shared/Pagination.vue';
import Alert from '@/Components/Alert.vue';
import throttle from "lodash/throttle";
import _ from 'lodash';
export default {
    name : 'Dashboard',
    components:{
        AppLayout,
        Link,
        Pagination,
        Alert,
    },
    props: {
        entryList: Object,
        filters: Object,
        gateList: Object,
        visitorList: Object,
    },
    data(){
        return {
            form: {
                start_date : (this.filters.start_date) || '',
                end_date : (this.filters.end_date) || '',
                gate: (this.filters.gate) || '',
                visitor: (this.filters.visitor) || '',
            }
        }
    },
    methods: {
        deleteEntry(id){
            if(confirm('Are you sure to delete this entry?'))
                this.$inertia.delete(this.route('entry.delete',id));
        },
        applyFilter() {
            this.$inertia.get(this.route('entry.index'), this.form, {
                preserveState: true,
                replace: true,
            });
        },   
        reset(){
            this.form.start_date = '';
            this.form.end_date = '';
            this.form.gate = '';
            this.form.visitor = '';
        }     
    }
}
</script>