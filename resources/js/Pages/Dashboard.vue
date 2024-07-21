<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Visitors
            </h2>
        </template>
        <div class="mt-3 ml-3">
            <Alert v-if="$page.props.flash.message" :duration="5000" class="text-red-600">
                {{ $page.props.flash.message }}
            </Alert>            
            <div class="text-right">
                <Link :href="route('visitor.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Visitor</Link>            
            </div>
        </div>

        <div class="mt-3 relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex mb-3 ml-3">
                  <input type="text"  placeholder="Search ..." class="text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" v-model="form.search" />
                    <button title="Reset" class="btn text-sm py-3 px-3 text-gray rounded ml-3"  @click="reset()" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Mobile
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Age
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Gender
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white" v-if="(Object.keys(visitorList.data).length==0)">
                    <tr><td colspan="8" class="px-3 py-4 text-sm text-gray-500 text-center">No Visitor found</td></tr>
                </tbody>

                <tbody>
                    <tr v-for="visitor in visitorList.data" :key="visitor.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ visitor.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ visitor.mobile }}
                        </td>
                        <td class="px-6 py-4">
                            {{ visitor.address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ visitor.age }}
                        </td>
                        <td class="px-6 py-4">
                            {{ visitor.gender }}
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('visitor.edit', visitor.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                            <a href="javascript:void(0);" class="pl-3 font-medium text-red-600 dark:text-red-500 hover:underline" @click="deleteVisitor(visitor.id)">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>            
        </div>
        <div class="pt-5 d-flex justify-content-end">
            <Pagination  class="mt-6" :links="visitorList.links" v-if="(Object.keys(visitorList.data).length>0)"  />
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
        visitorList: Object,
        filters: Object,
    },
    data(){
        return {
            form: {
                search : this.filters.search,
            }
        }
    },
    watch:{
      form: {
          handler: throttle(function() {
                let query = _.pickBy(this.form);
                this.$inertia.get(this.route("dashboard"), Object.keys(query).length ? query : { remember: 'forget' }, {
                    replace: true,
                    preserveState: true,
                });
          }, 150),
          deep: true,
        },  
    },     
    methods: {
        reset(){
            this.form.search = '';
        },
        deleteVisitor(id){
            if(confirm('Are you sure to delete this visitor?'))
                this.$inertia.delete(this.route('visitor.delete',id));
        }
    }
}
</script>