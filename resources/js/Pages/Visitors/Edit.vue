
<template>
    <AppLayout title="Visitors">
        <template #header>
            <div class="flex ">
                <div class="w-3/4">
                Edit Visitor
                </div>
                <div class="w-1/4 text-right">
                    <Link :href="route('dashboard')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    Back
                    </Link>
                </div>
            </div>
        </template>
        <form class="mt-3 max-w-sm mx-auto" @submit.prevent="updateVisitor()">
            <div>
                <label for="name" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" v-model="visitorForm.name" id="name" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <InputError :message="visitorForm.errors.name" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="mobile" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Mobile</label>
                <input type="number" v-model="visitorForm.mobile" id="mobile" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <InputError :message="visitorForm.errors.mobile" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="address" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                <textarea v-model="visitorForm.address" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                <InputError :message="visitorForm.errors.address" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="age" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                <input type="number" v-model="visitorForm.age" id="age" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <InputError :message="visitorForm.errors.age" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="gender" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <input type="radio" v-model="visitorForm.gender" value="Male" > Male
                <input type="radio" v-model="visitorForm.gender" value="Female" class="ml-3"> Female
                <input type="radio" v-model="visitorForm.gender" value="Others" class="ml-3"> Others
                <InputError :message="visitorForm.errors.gender" class="mt-2" />
            </div>
            <div class="mt-6">
                <ActionMessage :on="visitorForm.recentlySuccessful" class="mb-2">
                    Visitor was updated Successfully
                </ActionMessage>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150" :class="{ 'opacity-25': visitorForm.processing }" :disabled="visitorForm.processing">
                    Update
                </button>
            </div>
        </form>
    </AppLayout>
</template>
<script>
import ActionMessage from '@/Components/ActionMessage.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

export default {
    name: 'Visitor Edit',
    components: {
        AppLayout,
        PrimaryButton,
        InputError,
        ActionMessage,
        Link,
    },
    props: {
        visitor: Object,
    },
    data(){
        return {
            visitorForm: this.$inertia.form({
                name : (this.visitor.name) ? (this.visitor.name) : '',
                mobile : (this.visitor.mobile) ? (this.visitor.mobile) : '',
                age : (this.visitor.age) ? (this.visitor.age) : '',
                gender : (this.visitor.gender) ? (this.visitor.gender) :  '',
                address : (this.visitor.address) ? (this.visitor.address) :  '',
            }),
        }
    },
    methods: {
        updateVisitor(){
            this.visitorForm.put(this.route('visitor.update',this.visitor.id),{
                onSuccess: () => {
                    //this.visitorForm.reset();
                }
            })
        }
    }
}
</script>
