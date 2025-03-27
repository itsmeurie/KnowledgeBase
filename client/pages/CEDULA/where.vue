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

const links = [{
  label: 'Home',
  to: '/playground'
}, {
  label: 'Docs',
  to: '/articlepage'
}, {
  label: 'About',
  to: 'playground#about-documentation'
}]


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
<div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
          <!-- Logo -->
          <div class="flex items-center min-w-48 ">
            <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
          </div>

           <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
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
      
      <div class="flex flex-wrap items-center justify-between px-4 sm:px-10 py-2 gap-4">
                    <!-- Breadcrumbs -->
            <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
                <a href="http://127.0.0.1:8080/playground" class="text-gray-700 font-medium capitalize hover:text-blue-500">
                  City Mayors Office
                </a>
                <span class="text-gray-500">></span>
                <a href="http://127.0.0.1:8080/articlepage" class="text-gray-700 font-medium capitalize hover:text-blue-500">
                  Why do we need Cedula
                </a>
            </nav>  

            <!-- Edit Icon -->
            <div class="flex items-center space-x-4">
              <TIcon name="i-heroicons-pencil-square" class="w-5 h-5 cursor-pointer text-gray-600 hover:text-black transition"/>
            </div>  
        </div>


        <div class="ml-1 grid gap-2">
        <!-- Title of Article -->
        <div class="col-span-1   ml-5">
            <h1 class="text-black  font-Inter font-extrabold text-4xl p-4">The Essential Uses of the Cedula</h1>
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
            <p class="ml-9">The Community Tax Certificate (CTC), commonly known as the Cedula, is a crucial document in the Philippines, serving multiple legal, administrative, and financial purposes. It is issued by local government units through the City or Municipal Treasurer’s Office and is a primary requirement for individuals and businesses when conducting transactions with government agencies and private institutions Despite the increasing use of other government-issued identification cards, the Cedula remains an essential document for various official functions. Understanding where and how it is used can help citizens efficiently navigate administrative processes and ensure compliance with local tax obligations.</p>
        </div>


        
        <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">Legal Basis of the Cedula</h1>
        </div>
        <div class="col-span-1">
              <p class="ml-9 bg-color-gray-500">The issuance and use of the Cedula are mandated by Section 164 of the Local Government Code of 1991 (Republic Act No. 7160), which states that every resident of the Philippines who is at least eighteen (18) years old and has an annual income must secure a Community Tax Certificate. Business entities are also required to obtain a Cedula as part of their tax obligations. The Cedula is valid for one calendar year and must be renewed annually. It serves as proof of community tax payment and is widely used in various personal, business, and government-related transactions.<br>
             </p>
        </div>

        <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">Where is the Cedula Used?</h1>
        </div>
        <div class="col-span-1">
              <p class="ml-9 bg-color-gray-500">The Cedula is required in numerous official transactions and is widely accepted as a form of identification, tax compliance, and legal certification. Below are the key areas where the Cedula is commonly used:</p>
        </div>

        <!-- No.1 -->
        <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">1. Personal Identification and Residency Verification</h1>
        </div>
            <div class="col-span-1">
                <p class="ml-9 bg-color-gray-500">One of the primary uses of the Cedula is as an additional form of identification, especially for individuals who do not possess other government-issued IDs such as a passport, driver’s license, or national ID. While it is not a primary identification document, it is often required for various local transactions, including:<br>
                           <br>
                                <ul class="list-disc ml-9">
                                    <li>Applying for government assistance programs (e.g., financial aid, social services)</li>
                                    <li>Enrolling in educational institutions (especially in public schools and universities)</li>
                                    <li>Applying for housing programs and real estate transactions</li>
                                    <li>Processing loans and financial assistance applications</li>
                                </ul>
                </p>
            </div>

            <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">2. Government Transactions and Clearance Requirements</h1>
        </div>
            <div class="col-span-1">
                <p class="ml-9 bg-color-gray-500">Many local and national government agencies require individuals to present a Cedula when processing official documents. It serves as proof that the applicant has paid the required community tax and is a recognized member of the community. Some of the most common government transactions that require a Cedula include:<br>
                           <br>
                                <ul class="list-disc ml-9">
                                    <li>Barangay Clearance – Before an individual can obtain a barangay clearance, which is required for employment, business permits, or police clearance, they must first secure a Cedula.</li>
                                    <li>Police Clearance – Law enforcement agencies often require a Cedula as part of the application process for police clearance, which is necessary for job applications, travel requirements, and legal purposes.</li>
                                    <li>NBI Clearance – While not always required, some National Bureau of Investigation (NBI) branches may ask for a Cedula as a supporting document when applying for an NBI Clearance.</li>
                                    <li>Business Permits and Licenses – Entrepreneurs and business owners must secure a Cedula when applying for or renewing business permits. The Cedula serves as proof of tax payment and legal identity verification.</li>
                                    <li>Marriage License Application – Some local civil registrars require a Cedula when applying for a marriage license, ensuring that both parties are legitimate residents of the area where they intend to marry.</li>
                                    <li>Passport Application and Renewal – While not a primary requirement, some passport processing offices may accept the Cedula as a supplementary document to verify an applicant's identity.</li>
                                    
                                </ul>
                </p>
            </div>


            <div class="col-span-1 ">
            <h1 class="text-black  font-Inter font-semibold text-2xl p-4">3. Legal and Notarial Purposes</h1>
        </div>
            <div class="col-span-1">
                <p class="ml-9 bg-color-gray-500">The Cedula is widely used in legal transactions, particularly for notarization of documents. When signing important legal documents, individuals are often required to indicate their Cedula number as proof of identity and legal acknowledgment. Some of the legal documents that require a Cedula include:<br>
                           <br>
                                <ul class="list-disc ml-9">
                                    <li>Affidavits and Sworn Statements – Any legal declaration, such as an affidavit of loss, affidavit of support, or affidavit of residency, requires the presentation of a Cedula.</li>
                                    <li>Contracts and Agreements – Business contracts, lease agreements, and property sales agreements often require the Cedula for notarization.</li>
                                    <li>Legal Complaints and Court Filings – Some courts require complainants or petitioners to include their Cedula details when filing a case or legal petition.</li>
                                    <li>Authorization Letters and Special Power of Attorney (SPA) – When authorizing someone to act on behalf of another person, a Cedula is often required for verification.</li>
                                    
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