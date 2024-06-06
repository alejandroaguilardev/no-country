<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import { useAuthStore } from "@/store/useAuthStore";
import { useCourseStore } from "@/store/useCourseStore";
import type { CourseType } from "@/types/models";

const store = useCourseStore();
const { logout } = useAuthStore();

const courseList: Ref<CourseType[]> = ref([]);
const loading: Ref<boolean> = ref(true);
const error: Ref<boolean> = ref(false);
const fetchCourses = async () => {
  try {
    loading.value = true;
    const students = await store.getCourses();
    courseList.value = students;
    loading.value = false;
  } catch (err) {
    console.log("err=>", err);
    error.value = true;
  }
};

onMounted(async () => {
  await fetchCourses();
});
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <ul v-if="!error" class="grid gap-4 md:grid-cols-3 lg:grid-cols-4">
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
    <div v-else>
      <h1 class="text-xl text-destructive text-center">
        Ah ocurrido un error, intentelo más tarde
      </h1>
    </div>
  </NuxtLayout>
  <div
    class="fixed w-full bottom-0 py-5 grid px-4 bg-background border border-border shadow-lg"
  >
    <Button
      class="mx-auto text-lg font-normal"
      variant="green"
      @click="logout()"
    >
      Cerrar Sesión
    </Button>
  </div>
</template>
