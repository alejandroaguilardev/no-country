<script setup lang="ts">
import { StudentCard } from "@/components/cards";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogTrigger } from "@/components/ui/dialog";
import { teacherService } from "@/services";

// const students: StudentType[] = [
//   {
//     id: 1,
//     studentName: "PEPITA MARTÍNEZ",
//     studentPhoto: "student1",
//     studentContact: "222 222 222",
//     studentGrade: "2B",
//     studentStatus: StudentStatusEnum.NO_WITHDRAWN,
//     authorizedName: "JUANITO MOYA",
//     authorizedContact: "+54 9 3513786543",
//     tutorContact: "+54 9 3515987234",
//   },
//   {
//     id: 2,
//     studentName: "PEPITO RODRIGUEZ",
//     studentPhoto: "student2",
//     studentContact: "333 333 333",
//     studentGrade: "2B",
//     studentStatus: StudentStatusEnum.NO_WITHDRAWN,
//     authorizedName: "PEDRO MAPACHO",
//     authorizedContact: "666 666 666",
//     tutorContact: "+54 9 3515987234",
//   },
//   {
//     id: 3,
//     studentName: "SANDRA MORÁN",
//     studentPhoto: "student2",
//     studentContact: "333 333 333",
//     studentGrade: "2B",
//     studentStatus: StudentStatusEnum.WITHDRAWN,
//     authorizedName: "JULITO RODRIGUEZ",
//     authorizedContact: "666 666 666",
//     tutorContact: "+54 9 3515987234",
//   },
//   {
//     id: 3,
//     studentName: "JULIO VANEGAS",
//     studentPhoto: "student2",
//     studentContact: "333 333 333",
//     studentGrade: "2B",
//     studentStatus: StudentStatusEnum.NO_ATTEND,
//     authorizedName: "JULITO RODRIGUEZ",
//     authorizedContact: "666 666 666",
//     tutorContact: "+54 9 3515987234",
//   },
//   {
//     id: 4,
//     studentName: "JUAN BIANCHI",
//     studentPhoto: "student2",
//     studentGrade: "2B",
//     studentContact: "333 333 333",
//     studentStatus: StudentStatusEnum.WITHDRAWN,
//     authorizedName: "JULITO RODRIGUEZ",
//     authorizedContact: "666 666 666",
//     tutorContact: "+54 9 3515987234",
//   },
// ];

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
            <!-- <Badge
              class="w-full justify-self-end bg-[#1D1B20]/30 text-base text-foreground"
            >
              {{ student.studentStatus }}
            </Badge> -->
          </div>
        </DialogTrigger>
        <DialogContent>
          <StudentCard :data="student" />
        </DialogContent>
      </Dialog>
    </div>
  </NuxtLayout>
</template>
