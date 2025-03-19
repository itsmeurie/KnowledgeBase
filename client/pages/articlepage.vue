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


const items = ref([
  { label: "School of Academia", children: ["Overview"] },
  { label: "CED Office", children: ["Campus Executive Director", "Secretary", "Administrative Aide"] },
  { label: "CI Office", children: ["Campus Executive Director", "Secretary", "Administrative Aide"] },
  { label: "VP Office", children: ["Campus Executive Director" , "Secretary", "Administrative Aide"] },
  
]);

const openItems = ref([]);
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



<div class="m-1 grid gap-2 sm:grid-cols-10">
    <!-- Search Bar -->
    <div class="sm:col-span-2  rounded-md ml-6">
            <TInput
        icon="i-heroicons-magnifying-glass-20-solid"
        size="sm"
        color="white"
        :trailing="false"
        placeholder="Search here..."/>
    </div>

    <!-- Breadcrumbs -->
    <div class="sm:col-span-4 h-10 p-1 ml-[40px]" >

            <nav class="flex items-center space-x-2">
                <a href="http://127.0.0.1:8080/playground" class="text-gray-700 font-medium capitalized hover:text-blue-500">Home</a>
                <span>></span>
                <a href="http://127.0.0.1:8080/articlepage" class="text-gray-700 font-medium capitalized hover:text-blue-500">School of Academia</a>
            </nav>
    </div>

    <!-- Add and Edit Icon -->
    <div class="sm:col-span-2 h-10 flex items-center space-x-4">
        <TIcon name="i-heroicons-plus" class="w-5 h-5 cursor-pointer" />
        <TIcon name="i-heroicons-pencil-square" class="w-5 h-5 cursor-pointer"/>
    </div>


    <!-- More information -->
    <div class="sm:col-span-2 h-10">
        <p class="text-xl font-bold text-center ">More Information</p>
            <div class="mx-6 mt-4 ">
                     <hr class="border-gray-700" />
            </div>
    </div>
</div>



         
<div class="m-1 grid gap-2 sm:grid-cols-10">
        
    <!-- Accordion Navigation -->
    <div class="sm:col-span-2" >  
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
          <TIcon 
            :name="open ? 'i-heroicons-chevron-down' : 'i-heroicons-chevron-right'" 
            class="ml-2"
          />
        </TButton>
      </template>

      <template #item="{ item }">
        <ul v-if="item.children" class="pl-6 text-gray-600">
          <li v-for="child in item.children" :key="child">
            <TButton color="gray" 
            variant="link" block 
            class="flex justify-between items-center px-4 py-2 w-full text-left">
              {{ child }}
            </TButton>
          </li>
        </ul>
      </template>
    </TAccordion>
  </div>
    </div>

    <div class="col-span-6 grid grid-cols-1 gap-4 ">
        <div class="ml-1 grid gap-2">
        <!-- Title of Article -->
        <div class="col-span-1 flex items-center justify-center ml-8">
            <h1 class="text-black  font-Inter font-extrabold text-4xl p-4">School of Academia - Official Documentation</h1>
        </div>
        <!-- Last update -->
        <div class="col-span-1 min-h-[20px] w-200 ml-20">
            Last update 04/11/2025
        </div>

        <!-- No.1 --> 
        <div class="col-span-1">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-6">1. Introduction</h1>
        </div>

        <div class="col-span-1 ">
            <p class="ml-9">The borrower submits a loan application to the bank, either in person online, or through<br> other channels. The application Includes personal and financial information, such as<br> income, employment history, credit score, and the purpose of the loan</p>
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
    <div class="flex items-center ml-14">
        <TIcon name="tabler:book" class="text-lg mr-2"></TIcon>
        <h1 class="text-black-100 font-Inter font-semibold text-lg">
            Documents
        </h1>
    </div>
</div>
</div>


</template>