<script setup lang="ts">
import { toast } from "vue-sonner";
import { Badge } from "@/components/ui/badge";
import { teacherService } from "@/services";
import type { StudentType } from "@/types/models/student";

import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerTrigger,
} from "@/components/ui/drawer";

defineProps<{
  data: StudentType;
}>();

const { retiredStudent, presenceStudent } = teacherService();

const handleRetired = async (studentId: number, studentFullName: string) => {
  const formData = new FormData();
  formData.append("status", "0");

  await retiredStudent(formData, studentId);

  toast("Event has been created", {
    description: `Estudiante ${studentFullName} marcado como retirado.`,
    action: {
      label: "Undo",
      onClick: () => console.log("Undo"),
    },
  });
};

const handlePresence = async (studentId: number, studentFullName: string) => {
  const formData = new FormData();
  formData.append("presence", "0");

  await presenceStudent(formData, studentId);

  toast("Event has been created", {
    description: `Estudiante ${studentFullName} marcado como ausente.`,
    action: {
      label: "Undo",
      onClick: () => console.log("Undo"),
    },
  });
};
</script>

<template>
  <div class="grid aspect-square px-16 gap-4">
    <div class="grid gap-5 text-center">
      <Badge
        variant="light_blue"
        class="text-lg font-medium uppercase h-10 w-fit mx-auto px-6 shaddow-xl rounded-lg"
      >
        Pepita Martinez
      </Badge>
    </div>
    <div class="grid gap-3 mb-5">
      <p class="text-center text-xl font-medium">Lo retira:</p>
      <figure class="relative mx-auto h-[200px] w-[200px]">
        <img
          src="@/assets/images/student-2.png"
          class="h-full w-full rounded-full object-cover"
          decoding="async"
          loading="lazy"
        />
      </figure>
      <div class="grid">
        <p class="text-xl font-bold mx-auto uppercase">Juanito Montoya</p>
      </div>
    </div>
    <div class="grid gap-7">
      <div class="grid grid-cols-2 items-center gap-3">
        <DialogClose as-child>
          <Button
            variant="destructive"
            class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
          >
            No asistió
          </Button>
        </DialogClose>

        <DialogClose as-child>
          <Button
            variant="green"
            class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
          >
            Retirado
          </Button>
        </DialogClose>
      </div>
      <Drawer>
        <DrawerTrigger as-child>
          <Button
            size="xs"
            variant="dark_blue"
            class="w-fit font-normal mx-auto rounded-md text-base px-5"
          >
            Contacto
          </Button>
        </DrawerTrigger>
        <DrawerContent class="">
          <div class="mx-auto pt-6 pb-4 space-y-2 w-full">
            <div class="text-2xl pb-0 space-y-2 text-center">
              <p class="bg-[#C3DBC5]">Contacto autorizado:</p>
              <p class="font-medium">+54 9 3513786543</p>
            </div>
            <div class="text-2xl pb-0 space-y-2 text-center">
              <p class="bg-[#C3DBC5]">Contacto apoderado:</p>
              <p class="font-medium">+54 9 3513786543</p>
            </div>
          </div>
        </DrawerContent>
      </Drawer>

      <DialogClose as-child>
        <Button
          variant="link"
          class="mx-auto shadow-none block w-fit italic underline"
        >
          Ver lista completa
        </Button>
      </DialogClose>
    </div>
  </div>
  <!-- <div class="grid aspect-square p-1 gap-4">
    <div class="grid gap-5 text-center">
      <div
        v-if="data.name"
        class="rounded-md bg-[#1D1B20]/40 px-4 py-1.5 shadow-xl"
      >
        <p class="text-lg font-medium uppercase">
          {{ data.name }}
          {{ data.last_name }}
        </p>
      </div>
      <div
        v-if="data.course.description"
        class="flex items-center justify-between gap-16"
      >
        <p class="text-lg font-medium">Grado:</p>
        <Badge
          variant="secondary"
          class="bg-[#1D1B20]/40 px-5 text-lg font-bold"
        >
          {{ data.course.description }}
        </Badge>
      </div>
    </div>
    <div class="grid gap-3">
      <p class="text-center text-xl font-medium">Lo retira:</p>
      <figure
        v-if="data.authorized.photo"
        class="relative mx-auto h-[150px] w-[150px]"
      >
        <img
          src="@/assets/images/student-2.png"
          class="h-full w-full rounded-full object-cover"
          decoding="async"
          loading="lazy"
        />
      </figure>
      <div
        v-if="data.authorized.name"
        class="rounded-md bg-[#1D1B20]/20 px-4 py-1.5 text-center shadow-xl"
      >
        <p class="text-lg font-medium uppercase">
          {{ data.authorized.name }}
          {{ data.authorized.last_name }}
        </p>
      </div>
    </div>
    <div>
      <div class="mb-3 space-y-1">
        <div v-if="data.authorized.phone" class="text-center">
          <p class="text-lg">Contacto autorizado:</p>
          <p class="font-medium text-sm">
            {{ data.authorized.phone }}
          </p>
        </div>
        <div v-if="data.tutor.phone" class="text-center">
          <p class="text-lg">Contacto apoderado:</p>
          <p class="font-medium text-sm">
            {{ data.tutor.phone }}
          </p>
        </div>
      </div>
      <div class="grid grid-cols-2 items-center gap-3">
        <Button
          class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
          @click="handlePresence(data.id, `${data.name} + ${data.last_name}`)"
        >
          No asistió
        </Button>
        <Button
          :disabled="data.retired.presence === 0"
          class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
          @click="handleRetired(data.id, `${data.name} + ${data.last_name}`)"
        >
          Retirado
        </Button>
      </div>
      <DialogClose as-child>
        <Button variant="link" class="mx-auto block w-fit italic underline">
          Ver lista completa
        </Button>
      </DialogClose>
    </div>
  </div> -->
</template>
