<script setup lang="ts">
import { type HTMLAttributes, computed } from "vue";
import {
  SelectIcon,
  SelectTrigger,
  type SelectTriggerProps,
  useForwardProps,
} from "radix-vue";
import { ChevronDown } from "lucide-vue-next";
import { cn } from "@/lib/utils";

const props = defineProps<
  SelectTriggerProps & { class?: HTMLAttributes["class"] }
>();

const delegatedProps = computed(() => {
<<<<<<< HEAD
=======
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
>>>>>>> origin/dev
  const { class: _, ...delegated } = props;

  return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
  <SelectTrigger
    v-bind="forwardedProps"
    :class="
      cn(
<<<<<<< HEAD
        'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1',
=======
        'flex h-[46px] w-full hover: items-center justify-between rounded-md border-2 border-input bg-transparent px-3 py-2 text-base ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:border-black disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1',
>>>>>>> origin/dev
        props.class,
      )
    "
  >
    <slot />
    <SelectIcon as-child>
      <ChevronDown class="w-4 h-4 text-foreground" />
    </SelectIcon>
  </SelectTrigger>
</template>
