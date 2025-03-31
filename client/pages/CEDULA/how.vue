<script setup lang="ts"> 
import { createRouter, createWebHistory } from 'vue-router';
import WHY from './why.vue'; 
import WHERE from './where.vue'
import HOW from './how.vue'


const routes = [
  { path: '/why', component: WHY },
  { path: '/why', component: WHERE },
  { path: '/why', component: HOW },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const link = [{
  label: 'CMO',
  icon: 'i-heroicons-home',
  to: 'articlepage'
}, 
  {
  label: 'How to get Cedula',
  icon: 'i-heroicons-document-text',
}]

const linksNav = [{
  label: 'Home',
  to: '/playground'
}, {
  label: 'Docs',
  to: '/articlepage'
}, {
  label: 'About',
  to: 'playground#about-documentation'
}]

const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

const items = ref([
  { 
    label: "CEDULA", 
    children: [
    { label: "Why do we need Cedula", to: "/why" },
      { label: "Where to use", to: "/where" },
      { label: "How to get Cedula ", to: "/how" }
    ] 
  },
  { 
    label: "CI Office", 
    children: [
      { label: "Campus Executive Director" },
      { label: "Secretary" },
      { label: "Administrative Aide" }
    ] 
  },
  { 
    label: "VP Office", 
    children: [
      { label: "Campus Executive Director" },
      { label: "Secretary" },
      { label: "Administrative Aide" }
    ] 
  },
]);

const openItems = ref([]);
</script>



<template>
<!-- Header -->
<div class="flex flex-wrap items-center justify-between px-4  gap-4 m-1">
        <!-- Logo -->
        <div class="flex items-center">
            <img class="h-20 w-20 object-contain mt-6" src="@/assets/image/final-logo.png"/>
              <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Knowledge Base</p>
        </div>


        <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>

        <!-- Navigation -->
        <div class="w-full sm:w-auto col-span-3 flex justify-center">
          <THorizontalNavigation :links="linksNav"> <!-- Inayos-->
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
         
<div class="m-1 grid gap-2 sm:grid-cols-10">
        
    <!-- Accordion Navigation -->
    <div class="sm:col-span-2" > 
      
      <!-- Search Bar -->
      <div class="sm:col-span-2  rounded-md ml-6">
                <TInput
            icon="i-heroicons-magnifying-glass-20-solid"
            size="sm"
            color="white"
            :trailing="false"
            placeholder="Search here..."/>
        </div>

    <!-- title -->
    <div class="flex flex-col justify-center ml-7 mt-3">
      <h6>City Mayors Office</h6>
    </div>

        <div class="w-64 m-3">
       <TAccordion v-model:open="openItems" :items="items" multiple>
          <template #default="{ item, open }">
            <TButton 
              color="gray" 
              variant="ghost" 
              block 
              class="flex justify-between items-center px-4 py-2 w-full text-left"
            >
              <span>{{ item.label }}</span>
              <TIcon :name="open ? 'i-heroicons-chevron-down' : 'i-heroicons-chevron-right'" class="ml-2"/>
            </TButton>
          </template>

          <template #item="{ item }">
            <ul v-if="item.children" class="pl-6 text-gray-600">
              <li v-for="child in item.children" :key="child.label">
                <router-link v-if="child.to" :to="child.to">
                  <TButton color="gray" variant="link" block class="flex justify-between items-center px-4 py-2 w-full text-left">
                    {{ child.label }}
                  </TButton>
                </router-link>
                <TButton v-else color="gray" variant="link" block class="flex justify-between items-center px-4 py-2 w-full text-left">
                  {{ child.label }}
                </TButton>
              </li>
            </ul>
          </template>
      </TAccordion>
  </div>
    </div>

    <div class="col-span-6 grid grid-cols-1 gap-4 ">

      <div class="flex flex-wrap items-center justify-between px-4 sm:px-10 py-2 gap-4">
                    <!-- Breadcrumbs -->
            <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
              <TBreadcrumb :links="link" />
            </nav>  

            <!-- Edit Icon -->
            <div class="flex items-center space-x-4">
              <TIcon name="i-heroicons-pencil-square" class="w-5 h-5 cursor-pointer text-gray-600 hover:text-black transition"/>
            </div>  
        </div>

        <div class="ml-1 grid gap-2">
        <!-- Title of Article -->
        <div class="col-span-1   ml-5">
            <h1 class="text-black  font-Inter font-extrabold text-4xl p-4">How to Obtain a Cedula</h1>
        </div>
        <!-- Last update -->
        <div class="col-span-1 min-h-[20px] w-200 ml-20">
            Last update 04/18/2025
        </div>

        <!-- No.1 --> 
        <div class="col-span-1">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-6">Introduction</h1>
        </div>

        <div class="col-span-1 ">
            <p class="ml-9">The Cedula, also known as the Community Tax Certificate (CTC), is a document issued by local government units as proof of payment of the community tax. It is often required for various government transactions, legal documents, employment, and business purposes. The process of obtaining a Cedula is simple and can be completed within a few minutes at the designated government offices.<br> This guide provides a step-by-step process on how individuals and businesses can secure a Cedula, including the requirements, fees, and frequently asked questions regarding its issuance.</p>
        </div>


        <!-- No.2 -->
        <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">2. Mission Statement</h1>
        </div>
        <div class="col-span-1">
            <p class="ml-9 bg-color-gray-500">The School of Academia is committed to delivering high-quality education, equipping individuals with critical thinking skills, and preparing them for success in their respective domains. The institution strives to provide a holistic educational experience through the integration of modern teaching methodologies, research opportunities, and cross-disciplinary collaboration.<br>
                            <br>
                            Core Values<br>
                            <br>
                        <ul class="list-disc ml-9">
                           <li> Academic Excellence: Maintaining rigorous academic standards and a comprehensive curriculum.<br></li>
                           <li>Innovation and Research: Encouraging exploration, creativity, and groundbreaking discoveries.<br></li>
                           <li>Diversity and Inclusion: Cultivating a welcoming and inclusive environment for individuals from diverse backgrounds.<br></li>
                           <li>Lifelong Learning: Promoting continuous education, professional development, and adaptability.<br></li>
                        </ul>
            </p>
        </div>

        <!-- No.3 -->
        <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">3. Institutional Features</h1>
        </div>
            <div class="col-span-1">
                <p class="ml-9 bg-color-gray-500">The School of Academia offers a structured academic framework designed to enhance learning and professional readiness. The key features of the institution include:<br>
                            <br>
                    <ul class="list-decimal ml-9">
                         <li>Curriculum and Academic Programs<br>
                                <ul class="list-disc ml-9">
                                    <li>A broad range of subjects across multiple disciplines, including humanities, sciences, technology, and business.</li>
                                    <li>Specialized programs tailored to meet industry standards and contemporary educational needs.</li>
                                    <li>Flexible learning options, including on-campus, online, and hybrid courses.</li>
                                </ul>
                         </li>
                           <li>Faculty and Educational Leadership<br>
                                <ul class="list-disc ml-9">
                                    <li>Highly qualified educators, industry professionals, and academic mentors.</li>
                                    <li>Faculty-led research initiatives and mentorship programs.</li>
                                    <li>Commitment to pedagogical innovation and student-centered learning approaches.</li>
                                </ul>
                           </li>
                           <li>Research and Development<br>
                                <ul class="list-disc ml-9">
                                    <li>Highly qualified educators, industry professionals, and academic mentors.</li>
                                    <li>Faculty-led research initiatives and mentorship programs.</li>
                                    <li>Commitment to pedagogical innovation and student-centered learning approaches.</li>
                                </ul>    
                            </li>
                           <li>Community and Global Outreach<br>
                                    <ul class="list-disc ml-9">
                                        <li>Highly qualified educators, industry professionals, and academic mentors.</li>
                                        <li>Faculty-led research initiatives and mentorship programs.</li>
                                        <li>Commitment to pedagogical innovation and student-centered learning approaches.</li>
                                    </ul>
                           </li>
                    </ul>
                </p>
            </div>
        </div>
    </div>

   <!-- Documents -->
<div class="sm:col-span-2">
  <!-- More information -->
  <div class="sm:col-span-2 h-10">
        <p class="text-xl font-bold text-center ">More Information</p>
            <div class="mx-6 mt-4 ">
                     <hr class="border-gray-700" />
            </div>
    </div>
    <div class="flex justify-center">
        <TIcon name="tabler:book" class="text-lg mr-2 mt-1.5"></TIcon>
        <h1 class="text-black-100 font-Inter font-semibold text-lg">
            Documents
        </h1>
    </div>
  </div>
</div>


</template>