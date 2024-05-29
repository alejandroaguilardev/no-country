<script setup lang="ts">
import { StudentCard } from "@/components/cards";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogTrigger } from "@/components/ui/dialog";
import { getStudentStatusText, getStudentStatusVariant } from "@/lib/utils";
import { teacherService } from "@/services";

const { getAllStudents } = teacherService();

const students = await getAllStudents();

console.log("students lists=>", students);
</script>

<template>
  <NuxtLayout name="teacher-layout">
    <div class="grid gap-4 py-7 max-w-[500px] mx-auto">
      <Dialog v-for="(student, index) in students" :key="index">
        <DialogTrigger as-child>
          <div class="grid grid-cols-[1fr_110px] items-center gap-2.5 p-0">
            <Badge
              variant="default"
              class="justify-start truncate md:justify-center inline-block md:inline py-1.5 bg-[#1D1B20]/30 text-xl text-foreground shadow-lg"
            >
              {{ student.name }}
              {{ student.last_name }}
            </Badge>
            <Badge
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
            </Badge>
          </div>
        </DialogTrigger>
        <DialogContent>
          <StudentCard :data="student" />
        </DialogContent>
      </Dialog>
      <Button>Editar</Button>
    </div>
  </NuxtLayout>
</template>
