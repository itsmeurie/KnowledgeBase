<script setup lang="ts">

const OfficeHeader = defineAsyncComponent(() => import('~/pages/header.vue'))

</script>

<template>
  <!-- Header -->
  <OfficeHeader />

  <!-- Hero Section -->
  <div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10 mx-8">
    <div class="sm:col-span-6 min-h-23 p-4 sm:p-8">
      <h1 class="text-black text-6xl sm:text-6xl font-extrabold font-Inter">
        Listen, Look <br> and Listen <br> and Learn!
      </h1>
      <p class="mt-4 text-lg">A centralized platform for obtaining knowledge on system documentation.</p>
      <a href="/offices">
          <button class="mt-6 bg-black hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full border-2">
            Get Started
          </button>
      </a>
    </div>
    
    <!-- Image -->
    <div class="sm:col-span-4 flex justify-center mr-26">
      <img src="@/assets/image/image.png" class="h-15 w-auto sm:h-18 object-contain" />
    </div>
  </div>

  <!-- Adding Articles Section -->
  <div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <!-- Image -->
    <div class="sm:col-span-4 flex justify-center">
      <img src="@/assets/image/bgg.png" class="h-18 w-auto object-contain" />
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
