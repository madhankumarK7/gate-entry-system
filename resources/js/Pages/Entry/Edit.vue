
<template>
    <AppLayout title="Visitors">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Entry
            </h2>
        </template>
        <form class="mt-3 max-w-sm mx-auto" @submit.prevent="updateEntry()">
            <div>
                <label for="name" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Visitor Name</label>
                <VueMultiselect
                    v-model="selectedUser"
                    :options="visitorList" :multiple="false" 
                    :close-on-select="true" :clear-on-select="true" 
                    :preserve-search="true" placeholder="Search by name/mobile" 
                    label="full_name" track-by="id" :preselect-first="false"
                    @select="filterByVisitor()"  @remove="filterByVisitor()"                          
                    class="inline-flex justify-center text-center cursor-pointer md:!w-48 xl:!w-[314px] rounded-full border border-primary shadow-sm px-4 text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-offset-gray-100 focus:ring-white"
                >
                    <template #noResult>No Visitor found</template>                        
                    <template #noOptions>Visitor List is Empty.</template>                                                    
                </VueMultiselect>
                <InputError :message="entryForm.errors.visitor_id" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="mobile" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Gate Name</label>
                <!-- <input type="number" v-model="visitorForm.mobile" id="mobile" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> -->
                <select ref="source_id" v-model="entryForm.gate_id" class="truncate mt-1 block w-full md:w-[500px]  pr-10 py-2 text-base border-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @change="validateToFunds($event)"  >
                    <option value="">Select</option>
                    <option v-for="gateItem in gateList" :key="gateItem.id" :value="gateItem.id">{{ gateItem.name }}</option>                    
                </select>

                <InputError :message="entryForm.errors.gate_id" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="entry_time" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Entry Time</label>
                <input type="datetime-local" id="entry_time" name="entry_time" v-model="entryForm.entry_time">
                <InputError :message="entryForm.errors.entry_time" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="exit_time" class="block font-bold mb-2 text-sm font-medium text-gray-900 dark:text-white">Exit Time</label>
                <input type="datetime-local" id="exit_time" name="exit_time" v-model="entryForm.exit_time">
                <InputError :message="entryForm.errors.exit_time" class="mt-2" />
            </div>
            <div class="mt-6">
                <ActionMessage :on="entryForm.recentlySuccessful">
                    Entry was updated Successfully
                </ActionMessage>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150" :class="{ 'opacity-25': entryForm.processing }" :disabled="entryForm.processing">
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
import VueMultiselect from 'vue-multiselect'
export default {
    name: 'Entry Create',
    components: {
        AppLayout,
        PrimaryButton,
        InputError,
        ActionMessage,
        VueMultiselect
    },
    props:{
        gateList : Object,
        visitorList: Object,
        entry: Object,
    },
    data(){
        return {
            entryForm: this.$inertia.form({
                visitor_id : (this.entry.visitor_id) || '',
                gate_id : (this.entry.gate_id) || '',
                entry_time : (this.entry.entry_time_formatted) || '',
                exit_time : (this.entry.exit_time_formatted) || '',
            }),
            selectedUser: [],
        }
    },
    mounted(){
        this.selectedUser = this.visitorList.find(option => option.id === this.entry.visitor_id);
    },
    methods: {
        updateEntry(){
            this.entryForm.put(this.route('entry.update',this.entry.id),{
                onSuccess: () => {
                    //this.entryForm.reset();
                    //this.selectedUser = [];
                }
            })
        },
        filterByVisitor(){
            this.entryForm.visitor_id = (this.selectedUser) ? this.selectedUser?.id : '';
        },

    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>