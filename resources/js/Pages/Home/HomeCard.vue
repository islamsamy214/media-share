<template>
  <div class="w-screen h-screen flex items-center justify-center">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="transition w-80 h-36 bg-white rounded-xl md:rounded-tl-full md:rounded-br-full cursor-pointer hover:bg-secondary" @click="aboutRedirect">
        <h1 class="w-full h-full flex items-center justify-center uppercase text-2xl text-black font-bold">who are we</h1>
      </div>
      <div class="transition w-80 h-36 bg-primary rounded-xl md:rounded-bl-full md:rounded-tr-full cursor-pointer hover:bg-secondary" @click="worksRedirect">
        <h1 class="w-full h-full flex items-center justify-center uppercase text-2xl text-white font-bold">what are we do</h1>
      </div>
      <div class="transition w-80 h-36 bg-primary rounded-xl md:rounded-tr-full md:rounded-bl-full cursor-pointer hover:bg-secondary" @click="blogsRedirect">
        <h1 class="w-full h-full flex items-center justify-center uppercase text-2xl text-white font-bold">blogs</h1>
      </div>
      <div class="transition w-80 h-36 bg-white rounded-xl md:rounded-tl-full md:rounded-br-full cursor-pointer hover:bg-secondary" @click="contactRedirect">
        <h1 class="w-full h-full flex items-center justify-center uppercase text-2xl text-black font-bold">contact</h1>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    methods: {
        aboutRedirect(){
            this.$router.push({name:'about'})
        },
        worksRedirect(){
            this.$router.push({name:'works'})
        },
        blogsRedirect(){
            this.$router.push({name:'blogs'})
        },
        contactRedirect(){
            this.$router.push({name:'contact'})
        },
    },
}
</script>