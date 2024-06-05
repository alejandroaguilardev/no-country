<script setup lang="ts">
import { toast } from "vue-sonner";

import { Badge } from "@/components/ui/badge";

import type { StudentType } from "@/types/models/student";

import { Drawer, DrawerContent, DrawerTrigger } from "@/components/ui/drawer";
import { useRetiredStore } from "@/store/useRetiredStore";
import { DialogTitle, DialogDescription } from "@/components/ui/dialog";

// TODO:
// Al abrir el modal mostrar la posicion del estudiante en el carousel para que no se repita

// En el index de teacher debe mostrarse la lista actualizada
// Actualizar la lista de estudiantes al usar handleRetired y handlePresence
// Condicional para mandar al formData 0 ó 1 al presionar editar.
// Form data no se envia correctamente
// Al editar mostrar la lista completa de la clase
// Añadir mensaje cuando no hay data

defineProps<{
  data: StudentType;
}>();

const store = useRetiredStore();

const handleRetired = async (studentId: number, studentFullName: string) => {
  const formData = new FormData();
  formData.append("status", "0");

  await store.retiredStudent(formData, studentId);

  toast("Se actualizó la lista", {
    description: `Se marcó a ${studentFullName} como retirado.`,
    action: {
      label: "Undo",
      onClick: () => console.log("Undo"),
    },
  });
};

const handlePresence = async (studentId: number, studentFullName: string) => {
  const formData = new FormData();

  formData.append("presence", "1");

  await store.presenceStudent(formData, studentId);

  toast("Se actualizó la lista", {
    description: `Se marcó a ${studentFullName} como ausente`,
    action: {
      label: "Cerrar",
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
        class="text-lg font-medium h-10 w-fit mx-auto px-6 shaddow-xl rounded-lg"
      >
        <DialogTitle class="text-inherit font-medium">
          {{ data.name }}
          {{ data.last_name }}
        </DialogTitle>
      </Badge>
    </div>
    <template v-if="data.retired.leave_alone === 0">
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
          <DialogDescription
            class="text-2xl text-foreground font-semibold mx-auto"
          >
            {{ data.authorized.name }}
            {{ data.authorized.last_name }}
          </DialogDescription>
        </div>
      </div>
    </template>
    <template v-else>
      <div
        class="grid p-4 mx-auto rounded-lg place-content-center bg-dark_blue w-[200px] h-[150px]"
      >
        <p class="text-center text-xl text-dark_blue-foreground">
          Se retira sin acompañante
        </p>
      </div>
    </template>
    <div class="grid gap-7">
      <div class="grid grid-cols-2 items-center gap-3">
        <DialogClose as-child>
          <Button
            variant="destructive"
            class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
            @click="handlePresence(data.id, data.name + ' ' + data.last_name)"
          >
            No asistió
          </Button>
        </DialogClose>

        <DialogClose as-child>
          <Button
            variant="green"
            class="rounded-md px-4 py-1 text-lg font-medium uppercase shadow-xl"
            @click="handleRetired(data.id, data.name + ' ' + data.last_name)"
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
              <p class="font-medium">{{ data.authorized.phone }}</p>
            </div>
            <div class="text-2xl pb-0 space-y-2 text-center">
              <p class="bg-[#C3DBC5]">Contacto apoderado:</p>
              <p class="font-medium">{{ data.tutor.phone }}</p>
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
</template>
