<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { ref } from 'vue';

import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/jquery.dataTables.min.css';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JsZip from 'jszip';
import pdfmake from 'pdfmake/build/pdfmake';
import * as pdfFonts from 'pdfmake/build/vfs_fonts';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';

pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JsZip;
DataTable.use(ButtonsHtml5);

const props = defineProps({
    employees: {type: Object},
    departaments: {type: Object}
});

const column1 = ref([]);
const column2 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const report = ref('1');
const types = ref([
    {id: 1, name: 'Employee'},
    {id: 2, name: 'Departaments'},
]);
column1.value = [
    {
        data: null,
        render: function(data, type, row, meta) {
            return (meta.row +1);
        }
    },
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'Departament' },
];
column1.value = [
    {
        data: null,
        render: function(data, type, row, meta) {
            return (meta.row +1);
        }
    },
    { data: 'name' },
];
buttons1.value = [
    {
        title: 'Employees',
        extend: 'excelHtml5',
        text: '<i class="fa solid fa-file-excel"></i> Excel',
        className: 'inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'pdfHtml5',
        text: '<i class="fa solid fa-file-pdf"></i> PDF',
        className: 'inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-700 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'print',
        text: '<i class="fa solid fa-print"></i> Print',
        className: 'inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 focus:bg-indigo-700 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'copy',
        text: '<i class="fa solid fa-copy"></i> Copy',
        className: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
];

buttons2.value = [
    {
        title: 'Departaments',
        extend: 'excelHtml5',
        text: '<i class="fa solid fa-file-excel"></i> Excel',
        className: 'inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Departaments',
        extend: 'pdfHtml5',
        text: '<i class="fa solid fa-file-pdf"></i> PDF',
        className: 'inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-700 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Departaments',
        extend: 'print',
        text: '<i class="fa solid fa-print"></i> Print',
        className: 'inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 focus:bg-indigo-700 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title: 'Departaments',
        extend: 'copy',
        text: '<i class="fa solid fa-copy"></i> Copy',
        className: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
];


</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <InputLabel for="rep" value="Report"></InputLabel>
                    <SelectInput 
                        id="rep" 
                        class="mt-1 block w-3/4"
                        v-model="report"
                        :options="types"
                    ></SelectInput>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>