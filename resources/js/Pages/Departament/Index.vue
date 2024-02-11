<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  departaments: {type: Object},
});

const form = useForm({
    id: ''
});

const deleteDepartament = (id, name) =>
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
            form.delete(route('departament.destroy', id));
        }
    });
}

</script>

<template>
    <Head title="Departaments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departaments</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="my-3 flex">
                    <Link :href="route('departament.create')" class="px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <th class="p-4">#</th>
                        <th class="p-4">Departament</th>
                        <th class="p-4"></th>
                        <th class="p-4"></th>
                    </thead>
                    <tbody>
                        <tr v-for="(departament, index) in departaments" :key="departament.id">
                            <td class="border border-gray-400 p-4">{{ (index + 1) }}</td>
                            <td class="border border-gray-400 p-4">{{ departament.name }}</td>
                            <td class="border border-gray-400 p-4">
                                <Link :href="route('departament.edit', departament.id)" class="px-4 py-2 bg-yellow-500 text-white border rounded-md font-semibold text-xs">
                                    <i class="fa-solid fa-pencil-square"></i> Edit
                                </Link>
                            </td>
                            <td class="border border-gray-400 p-4">
                                <DangerButton @click="deleteDepartament(departament.id, departament.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
