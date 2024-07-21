<template>
    <div v-if="visible" >
      <slot></slot>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      duration: {
        type: Number,
        default: 10000, // default duration 10 seconds
      },
    },
    data() {
      return {
        visible: true,
      };
    },
    mounted() {
      this.startTimer();
    },
    methods: {
      startTimer() {
        setTimeout(() => {
          this.visible = false;
        }, this.duration);
      },
    },
  };
  </script>
  