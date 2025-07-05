<template>
  <Head>
    <title>Fruitfy - Contatos</title>
  </Head>
  <ConfirmDialog></ConfirmDialog>
  <div class="p-8 space-y-4 max-w-7xl mx-auto">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">Contatos</h1>
      <Button label="Novo" icon="pi pi-plus" @click="openCreate" />
    </div>

    <div class="card mb-4">
      <div class="flex justify-content-between align-items-center mb-4">
        <span class="p-input-icon-left w-full">
          <IconField>
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText 
              v-model="searchQuery" 
              @update:modelValue="handleSearch"
              placeholder="Buscar contatos..." 
              class="w-full"
              :loading="loading"
            />
          </IconField>
        </span>
      </div>
    </div>

    <DataTable 
      :value="contacts.data" 
      dataKey="id" 
      stripedRows 
      :lazy="true" 
      :paginator="true"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
      :loading="loading"
      :first="(contacts.current_page - 1) * contacts.per_page"
      :key="contacts.current_page"
      :page="contacts.current_page"
      :totalRecords="contacts.total"
      @page="visit"
      :rows="contacts.per_page"
    >
      <Column field="name" header="Nome">
        <template #body="{ data }">
          <div class="flex items-center gap-3">
            <span>{{ data.name }}</span>
          </div>
        </template>
      </Column>
      <Column field="email" header="E-mail" />
      <Column header="Telefone">
        <template #body="{ data }">{{ formatPhone(data.phone) }}</template>
      </Column>
      <Column header="Notas">
        <template #body="{ data }">
          <span v-if="data.notes" v-tooltip.top="data.notes" class="notes-cell">
            {{ truncateText(data.notes, 30) }}
          </span>
          <span v-else class="text-gray-400">-</span>
        </template>
      </Column>
      <Column header="Ações">
        <template #body="{ data }">
          <Button icon="pi pi-pencil" text @click="openEdit(data)" />
          <Button icon="pi pi-trash"  text severity="danger" class="ml-2" @click="destroyContact(data.id)" />
        </template>
      </Column>
    </DataTable>

    <ContactForm v-if="showForm" v-model="showForm" :contact="editing" />
  </div>
</template>

<script setup lang="ts">
import { computed, ref, watch, onMounted } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import ConfirmDialog from 'primevue/confirmdialog';
import ContactForm from '@/components/ContactForm.vue';
import { PageProps } from '@/types/Inertia';
import { ContactEntity } from '@/types/ContactEntity';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

defineOptions({ layout: AppLayout });

const page = usePage<PageProps>();
const confirm = useConfirm();
const contacts = computed(() => page.props.contacts);
const showForm = ref(false);
const editing = ref<ContactEntity | null>(null);
const loading = ref(false);

const searchQuery = ref('');
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

const initSearchQuery = () => {
  const params = new URLSearchParams(window.location.search);
  searchQuery.value = params.get('search') || '';
};

const handleSearch = () => {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }

  searchTimeout = setTimeout(() => {
    loading.value = true;
    
    router.get(
      '/contacts',
      { search: searchQuery.value },
      {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['contacts'],
        onFinish: () => {
          loading.value = false;
        },
      }
    );
  }, 500);
};

onMounted(() => {
  initSearchQuery();
});

watch(() => window.location.search, () => {
  initSearchQuery();
});

function openCreate () {
  editing.value = null
  showForm.value = true
}

function openEdit (contact: ContactEntity){ 
  editing.value = {...contact}
  showForm.value = true
}

function destroyContact(id: number) {
  confirm.require({
    message: 'Tem certeza que deseja excluir este contato?',
    header: 'Confirmação',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sim',
    rejectLabel: 'Não',
    accept: () => {
      router.delete(`/contacts/${id}`)
    },
    acceptProps: {
      severity: 'danger'
    },
    rejectProps: {
      severity: 'secondary'
    }
  })
}

function visit(event: any) {
  const page = event.page + 1;
  loading.value = true;
  
  const params = new URLSearchParams(window.location.search);
  const search = params.get('search') || '';
  
  router.visit(`/contacts?page=${page}&search=${search}`, {
    preserveScroll: true,
    preserveState: true,
    only: ['contacts'],
    onFinish: () => {
      loading.value = false;
    },
  });
}

function formatPhone(p: string) {
  if (!p) return '';
  const digits = p.replace(/\D/g, '');
  
  if (digits.length === 10) {
    return digits.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
  }
  if (digits.length === 11) {
    return digits.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
  }
  return p;
}

function truncateText(text: string, maxLength: number) {
  if (!text) return '';
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}
</script>
