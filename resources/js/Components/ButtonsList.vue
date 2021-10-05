<template>
  <div class="relative">
    <button @click="visible = !visible"><slot name="title"></slot></button>
    <ul
      class="
        bg-white
        gap-2
        max-w-min
        text-primary
        rounded-xl
        absolute
        -left-8
        top-8
        z-10
      "
      v-if="visible"
    >
      <slot></slot>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      visible: false,
    };
  }, //end of data
};
</script>