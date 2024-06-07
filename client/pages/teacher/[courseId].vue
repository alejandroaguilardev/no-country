<script setup lang="ts">
import { ref, computed } from "vue";
import { StudentCard } from "@/components/cards";
import { Badge } from "@/components/ui/badge";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
} from "@/components/ui/carousel";
import { Button } from "@/components/ui/button";
import { Dialog, DialogContent } from "@/components/ui/dialog";

import { useAdminStudentsStore } from "@/store/useAdminStudentsStore";
import type { StudentType } from "@/types/models";
import { Skeleton } from "@/components/ui/skeleton";
import EditIcon from "@/components/icons/EditIcon.vue";

const route = useRoute();
const store = useAdminStudentsStore();

const studentList: Ref<StudentType[]> = ref([]);

const loading: Ref<boolean> = ref(true);
const editMode: Ref<boolean> = ref(false);
const dialog: Ref<boolean> = ref(false);
const targetStudentIndex: Ref<number> = ref(0);
const filteredStudentList: Ref<StudentType[]> = computed(() =>
  editMode.value
    ? studentList.value
    : studentList.value.filter(
        (student) =>
          student.retired.status === 0 && student.retired.presence === 1,
      ),
);

const fetchStudents = async () => {
  loading.value = true;
  const students = await store.getStudentsByCourse(route.params.courseId);
  studentList.value = students;
  loading.value = false;
};

const handleOpenEdit = () => {
  editMode.value = true;
};

const handleCloseEdit = () => {
  editMode.value = false;
};

const updateStudentStatus = (student: StudentType, status: 0 | 1) => {
  student.retired.status = status;
};

const updateStudentPresence = (student: StudentType, presence: 0 | 1) => {
  student.retired.presence = presence;
};

const isCourseRetired = computed(() => {
  const totalStudents = studentList.value.length;
  const totalRetired = studentList.value.filter(
    (student) => student.retired.status === 1 || student.retired.presence === 0,
  ).length;
  return totalStudents === totalRetired;
});

const openDialog = (index: number) => {
  dialog.value = true;
  targetStudentIndex.value = index;
};

onMounted(async () => {
  await fetchStudents();
});
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <div class="grid gap-4 max-w-[500px] mx-auto pb-[102px]">
      <template v-if="!loading">
        <div
          v-for="(student, index) in filteredStudentList"
          :key="index"
          class="grid grid-cols-[1fr_110px] items-center gap-2.5 p-0"
        >
          <Button
            variant="dark_blue"
            class="justify-start text-center truncate md:justify-center inline-block md:inline py-1.5 text-xl shadow-lg"
            @click="openDialog(index)"
          >
            <pre class="inline">{{ student.id }}</pre>
            {{ student.name }}
            {{ student.last_name }}
          </Button>

          <Badge
            v-if="!editMode"
            variant="light_blue"
            class="w-full justify-self-end text-base font-normal"
          >
            Por retirar
          </Badge>

          <div v-if="editMode" class="px-6 grid place-content-center h-full">
            <EditIcon />
          </div>
        </div>
        <Dialog v-model:open="dialog">
          <DialogContent
            class="h-screen max-w-full md:max-w-lg grid place-content-center md:h-fit p-6 rounded-none md:rounded-2xl"
          >
            <Carousel
              class="relative w-full max-w-md mx-auto"
              :opts="{
                startIndex: targetStudentIndex,
                loop: false,
              }"
            >
              <CarouselContent>
                <CarouselItem
                  v-for="(student, i) in filteredStudentList"
                  :key="i"
                >
                  <div class="p-1">
                    <StudentCard
                      :data="student"
                      @retired="updateStudentStatus(student, $event)"
                      @absent="updateStudentPresence(student, $event)"
                    />
                  </div>
                </CarouselItem>
              </CarouselContent>
              <CarouselPrevious class="left-12 md:left-0" />
              <CarouselNext class="right-12 md:right-0" />
            </Carousel>
          </DialogContent>
        </Dialog>

        <div v-if="isCourseRetired && !editMode">
          <p class="text-center">¡Excelente! El curso completo fue retirado</p>
        </div>
      </template>
      <template v-else>
        <div
          v-for="index in 20"
          :key="index"
          class="grid grid-cols-[1fr_110px] items-center gap-2.5 p-0"
        >
          <Skeleton class="h-10 w-full rounded-md" />
          <Skeleton class="h-[30px] w-full rounded-md" />
        </div>
      </template>
    </div>
  </NuxtLayout>
  <div
    class="fixed w-full bottom-0 py-5 grid px-4 bg-background border border-border shadow-lg"
  >
    <Button
      v-if="!editMode"
      class="mx-auto text-lg px-9 font-normal"
      variant="green"
      @click="handleOpenEdit"
    >
      Editar
    </Button>
    <Button
      v-if="editMode"
      class="mx-auto px-9 text-lg font-normal"
      variant="destructive"
      @click="handleCloseEdit"
    >
      Cancelar Edición
    </Button>
  </div>
</template>
