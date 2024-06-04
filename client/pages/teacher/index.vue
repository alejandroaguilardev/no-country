<script setup lang="ts">
import { Button } from "@/components/ui/button";
// import { getStudentStatusText, getStudentStatusVariant } from "@/lib/utils";
// import { courseService } from "@/services";

// const { getAllCourses } = courseService();

// const courses = await getAllCourses();

// console.log("courses lists=>", courses);
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <ul class="grid gap-4 md:grid-cols-3 lg:grid-cols-4">
      <li class="grid">
        <Button as-child variant="dark_blue" size="lg" classs="w-full">
          <NuxtLink :to="{ path: `/teacher/1` }">1° A</NuxtLink>
        </Button>
      </li>
      <li class="grid">
        <Button as-child variant="dark_blue" size="lg" classs="w-full">
          <NuxtLink :to="{ path: `/teacher/2` }">1° B</NuxtLink>
        </Button>
      </li>
    </ul>
  </NuxtLayout>
</template>
