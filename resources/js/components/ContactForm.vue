<template>
  <Dialog
    v-model:visible="visible"
    :header="isEdit ? 'Editar Contato' : 'Novo Contato'"
    modal
    dismissableMask
    :style="{ width: '28rem' }"
    @hide="showForm = false"
  >
    <template #header>
      <div class="flex items-center gap-4">
        <span class="pi pi-user" style="font-size: 1.5rem"></span>
        <h1 class="text-xl font-bold">{{ isEdit ? 'Editar Contato' : 'Novo Contato' }}</h1>
      </div>
    </template>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nome</label>
        <InputText v-model="form.name" class="w-full" placeholder="Seu nome"/>
        <Message v-if="errors.name" severity="error" size="small" variant="simple">{{ errors.name }}</Message>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <InputText v-model="form.email" type="email" class="w-full" placeholder="Seu email"/>
        <Message v-if="errors.email" severity="error" size="small" variant="simple">{{ errors.email }}</Message>
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Telefone</label>
        <InputMask v-model="form.phone" type="text" class="w-full" :mask="phoneMask" placeholder="(99) 99999-9999" :auto-clear="false" @focus="isPhoneFocused = true" @blur="isPhoneFocused = false" />
        <Message v-if="errors.phone" severity="error" size="small" variant="simple">{{ errors.phone }}</Message>
      </div>

      <div class="flex justify-end gap-2 pt-2">
        <Button type="button" label="Cancelar" severity="secondary" outlined @click="showForm = false" />
        <Button type="submit" label="Salvar" :loading="processing" />
      </div>
    </form>
  </Dialog>
</template>

<script setup lang="ts">
import { reactive, ref, watch, computed } from 'vue';
import * as yup from 'yup';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import InputMask from 'primevue/inputmask';
import { ContactEntity } from "@/types/ContactEntity";
import { Message } from 'primevue';
import { useToast } from 'primevue/usetoast';

interface Props {
    contact?: ContactEntity | null;
}

const props = defineProps<Props>();
const showForm = defineModel()
const toast = useToast();

const visible = ref(true);
const isEdit = !!props.contact?.id;

const form = reactive({
  name: props.contact?.name ?? '',
  email: props.contact?.email ?? '',
  phone: props.contact?.phone ?? '',
});

const errors = reactive<{ [k: string]: string }>({});
const processing = ref(false);
const isPhoneFocused = ref(false);

const phoneMask = computed(() => {
  if (isPhoneFocused.value) {
    return '(99) 99999-9999';
  }
  const digits = form.phone?.replace(/\D/g, '') || '';
  return digits.length > 10 ? '(99) 99999-9999' : '(99) 9999-9999';
});

watch(() => props.contact, (newVal) => {
  form.name = newVal?.name ?? '';
  form.email = newVal?.email ?? '';
  form.phone = newVal?.phone ?? '';
});

const schema = yup.object({
  name: yup.string().required('O nome é obrigatório.').min(3, 'O nome deve ter pelo menos 3 caracteres.').max(100, 'O nome deve ter no máximo 100 caracteres.'),
  email: yup.string().email('O email deve ser um email válido.').required('O email é obrigatório.').max(150, 'O email deve ter no máximo 150 caracteres.'),
  phone: yup.string().required('O telefone é obrigatório.').test('min-digits', 'O telefone deve ter pelo menos 10 dígitos.', value => {
    const digits = value?.replace(/\D/g, '') || '';
    return digits.length >= 10;
  }),
});

async function submit() {
  errors.name = errors.email = errors.phone = '';

  try {
    await schema.validate(form, { abortEarly: false });

    processing.value = true;
    const payload = { ...form };
    const options = {
      preserveScroll: true,
      onSuccess: () => {
        showForm.value = false;
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Contato salvo com sucesso!', life: 3000 });
      },
      onError: (e: any) => {
        Object.assign(errors, e);
        toast.add({ severity: 'error', summary: 'Erro', detail: e.message, life: 3000 });
      },
      onFinish: () => { processing.value = false; },
    };

    if (isEdit && props.contact?.id) {
      router.put(`/contacts/${props.contact.id}`, payload, options);
    } else {
      router.post('/contacts', payload, options);
    }

  } catch (err) {
    if (err instanceof yup.ValidationError) {
      err.inner.forEach(error => {
        if (error.path) {
          errors[error.path] = error.message;
        }
      });
    }
  }
}
</script>
