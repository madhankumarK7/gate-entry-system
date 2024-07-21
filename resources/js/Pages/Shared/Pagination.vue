<template>
    <div v-if="links.length > 1">
      <div class="flex flex-wrap pagination justify-end">
        <template v-for="(link, index) in links" :key="index" >
          <Link v-if="link.url === null" class="mr-1 mb-1 px-3 py-1 rounded-sm  text-gray-400 border text-sm mydisable" v-html="link.label" />
          <Link v-else class="page-link mr-1 mb-1 px-3 py-1 flex items-center  rounded-sm text-sm leading-4 border focus:border-indigo-500 focus:text-indigo-500"
           :class="{ 'btn text-white bg-gray-600': link.active }" :href="link.url" v-html="link.label" />
        </template>
      </div>
    </div>
  </template>
  
  <script>
import { Link } from '@inertiajs/vue3';

  export default {
    components:{
        Link
    },
    props: {
      links: Array,
    },
  }
  </script>