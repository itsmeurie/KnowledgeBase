<script setup lang="ts">
const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '#about-documentation' } //inayos
];

// inayos
const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};
</script>

<template>
  <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
        <!-- Logo -->
        <div class="flex items-center min-w-60 ">
          <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Knowledge Base</p>
        </div>

        <!-- Spacing divs for layout balance (hidden on small screens) -->
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>


        <!-- Navigation -->
        <div class="w-full sm:w-auto col-span-3 flex justify-center">
          <THorizontalNavigation :links="links"> <!-- Inayos-->
                <template #default="{ link }">
                  <a 
                    :href="link.to" 
                    @click.prevent="link.label === 'About' ? scrollToAbout() : null" 
                    class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative"
                  >
                    {{ link.label }}
                  </a>
                </template>
            </THorizontalNavigation>
            </div>
        </div>

  <!-- Hero Section -->
  <div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10 mx-8">
    <div class="sm:col-span-6 min-h-[370px] p-4 sm:p-8">
      <h1 class="text-black text-4xl sm:text-5xl font-extrabold font-Inter">
        Leadership and <br> Governance in Higher <br> Education: Roles and <br> Responsibilities
      </h1>
      <p class="mt-4 text-lg">A centralized platform for obtaining knowledge on system documentation.</p>
      <a href="/offices">
          <button class="mt-6 bg-black hover:bg-green-300 text-white font-bold py-2 px-6 rounded-full border-2">
            Get Started
          </button>
      </a>
    </div>
    
    <!-- Image -->
    <div class="sm:col-span-4 flex justify-center mr-26">
      <img src="@/assets/image/image.png" class="h-[250px] w-auto sm:h-[300px] object-contain" />
    </div>
  </div>

  <!-- Adding Articles Section -->
  <div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <!-- Image -->
    <div class="sm:col-span-4 flex justify-center">
      <img src="@/assets/image/bgg.png" class="h-[290px] w-auto object-contain" />
    </div>

    <div class="sm:col-span-6 min-h-[300px] p-4 sm:p-8">
      <h1 class="text-black text-4xl sm:text-5xl font-extrabold font-Inter">Adding Articles</h1>
      <p class="mt-4 text-lg">
        Add new articles by entering the title, author, date, and content. Organize them with tags to make searching easier.
      </p>
    </div>
  </div>

 
  <!-- About Documentation --> 
<div id="about-documentation" ref="aboutSection" class="m-2 px-4">
  <h1 class="text-black text-3xl font-extrabold font-Inter">About Documentation</h1>
</div>

  <div class="m-2 px-4">
    <p class="text-lg">
      Leadership and Governance in Higher Education: Roles and Responsibilities explores the key functions,
      structures, and challenges of leadership and governance within academic institutions. This documentation provides 
      insights into the roles of administrators, faculty, and governing bodies in shaping policies, ensuring 
      institutional effectiveness, and fostering academic excellence. Lorem ipsum dolor sit amet consectetur adipisicing elit.
       Modi illum doloribus pariatur quasi optio ipsum repellendus nostrum obcaecati. Sunt suscipit tempore necessitatibus sequi quasi aliquid quas adipisci animi earum autem! Lorem ipsum dolor,
       sit amet consectetur adipisicing elit. Quasi iste aperiam ipsam provident numquam obcaecati nihil blanditiis possimus labore at laborum magni dicta, nobis dolor sunt amet! Repellat, ea incidunt?
    </p>
  </div>

  <!-- Basic Info Card -->
  <div class="m-2 p-6 rounded-lg shadow-lg bg-green-500 text-white">
    <h1 class="text-2xl font-bold">Basic Info</h1>
  </div>
</template>
