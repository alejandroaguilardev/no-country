<script setup lang="ts">
import { StudentCard } from '@/components/card'
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious
} from '@/components/ui/carousel'
import type { StudentType } from '@/lib/types'

const students: StudentType[] = [
  {
    id: 1,
    studentName: 'PEPITO RODRIGUEZ',
    studentPhoto: 'student1',
    studentContact: '222 222 222',
    authorizedName: 'PEPITO RODRIGUEZ',
    authorizedContact: '999 999 999'
  },
  {
    id: 2,
    studentName: 'PEPITA MARTÍNEZ',
    studentPhoto: 'student2',
    studentContact: '333 333 333',
    authorizedName: 'JULITO RODRIGUEZ',
    authorizedContact: '666 666 666'
  }
]

</script>

<template>
  <div class="py-7 grid justify-center">
    <Carousel
      class="relative w-full grid items-center"
      :opts="{
        align: 'start',
        loop: true,
      }"
    >
      <CarouselPrevious class="left-0 top-1/2 grid !bg-transparent border-none" />
      <CarouselContent>
        <CarouselItem v-for="(student, index) in students" :key="index">
          <StudentCard :data="student" />
        </CarouselItem>
      </CarouselContent>
      <CarouselNext class="right-0 top-1/2 grid !bg-transparent border-none" />
    </Carousel>
  </div>
</template>
