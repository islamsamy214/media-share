<template>
  <div class="flex flex-col">
    <div class="flex flex-col bg-black p-3 m-2 rounded-xl">
      <button
        class="flex justify-between"
        @click="visibleAbout = !visibleAbout"
      >
        <h1 class="text-lg font-bold">who are we?</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visibleAbout">
        <p>
          we are freelancers, we work in different fields separately and each
          one was dependent on himself, some of us are specialized in graphic design, others were motion graphic, web
          design, and even web development. as we know most customers want to
          get a project done at a low cost with high efficiency so they usually
          head to the freelancers and take the risk of efficiency, so that we
          decided to group professional freelancers in many fields together to
          guarantee you an efficient work with a low price and that's the idea
          of this website, I hope you enjoy it.
        </p>
      </div>
    </div>
    <div class="flex flex-col bg-black p-3 m-2 rounded-xl">
      <button class="flex justify-between" @click="visibleDo = !visibleDo">
        <h1 class="text-lg font-bold">what do we do?</h1>
        <span><icon icon="akar-icons:chevron-down" class="h-6 w-6" /></span>
      </button>
      <div class="transition p-3 m-2" v-show="visibleDo">
        <p>
          we are like advertising agancy, we do any sights work, for now we
          specialized in graphic design, web design, and web development, we
          offer you all the designs that produce your business, idea, or any
          project you want to produce professionally in an intelgent and
          creative way like:
        </p>
        <h3>for the web development:</h3>
        <ul class="list-disc">
          <li class="my-1 font-semibold">
            Professional website to produce or manage your business
          </li>
          <li class="my-1 font-semibold">UI/UX design</li>
          <li class="my-1 font-semibold">
            Experience designing and developing sites from concept to rollout.
          </li>
          <li class="my-1 font-semibold">
            front-end technologies, such as <strong>JavaScript</strong>,
            <strong>VueJs</strong>, <strong>jQuery</strong>,
            <strong>Ajax</strong>, <strong>HTML5</strong>,
            <strong>CSS3</strong>, and <strong>Bootstrap</strong>
          </li>
          <li class="my-1 font-semibold">
            back-end technologies, such as
            <strong>PHP</strong>
            <strong>Database</strong>
            using
            <strong>MySql</strong>
            and working with the most powerfull and popular framework
            <strong>Laravel</strong>
          </li>
          <li class="my-1 font-semibold">
            clean code so you can add more featurs in the future if you wanted
            to
          </li>
          <li class="my-1 font-semibold">
            we follow the <strong>SOLID PRINCIPLES</strong> in coding
          </li>
        </ul>
        <h3>And for the graphic design, we offer you:</h3>
        <ul class="list-disc">
          <li class="my-1 font-semibold">
            Professional logo design (minimal, typography, or 3D designs)
          </li>
          <li class="my-1 font-semibold">Social media kits</li>
          <li class="my-1 font-semibold">Banner design</li>
          <li class="my-1 font-semibold">Invitations design</li>
          <li class="my-1 font-semibold">wedding invitation design</li>
          <li class="my-1 font-semibold">Menu for a restaurant</li>
          <li class="my-1 font-semibold">Product design</li>
          <li class="my-1 font-semibold">Design a full identity</li>
          <li class="my-1 font-semibold">Or any other design</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      visibleAbout: true,
      visibleDo: false,
    };
  },
};
</script>