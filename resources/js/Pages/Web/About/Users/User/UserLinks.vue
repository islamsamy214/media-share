<template>
  <div class="m-4 flex flex-row gap-4 items-center">
    <a
      v-if="facebook_id"
      :href="`https://www.facebook.com/${facebook_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="brandico:facebook-rect" class="w-8 h-8" />
    </a>
    <a
      v-if="linkedin_id"
      :href="`https://www.linkedin.com/${linkedin_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="brandico:linkedin-rect" class="w-8 h-8" />
    </a>
    <a
      v-if="twitter_id"
      :href="`https://www.twitter.com/${twitter_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="fa-brands:twitter-square" class="w-9 h-9" />
    </a>
    <a
      v-if="behance_id"
      :href="`https://www.behance.com/${behance_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="wpf:behance" class="w-8 h-8" />
    </a>
    <a
      v-if="instagram_id"
      :href="`https://www.instagram.com/${instagram_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="ri:instagram-fill" class="w-9 h-9" />
    </a>
    <a
      v-if="github_id"
      :href="`https://www.github.com/${github_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="jam:github" class="w-10 h-10" />
    </a>
    <a
      v-if="youtube_id"
      :href="`https://www.youtube.com/${youtube_id}`"
      target="_blank"
      class="transition text-black hover:text-secondary"
    >
      <icon icon="bi:youtube" class="w-8 h-8" />
    </a>
  </div>
</template>

<script>
export default {
  props: [
    "facebook_id",
    "linkedin_id",
    "twitter_id",
    "behance_id",
    "instagram_id",
    "github_id",
    "youtube_id",
  ],
};
</script>