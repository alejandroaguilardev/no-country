<script setup lang="ts">
import { StudentCard } from "@/components/cards";
import { Badge } from "@/components/ui/badge";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
} from "@/components/ui/carousel";
import { Button } from "@/components/ui/button";
import { Dialog, DialogContent, DialogTrigger } from "@/components/ui/dialog";

// const route = useRoute();

const openEdit = ref(false);

const handleOpenEdit = () => {
  openEdit.value = true;
};

const handleCloseEdit = () => {
  openEdit.value = false;
};
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <!-- <p>{{ route.params.courseId }}</p>
    <h1>Students</h1> -->

    <div class="grid gap-4 max-w-[500px] mx-auto pb-[102px]">
      <Dialog v-for="(student, index) in 20" :key="index">
        <div class="grid grid-cols-[1fr_110px] items-center gap-2.5 p-0">
          <DialogTrigger as-child>
            <Button
              variant="dark_blue"
              class="justify-start text-center truncate md:justify-center inline-block md:inline py-1.5 text-xl shadow-lg"
            >
              Pepita martinez
            </Button>
          </DialogTrigger>

          <Badge
            v-if="!openEdit"
            variant="light_blue"
            class="w-full justify-self-end text-base text-foreground"
          >
            Retirado
          </Badge>

          <div v-if="openEdit" class="px-6 grid place-content-center h-full">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M18.988 2.01196L21.988 5.01196L19.701 7.29996L16.701 4.29996L18.988 2.01196ZM8 16H11L18.287 8.71296L15.287 5.71296L8 13V16Z"
                fill="#222222"
              />
              <path
                d="M19 19H8.158C8.132 19 8.105 19.01 8.079 19.01C8.046 19.01 8.013 19.001 7.979 19H5V5H11.847L13.847 3H5C3.897 3 3 3.896 3 5V19C3 20.104 3.897 21 5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 20.0391 21 19.5304 21 19V10.332L19 12.332V19Z"
                fill="#222222"
              />
            </svg>
          </div>

          <!-- <Badge
              :variant="
                getStudentStatusVariant(
                  student.retired.presence,
                  student.retired.status,
                )
              "
              class="w-full justify-self-end text-base text-foreground"
            >
              {{
                getStudentStatusText(
                  student.retired.presence,
                  student.retired.status,
                )
              }}
            </Badge> -->
        </div>

        <DialogContent
          class="h-screen max-w-full md:max-w-lg grid place-content-center md:h-fit p-6 rounded-none md:rounded-2xl"
        >
          <Carousel class="relative w-full max-w-md mx-auto">
            <CarouselContent>
              <CarouselItem v-for="(_, i) in 20" :key="i">
                <div class="p-1">
                  <StudentCard />
                </div>
              </CarouselItem>
            </CarouselContent>
            <CarouselPrevious class="left-12 md:left-0" />
            <CarouselNext class="right-12 md:right-0" />
          </Carousel>
        </DialogContent>
      </Dialog>
    </div>
  </NuxtLayout>
  <div
    class="fixed w-full bottom-0 py-5 grid px-4 bg-background border border-border shadow-lg"
  >
    <Button
      v-if="!openEdit"
      class="w-[150px] mx-auto text-xl font-normal"
      variant="green"
      @click="handleOpenEdit"
    >
      Editar
    </Button>
    <Button
      v-if="openEdit"
      class="w-fit mx-auto px-9 text-xl font-normal"
      variant="destructive"
      @click="handleCloseEdit"
    >
      Cancelar Edición
    </Button>
  </div>
</template>
