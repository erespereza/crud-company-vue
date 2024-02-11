<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import VueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import { ref } from 'vue';
import { nextTick } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const nameInput =   ref(null);
const modal =       ref(false);
const title =       ref('');
const operation =   ref(1);
const id =          ref('');

const props = defineProps({
    employees:      {type: Object},
    departaments:   {type: Object},
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    departament_id: '',
});

const formPage = useForm({});

const onPageClick = (event) =>
{
    formPage.get(route('employee.index', {page: event}));
}

const openModal = (op, name, email, phone, departament, employee) =>
{
    modal.value = true;
    nextTick( () => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if( op === 1)
    {
        title.value = 'Create employee';
    }else{
        title.value = 'Edit employee';
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.departament_id = departament;
    }
}

const closeModal = () =>
{
    modal.value = false;
    form.reset();
}

const save = () => 
{
    if(operation.value === 1)
    {
        form.post(route('employee.store'), {
            onSuccess: () => {ok('Employee created')}
        });
    }else{
        form.put(route('employee.update', id.value), {
            onSuccess: () => {ok('Employee modified')}
        });
    }
}

const ok = (message) => 
{
    closeModal();
    Swal.fire({
        title: message,
        icon: 'success'
    });
}

const deleteEmployee = (id, name) =>
{
    const alertConfirm = Swal.mixin({
        buttonsStyling: true
    });

    alertConfirm.fire({
        title:              'Are you sure delete ' + name + ' ?',
        icon:               'question', 
        showCancelButton:   true,
        confirmButtonText:  '<i class"fa-solid fa-check"></i> Yes, delete',
        cancelButtonText:   '<i class"fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('employee.destroy', id), {
                onSuccess: () => {ok('Employee deleted')}
            });
        }
    });
}

</script>

<template>
    <Head title="Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="my-3 flex">
                    <PrimaryButton @click="$evenet => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i>
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <th class="p-2">#</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Phone</th>
                        <th class="p-2">Departament</th>
                        <th class="p-2"></th>
                        <th class="p-2"></th>
                    </thead>
                    <tbody>
                        <tr v-for="(employee, index) in employees.data" :key="employee.id">
                            <td class="border border-gray-400 p-2">{{ (index + 1) }}</td>
                            <td class="border border-gray-400 p-2">{{ employee.name }}</td>
                            <td class="border border-gray-400 p-2">{{ employee.email }}</td>
                            <td class="border border-gray-400 p-2">{{ employee.phone }}</td>
                            <td class="border border-gray-400 p-2">{{ employee.departament }}</td>
                            <td class="border border-gray-400 p-2">
                                <WarningButton 
                                    @click="$event => openModal(
                                        2,
                                        employee.name,
                                        employee.email, 
                                        employee.phone, 
                                        employee.departament_id, 
                                        employee.id
                                    )"
                                >
                                    <i class="fa-solid fa-pencil-square"></i> Edit
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 p-2">
                                <DangerButton @click="deleteEmployee(employee.id, employee.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPaginationUmd
                    :current="employees.currentPage"
                    :total="employees.total"
                    :perpage="employees.perPage"
                    @page-changed="$event => onPageClick($event)"
                >
                </VueTailwindPaginationUmd>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font-medium text-gray-900 ">
                {{ title }}
            </h2>
            <div class="p-3">
                <InputLabel for="name" value="Name"></InputLabel>
                <TextInput 
                    id="name"
                    v-model="form.name" 
                    ref="nameInput" 
                    type="text" 
                    class="mt-1 block w-3/4"
                    placeholder="name"
                ></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Email"></InputLabel>
                <TextInput 
                    id="email" 
                    v-model="form.email" 
                    type="text" 
                    class="mt-1 block w-3/4"
                    placeholder="Email"
                ></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Phone"></InputLabel>
                <TextInput 
                    id="phone" 
                    v-model="form.phone"
                    type="text" 
                    class="mt-1 block w-3/4"
                    placeholder="Phone"
                ></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="departament_id" value="Departament"></InputLabel>
                <SelectInput 
                    id="departament_id"
                    v-model="form.departament_id" 
                    class="mt-1 block w-3/4"
                    :options="departaments"
                ></SelectInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <PrimaryButton @click="save" :disabled="form.processing">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
                <SecondaryButton @click="closeModal">
                    <i class="fa-solid fa-ban"></i> Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
