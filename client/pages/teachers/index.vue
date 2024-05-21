<template>
  <div>
    <h2 class="text-3xl my-5">Maestros</h2>
    <Table :columns="columns" :data="data" />
  </div>
</template>

<script setup lang="ts">
import Table from '@/pages/teachers/_components/Table.vue';
import { columns } from './_components/columns';
import type { Teacher } from './_components/interfaces/teacher';

const data: Teacher[] = [
  {
    id: 1,
    firstName: 'Mariana',
    lastName: 'Martinez',
    email: 'marianamartinez@example.com',
    dni: '123456789',
    phone: '123-456-7890',
    course: '2A'
  },  
  {
    id: 2,
    firstName: 'Jorge',
    lastName: 'Olivera',  
    email: 'jorgeolivera@example.com',
    dni: '323456789',
    phone: '123-456-7890',
    course: '2B'
  },
  {
    id: 3,
    firstName: 'Eugenia',
    lastName: 'Hernandez',  
    email: 'eugeniahernandez@example.com',
    dni: '66456789',
    phone: '123-456-7890',
    course: '1A'
  },
];
</script>
