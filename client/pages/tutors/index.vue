<template>
  <div>
    <h2 class="text-3xl my-5">Apoderados</h2>
    <Table :columns="columns" :data="data" />
  </div>
</template>

<script setup lang="ts">
import Table from '@/pages/tutors/_components/Table.vue';
import { columns } from './_components/columns';
import type { Tutor } from './_components/interfaces/tutor';

const data: Tutor[] = [
  {
    id: 1,
    firstName: "John",
    lastName: "Ibarra",
    dni: "123456789",
    email: "johndoe@example.com",
    phone: "123-456-7890",
    students: [
      {
        id: 32,
        firstName: "Lautaro",
        lastName: "Ibarra",
        dni: "230456789",
        age: 9,
        course: "2A"
      },
      {
        id: 72,
        firstName: "Mariana",
        lastName: "Ibarra",
        dni: "532913123",
        age: 11,
        course: "3A"
      },
    ]
  },  
  {
    id: 2,
    firstName: "Gonzalo",
    lastName: "Gutierrez",
    dni: "123456789",
    email: "gonzagutierrez@example.com",
    phone: "312-456-7890",
    students: []
  },
]
</script>
