<template>
  <div>
    <h2 class="text-3xl my-5">Estudiantes</h2>
    <Table :columns="columns" :data="data" />
  </div>
</template>

<script setup lang="ts">
import Table from '@/pages/students/_components/Table.vue';
import { columns } from './_components/columns';
import type { Student } from './_components/interfaces/student';

const data: Student[] = [
  {
    id: 1,
    firstName: 'Lautaro',
    lastName: 'Ibarra',
    dni: '230456789',
    age: 8,
    course: '2A'
  },  
  {
    id: 2,
    firstName: 'Sofía',
    lastName: 'Osorio',
    dni: '323456789',  
    age: 8,
    course: '2B'
  },
  {
    id: 3,
    firstName: 'Felipe',
    lastName: 'Maidana',  
    dni: '853456789',
    age: 7, 
    course: '1A'
  },
];
</script>
