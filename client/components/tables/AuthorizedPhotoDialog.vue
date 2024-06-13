<template>
  <Dialog v-model:open="visibility">
    <DialogContent class="sm:max-w-[425px] py-10 px-8">
      <template v-if="loading">
        <div class="aspect-square w-full flex items-center justify-center">
          <LoaderCircle class="animate-spin" :size="40" />
        </div>
      </template>
      <img
        v-show="!loading"
        class="aspect-square w-full animate-in"
        :src="imageSrc"
        @load="loading = false"
      />
    </DialogContent>
  </Dialog>
</template>
<script setup lang="ts">
import { LoaderCircle } from "lucide-vue-next";
import Dialog from "@/components/ui/dialog/Dialog.vue";
import DialogContent from "@/components/ui/dialog/DialogContent.vue";

const config = useRuntimeConfig();
const props = defineProps<{
  photo: string;
}>();

const visibility = defineModel<boolean>("visibility", { default: false });
const loading: Ref<boolean> = ref(true);
const imageSrc: ComputedRef<string> = computed(
  () => config.public.baseApiUrl + "/images/" + props.photo,
);

watch(visibility, (v) => {
  if (v) loading.value = true;
});
</script>
