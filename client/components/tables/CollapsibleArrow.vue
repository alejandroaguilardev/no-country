<template>
  <ChevronDown
    :size="20"
    :class="[
      'absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2',
      active ? 'rotate-180' : '',
    ]"
    @click="active = !active"
  />
</template>

<script setup lang="ts">
import { ChevronDown } from "lucide-vue-next";

const active = defineModel<boolean>("active", { default: false });
</script>
