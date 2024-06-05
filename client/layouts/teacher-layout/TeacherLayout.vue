<template>
  <header class="sticky left-0 top-0 h-[40px] w-full bg-dark_blue shadow-md">
    <NuxtLayout name="main-layout"> </NuxtLayout>
  </header>
  <NuxtLayout name="main-layout" as="main" class="py-5">
    <slot />
  </NuxtLayout>
</template>
