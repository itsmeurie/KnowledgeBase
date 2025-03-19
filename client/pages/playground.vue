<script setup lang="ts"> 

const links = [{
  label: 'Home',
  to: '/playground'
}, {
  label: 'Docs',
  to: '/articlepage'
}, {
  label: 'About',
  to: '/components/table'
}]


</script>


<template>
<!-- Header -->
<div class="mx-2 grid gap-4 sm:grid-cols-8">
  <div class="col-span-1 flex h-[100px] w-[200px] items-center">
    <p class="font-Inter ml-[10px] text-left text-3xl font-extrabold text-black">Dokumentaryo</p>
  </div>

  <div class="col-span-1 h-[100px] w-[200px]"></div>
  <div class="col-span-1 h-[100px] w-[200px]"></div>
  <div class="col-span-1 h-[100px] w-[200px]"></div>
  <div class="col-span-1 h-[100px] w-[200px]"></div>

  <!-- Navigation -->
  <div class="col-span-3">
    <THorizontalNavigation :links="links">
        <template #default="{ link }">
            <span class="text-lg mt-5 mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
        </template>
    </THorizontalNavigation>
  </div>
</div>

<!-- Get Stared and Image -->
<div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <div class="sm:col-span-6 min-h-[370px] ">
        <h1 class="text-black-100 text-left-center my-4 ms-25 mt-[50px] font-Inter font-extrabold text-5xl m-20">Leadership and <br>Governance in Higher<br> Education: Roles and <br>Responsibilities</h1>
        <p class="ml-20 ">A centralized platform for obtaining knowledge on <br> system documentation.</p>
        <button class="bg-black-500 hover:bg-green-300 text-gray-500 font-bold py-2 px-4 rounded-full border-2 text-center ml-[75px] w-30 h-10 mt-6 justify-center">Get Started</button>

    </div>
    
    <!-- image -->
    <div class="sm:col-span-4 min-h-[100px]">
        <img src="@/assets/image/image.png" class='h-[250px] ml-[20px] scale-150 object-contain mt-[60px] ' />
    </div>
   
</div>



<div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-10">
    <div class="sm:col-span-4 min-h-[300px]">
        <div class="sm:col-span-4 min-h-[100px]">
            <img src='@/assets/image/bgg.png' class='h-[290px] ml-[100px] scale-150 object-contain mt-[60px] ' />
        </div>
    </div>

    <div class="sm:col-span-6 min-h-[300px] mt-[50px] ">
        <h1 class="text-black-100 text-left-center my-4 ms-25 mt-[50px] font-Inter font-extrabold text-5xl m-20">Adding Articles</h1>
        <p class="ml-20 ">Add new articles by entering the title, author, date,<br> and content. Organize them with tags to make<br> searching easier.</p>
    </div>
</div>


<div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-1">
    <div class=" min-h-[5px] ml-[40px]">
        <h1 class="text-black-100 text-left-center my-4 ms-25 mt-[50px] font-Inter font-extrabold text-3xl m-10">About Documentation</h1>
    </div>
</div>

<div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-1">
    <div class=" min-h-[200px]">
        <p class="ml-20 ">Leadership and Governance in Higher Education: Roles and Responsibilities explores the key functions,< structures, and challenges of leadership and governance within academic institutions. This documentation provides insights into the roles of administrators, faculty, and governing bodies in shaping policies, ensuring institutional effectiveness, and fostering academic excellence.
            It covers topics such as strategic planning, decision-making processes, stakeholder engagement, regulatory compliance, and the impact of governance models on institutional success. Designed for educators, administrators, and policymakers, this resource serves as a guide to understanding best practices and emerging trends in higher education leadership.</p>
    </div>
</div>

<div class="m-2 grid grid-cols-1 gap-4 sm:grid-cols-1">
    <div class=" min-h-[150px] round-lg shadow bg-green-500">
        <h1> Basic info</h1>
    </div>
</div>


</template>