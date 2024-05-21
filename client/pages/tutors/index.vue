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
    lastName: "Doe",
    dni: "123456789",
    email: "johndoe@example.com",
    phone: "123-456-7890"
  },  
  {
    id: 2,
    firstName: "Gonzalo",
    lastName: "Gutierrez",
    dni: "123456789",
    email: "gonzagutierrez@example.com",
    phone: "312-456-7890"
  },
]
</script>
