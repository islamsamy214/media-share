<template>
  <div class="flex flex-col">
    <div class="flex flex-col bg-black p-3 m-2 rounded-xl" v-if="about">
      <button
        class="flex justify-between"
        @click="visibleAbout = !visibleAbout"
      >
        <h1 class="text-lg font-bold">about</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visibleAbout">
        <p class="max-w-4xl">{{ about }}</p>
      </div>
    </div>
    <div class="flex flex-col bg-black p-3 m-2 rounded-xl" v-if="education">
      <button
        class="flex justify-between"
        @click="visibleEducation = !visibleEducation"
      >
        <h1 class="text-lg font-bold">education</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visibleEducation">
        <p class="w-48 md:w-96">
          {{ education }}
        </p>
      </div>
    </div>
    <div class="flex flex-col bg-black p-3 m-2 rounded-xl">
      <button
        class="flex justify-between"
        @click="visibleSkills = !visibleSkills"
      >
        <h1 class="text-lg font-bold">skills</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visibleSkills">
        <ul class="w-48 md:w-96 list-disc">
          <li v-for="skill in skills" :key="skill.id">
            {{ skill.skill }}
          </li>
        </ul>
      </div>
    </div>
    <div
      class="flex flex-col bg-black p-3 m-2 rounded-xl"
      v-if="country && city"
    >
      <button
        class="flex justify-between"
        @click="visiblePlace = !visiblePlace"
      >
        <h1 class="text-lg font-bold">lives in</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visiblePlace">
        <div class="w-48 md:w-96 list-disc">
          {{ country + ", " + city }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["about", "education", "skills", "country", "city"],
  
  data() {
    return {
      visibleAbout: false,
      visibleEducation: false,
      visibleSkills: false,
      visiblePlace: false,
    };
  },//end of data
};
</script>