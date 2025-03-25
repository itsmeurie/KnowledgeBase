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
  { 
    label: "CEDULA", 
    children: [
      { label: "Why do we need Cedula", to: "/why" },
      { label: "Where to use", to: "/where" },
      { label: "How to get Cedula", to: "/how" }
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
  { label: "School of Academia", children: ["Overview"] },
  { 
    label: "CED Office", 
    children: [
      { label: "Campus Executive Director", to: "/ced" },
      { label: "Secretary", to: "/secretary" },
      { label: "Administrative Aide", to: "/administrative-aide" }
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
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
            <!-- Logo -->
            <div class="flex items-center min-w-48 ">
              <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
            </div>
  
            <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-[100px]"></div>
            <div class="hidden sm:block col-span-1 h-[100px]"></div>
            <div class="hidden sm:block col-span-1 h-[100px]"></div>
            <div class="hidden sm:block col-span-1 h-[100px]"></div>
  
            <!-- Navigation -->
            <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
              <THorizontalNavigation :links="links">
                <template #default="{ link }">
                  <span class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
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
  
        <div class="flex gap-40 ">
              <!-- Breadcrumbs -->
            <div class=" flex flex-wrap sm:col-span-4 h-10 p-1 ml-10" >
                    <nav class="flex items-center space-x-2">
                        <a href="http://127.0.0.1:8080/playground" class="text-gray-700 font-medium capitalized hover:text-blue-500">City Mayors Office</a>
                        <span>></span>
                        <a href="http://127.0.0.1:8080/articlepage" class=" flex flex-wrap text-gray-700 font-medium capitalized hover:text-blue-500">Why do we need Cedula</a>
                    </nav>
            </div>
                      <!--Edit Icon -->
                      <div class="sm:col-span-2 h-10 flex items-center space-x-5">
                          <TIcon name="i-heroicons-pencil-square" class="w-5 h-5 cursor-pointer"/>
                      </div>
        </div>
  
          <div class="ml-1 grid gap-2">
          <!-- Title of Article -->
          <div class="col-span-1   ml-5">
              <h1 class="text-black  font-Inter font-extrabold text-4xl p-4">City Mayor's Office</h1>
          </div>
          
          <!-- Last update -->
          <div class="col-span-1 min-h-[20px] w-200 ml-20">
              Last update 04/18/2025
          </div>
  
          <!-- Article -->
          <div class="col-span-1">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-6">What is a Cedula?</h1>
          </div>
  
          <div class="col-span-1 ">
              <p class="ml-9">A Cedula is an official document issued by the local government unit (LGU) through the City or Municipal Treasurer’s Office. It serves as proof that an individual or business has paid the community tax, which is imposed on residents, professionals, and business owners within a locality.</p>
          </div>
  
  
          <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">Why is a Cedula Necessary?</h1>
          </div>
          <div class="col-span-1 ">
              <p class="ml-9">The Cedula is required for several purposes, including but not limited to:</p>
          </div>
          <div class="col-span-1">
            <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">1. Proof of Identity and Residency</h1>
          </div>
                          <ul class="list-disc ml-9">
                             <li>The Cedula serves as a supplementary identification document for individuals who may not have other government-issued IDs.<br></li>
                             <li>It is often required when applying for local government services or assistance.</li>
                          </ul>
          </div>
  
          <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">2. Requirement for Government Transactions</h1>
          </div>
              <div class="col-span-1">
                      <ul class="list-decimal ml-9">
                                  <ul class="list-disc ml-9">
                                      <li>Various government offices require a Cedula when processing barangay clearance, police clearance, and business permits.</li>
                                      <li>It is also needed when securing certain certifications and official documents.</li>
                                      <li>Flexible learning options, including on-campus, online, and hybrid courses.</li>
                                  </ul>
                      </ul>
                      
              </div>
  
              <div class="col-span-1">
            <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">3. Proof of Identity and Residency</h1>
          </div>
                          <ul class="list-disc ml-9">
                             <li>The Cedula serves as a supplementary identification document for individuals who may not have other government-issued IDs.<br></li>
                             <li>It is often required when applying for local government services or assistance.</li>
                          </ul>
          </div>
  
          <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">4. Requirement for Government Transactions</h1>
          </div>
              <div class="col-span-1">
                      <ul class="list-decimal ml-9">
                                  <ul class="list-disc ml-9">
                                      <li>Various government offices require a Cedula when processing barangay clearance, police clearance, and business permits.</li>
                                      <li>It is also needed when securing certain certifications and official documents.</li>
                                      <li>Flexible learning options, including on-campus, online, and hybrid courses.</li>
                                  </ul>
                      </ul>
                      
              </div>
  
              <div class="col-span-1">
            <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">6. Proof of Identity and Residency</h1>
          </div>
                          <ul class="list-disc ml-9">
                             <li>The Cedula serves as a supplementary identification document for individuals who may not have other government-issued IDs.<br></li>
                             <li>It is often required when applying for local government services or assistance.</li>
                          </ul>
          </div>
  
          <!-- No.3 -->
          <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">7. Requirement for Government Transactions</h1>
          </div>
              <div class="col-span-1">
                      <ul class="list-decimal ml-9">
                                  <ul class="list-disc ml-9">
                                      <li>Various government offices require a Cedula when processing barangay clearance, police clearance, and business permits.</li>
                                      <li>It is also needed when securing certain certifications and official documents.</li>
                                      <li>Flexible learning options, including on-campus, online, and hybrid courses.</li>
                                  </ul>
                      </ul>
                      
              </div>
  
              <div class="col-span-1">
            <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">8. Proof of Identity and Residency</h1>
          </div>
                          <ul class="list-disc ml-9">
                             <li>The Cedula serves as a supplementary identification document for individuals who may not have other government-issued IDs.<br></li>
                             <li>It is often required when applying for local government services or assistance.</li>
                          </ul>
          </div>
  
          <!-- No.3 -->
          <div class="col-span-1 ">
              <h1 class="text-black  font-Inter font-semibold text-2xl p-4">9. Requirement for Government Transactions</h1>
          </div>
              <div class="col-span-1">
                      <ul class="list-decimal ml-9">
                                  <ul class="list-disc ml-9">
                                      <li>Various government offices require a Cedula when processing barangay clearance, police clearance, and business permits.</li>
                                      <li>It is also needed when securing certain certifications and official documents.</li>
                                      <li>Flexible learning options, including on-campus, online, and hybrid courses.</li>
                                  </ul>
                      </ul>
                      
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