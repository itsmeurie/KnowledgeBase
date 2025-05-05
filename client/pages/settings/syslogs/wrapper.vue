<template>
  <TCard
    :ui="{
      base: 'border-none max-h-full',
      rounded: 'rounded-none',
      shadow: 'shadow-none',
      ring: '',
      header: {
        base: 'justify-start gap-2 h-16',
      },
      body: {
        base: 'flex flex-col gap-2 overflow-y-auto',
      },
    }"
  >
    <template #header>
      <slot name="header" />
    </template>
    <slot />
    <template #footer>
      <slot name="footer" />
    </template>
  </TCard>
</template>
