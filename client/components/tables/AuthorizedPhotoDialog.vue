<template>
  <Dialog v-model:open="visibility">
    <DialogContent class="sm:max-w-[425px] py-10 px-8">
      <template v-if="loading">
        <div class="aspect-square w-full flex items-center justify-center">
          <LoaderCircle class="animate-spin" :size="40" />
        </div>
      </template>
      <template v-else>
        <img class="aspect-square w-full animate-in" :src="img" />
      </template>
    </DialogContent>
  </Dialog>
</template>
<script setup lang="ts">
import { LoaderCircle } from "lucide-vue-next";
import { toast } from "vue-sonner";
import Dialog from "@/components/ui/dialog/Dialog.vue";
import DialogContent from "@/components/ui/dialog/DialogContent.vue";
import api from "@/utils/authAxios";

const props = defineProps<{
  photo: string;
}>();

const visibility = defineModel<boolean>("visibility", { default: false });
const img: Ref<string> = ref("");
const loading: Ref<boolean> = ref(true);

async function getImage() {
  const { data, headers } = await api.get("/api/image/" + props.photo, {
    responseType: "arraybuffer",
  });

  const base64 = encodeToBase64(data);

  return `data:${headers["Content-Type"]};base64,${base64}`;
}

function encodeToBase64(data: Iterable<number>): string {
  return btoa(
    new Uint8Array(data).reduce(
      (_data, byte) => _data + String.fromCharCode(byte),
      "",
    ),
  );
}

watch(visibility, async (v) => {
  if (v) {
    img.value = "";
    loading.value = true;
    try {
      img.value = await getImage();
    } catch (e) {
      toast.error("Ocurrió un error y no se pudo cargar la imagen");
    } finally {
      loading.value = false;
    }
  }
});
</script>
