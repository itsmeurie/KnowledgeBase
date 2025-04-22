<script setup lang="ts"></script>

<template>
  <!-- Hero Section -->
  <div class="m-2 mx-8 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <div class="min-h-23 p-4 sm:col-span-6 sm:p-8">
      <h1 class="font-Inter text-6xl font-extrabold sm:text-6xl">
        Listen, Look <br />
        and Listen <br />
        and Learn!
      </h1>
      <p class="mt-4 text-lg">
        A centralized platform for obtaining knowledge on system documentation.
      </p>
      <a href="/offices">
        <button
          class="mt-6 rounded-full border-2  px-6 py-2 font-bold hover:bg-primary hover:text-white"
        >
          Get Started
        </button>
      </a>
    </div>

    <!-- Image -->
    <div class="mr-26 flex justify-center sm:col-span-4">
      <img
        src="@/assets/image/image.png"
        class="h-15 sm:h-18 w-auto object-contain"
      />
    </div>
  </div>

  <!-- Adding Articles Section -->
  <div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <!-- Image -->
    <div class="flex justify-center sm:col-span-4">
      <img src="@/assets/image/bgg.png" class="h-18 w-auto object-contain" />
    </div>

    <div class="min-h-[300px] p-4 sm:col-span-6 sm:p-8">
      <h1 class="font-Inter text-4xl font-extrabold sm:text-5xl">
        Adding Articles
      </h1>
      <p class="mt-4 text-lg">
        Add new articles by entering the title, author, date, and content.
        Organize them with tags to make searching easier.
      </p>
    </div>
  </div>

  <!-- About Documentation -->
  <div id="about-documentation" ref="aboutSection" class="m-2 px-4">
    <h1 class="font-Inter text-3xl font-extrabold ">
      About Documentation
    </h1>
  </div>

  <div class="m-2 px-4">
    <p class="text-lg">
      Leadership and Governance in Higher Education: Roles and Responsibilities
      explores the key functions, structures, and challenges of leadership and
      governance within academic institutions. This documentation provides
      insights into the roles of administrators, faculty, and governing bodies
      in shaping policies, ensuring institutional effectiveness, and fostering
      academic excellence. Lorem ipsum dolor sit amet consectetur adipisicing
      elit. Modi illum doloribus pariatur quasi optio ipsum repellendus nostrum
      obcaecati. Sunt suscipit tempore necessitatibus sequi quasi aliquid quas
      adipisci animi earum autem! Lorem ipsum dolor, sit amet consectetur
      adipisicing elit. Quasi iste aperiam ipsam provident numquam obcaecati
      nihil blanditiis possimus labore at laborum magni dicta, nobis dolor sunt
      amet! Repellat, ea incidunt?
    </p>
  </div>

</template>
