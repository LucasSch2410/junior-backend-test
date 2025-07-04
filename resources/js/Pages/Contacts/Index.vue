<template>
  <ConfirmDialog></ConfirmDialog>
  <div class="p-8 space-y-4">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">Contatos</h1>
      <Button label="Novo" icon="pi pi-plus" @click="openCreate" />
    </div>

    <DataTable :value="contacts.data" dataKey="id">
      <Column field="name"  header="Nome"  sortable />
      <Column field="email" header="E-mail" sortable />
      <Column header="Telefone">
        <template #body="{ data }">{{ formatPhone(data.phone) }}</template>
      </Column>
      <Column header="Ações">
        <template #body="{ data }">
          <Button icon="pi pi-pencil" text @click="openEdit(data)" />
          <Button icon="pi pi-trash"  text severity="danger" class="ml-2" @click="destroyContact(data.id)" />
        </template>
      </Column>
    </DataTable>

    <!-- Paginação laravel -->
    <div v-if="contacts.links" class="flex justify-center mt-4">
      <Button
        v-for="link in contacts.links"
        :key="link.label"
        :label="displayLabel(link)"
        :disabled="!link.url"
        :severity="link.active ? 'primary' : undefined"
        text
        size="small"
        @click="visit(link)"
      />
    </div>

    <ContactForm v-if="showForm" v-model="showForm" :contact="editing" @saved="onSaved" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import DataTable from 'primevue/datatable'
import Column    from 'primevue/column'
import Button from 'primevue/button';
import { useConfirm } from 'primevue/useconfirm';
import ContactForm from './ContactForm.vue'
import ConfirmDialog from 'primevue/confirmdialog'

type Contact = { id?: number; name: string; email: string; phone: string }

const confirm = useConfirm();
const page = usePage<{ contacts: any }>();
const contacts = page.props.contacts
const showForm = ref(false)
const editing = ref<Contact|null>(null)

function openCreate () { 
  editing.value = null 
  showForm.value = true 
}

function openEdit(c:Contact){ 
  editing.value = {...c} 
  showForm.value = true 
}

function onSaved() {
  showForm.value = false
  router.visit(window.location.pathname)
}

function destroyContact(id: number) {
  confirm.require({
    message: 'Tem certeza que deseja excluir este contato?',
    header: 'Confirmação',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sim',
    rejectLabel: 'Não',
    accept: () => {
      router.delete(`/contacts/${id}`, { onFinish: () => router.visit(window.location.pathname) })
    },
  })
}

function visit(l:any){ 
  if(l.url) 
  router.visit(l.url) 
}

function displayLabel(link: any) {
  if (link.label.includes('Previous')) return 'Anterior'
  if (link.label.includes('Next')) return 'Próximo'
  return link.label
}

function formatPhone(p: string) {
  if (p.length === 11) {
    return p.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
  }
  return p;
}
</script>
