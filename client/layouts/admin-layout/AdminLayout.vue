<template>
  <AdminNav />
  <NuxtLayout name="main-layout" as="main" class="mt-20">
    <slot />
  </NuxtLayout>
</template>
<script lang="ts" setup>
import AdminNav from "@/components/nav/AdminNav.vue";
</script>
