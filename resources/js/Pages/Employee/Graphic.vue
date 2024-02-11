<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { ref } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const departaments = ref([]);
const employees = ref([]);
const charData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

const props = defineProps({
    data: {type: Object}
});

const randomColor = () =>
{
    const random = () => Math.floor(Math.random() * 255);
    return "rgb(" + random() + "," + random() + "," + random() + ")";
}

props.data.map( (row) => (
    departaments.value.push(row.name),
    employees.value.push(row.count),
    colors.value.push(randomColor())
));
chartOptions.value = { responsive:true };
charData.value = {
    labels: departaments.value,
    datasets:[
        {
            label: 'Employees',
            data: employees.value,
            backgroundColor: colors,
            borderWidth: 1
        }
    ]
} ;
</script>

<template>
    <Head title="Graphic" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Graphic</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Bar :data="charData" :options="chartOptions"></Bar>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Pie :data="charData" :options="chartOptions"></Pie>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>