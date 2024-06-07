<script setup lang="ts">
import { ArrowLeft } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
</script>

<template>
  <header
    class="sticky left-0 top-0 min-h-[44px] grid items-center py-1 w-full bg-dark_blue shadow-md"
  >
    <NuxtLayout name="main-layout" class="grid grid-cols-2 h-full items-center">
      <Button as-child variant="white" class="w-fit gap-0.5 justify-self-start">
        <NuxtLink
          v-if="
            $route.path.startsWith('/teacher/') &&
            !$route.path.startsWith('/teacher/courseId')
          "
          to="/teacher"
        >
          <ArrowLeft class="w-5" />
          Volver
        </NuxtLink>
      </Button>
    </NuxtLayout>
  </header>
  <NuxtLayout name="main-layout" as="main" class="py-5">
    <slot />
  </NuxtLayout>
</template>
