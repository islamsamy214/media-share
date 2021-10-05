<template>
  <div class="flex flex-row gap-4 justify-center my-3">
    <button
      class="transition hover:text-secondary"
      :class="disablePreviousPage"
      @click="$emit('previousPage')"
    >
      <icon icon="akar-icons:chevron-left" />
    </button>
    <span>{{ currentPage }}</span>
    <button
      class="transition hover:text-secondary"
      @click="$emit('nextPage')"
      :class="disableNextPage"
    >
      <icon icon="akar-icons:chevron-right" />
    </button>
  </div>
</template>

<script>
export default {
    emits:['previousPage','nextPage'],
    props:['currentPage','firstPage','lastPage'],

    computed: {
    disablePreviousPage() {
      return { hidden: this.firstPage == this.currentPage };
    },
    disableNextPage() {
      return { hidden: this.lastPage == this.currentPage };
    },
  }, //end of disableNextPage
}
</script>