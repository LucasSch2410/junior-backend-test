<template>
  <Dialog
    v-model:visible="visible"
    :header="isEdit ? 'Editar Contato' : 'Novo Contato'"
    modal
    dismissableMask
    :style="{ width: '28rem' }"
    @hide="showForm = false"
  >
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nome</label>
        <InputText v-model="form.name" class="w-full" placeholder="Seu nome"/>
        <small v-if="errors.name" class="p-error">{{ errors.name }}</small>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <InputText v-model="form.email" type="email" class="w-full" placeholder="Seu email"/>
        <small v-if="errors.email" class="p-error">{{ errors.email }}</small>
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Telefone</label>
        <InputMask v-model="form.phone" type="text" class="w-full" mask="(99) 9?9999-9999" placeholder="(99) 99999-9999" />
        <small v-if="errors.phone" class="p-error">{{ errors.phone }}</small>
      </div>

      <div class="flex justify-end gap-2 pt-2">
        <Button type="button" label="Cancelar" severity="secondary" outlined @click="showForm = false" />
        <Button type="submit" label="Salvar" :loading="processing" />
      </div>
    </form>
  </Dialog>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import {ContactEntity} from "../types/ContactEntity";

interface Props {
  contact?: ContactEntity | null;
}

const props = defineProps<Props>();
const showForm = defineModel()

const visible = ref(true);
const isEdit = !!props.contact?.id;

const form = reactive({
  name: props.contact?.name ?? '',
  email: props.contact?.email ?? '',
  phone: props.contact?.phone ?? '',
});

const errors = reactive<{ [k: string]: string }>({});
const processing = ref(false);

watch(() => props.contact, (newVal) => {
  form.name = newVal?.name ?? '';
  form.email = newVal?.email ?? '';
  form.phone = newVal?.phone ?? '';
});

function submit() {
  processing.value = true;
  errors.name = errors.email = errors.phone = '';

  const payload = { ...form };

  const onFinish = () => {
    processing.value = false;
  };

  if (isEdit && props.contact?.id) {
    router.put(`/contacts/${props.contact.id}`, payload, {
      preserveScroll: true,
      onError: (e: any) => Object.assign(errors, e),
      onFinish,
    });
  } else {
    router.post('/contacts', payload, {
      preserveScroll: true,
      onError:  e => Object.assign(errors, e),
      onFinish: () => { processing.value = false }
    });
  }
}
</script>
