<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import { useCourseStore } from "@/store/useCourseStore";
import type { CourseType } from "@/types/models";

const store = useCourseStore();

const courseList: Ref<CourseType[]> = ref([]);
const loading: Ref<boolean> = ref(true);

const fetchCourses = async () => {
  loading.value = true;
  const students = await store.getCourses();
  courseList.value = students;
  loading.value = false;
};

onMounted(async () => {
  await fetchCourses();
});
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <ul class="grid gap-4 md:grid-cols-3 lg:grid-cols-4">
      <template v-if="!loading">
        <li v-for="(course, index) in courseList" :key="index" class="grid">
          <Button as-child variant="dark_blue" size="lg" classs="w-full">
            <NuxtLink :to="{ path: `/teacher/${course.id}` }">
              {{ course.description }}
            </NuxtLink>
          </Button>
        </li>
      </template>
      <template v-else>
        <li v-for="index in 20" :key="index">
          <Skeleton class="h-11 w-full rounded-md" />
        </li>
      </template>
    </ul>
  </NuxtLayout>
</template>
