<template>
    <Head title="institution" />

    <DevLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Institution
                    </h2>
                </div>

                <BreezeInput
                    v-model="search"
                    type="search"
                    placeholder="Search..."
                    class="border px-2 rounded-lg"
                    autofocus
                />
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Departments
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Units
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Staff
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        <span class="sr-only">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="institution in institutions.data"
                                    :key="institution.id"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{ institution.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{
                                                        institution.departments
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{ institution.units }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{ institution.staff }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                        <Link
                                            :href="
                                                route('institution.show', {
                                                    ministry: institution.id,
                                                })
                                            "
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            View</Link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex items-center mt-6 w-full">
                            <span class="flex-1">
                                Showing {{ institutions.from }} to
                                {{ institutions.to }} of
                                {{ institutions.total }} staff
                            </span>
                            <Pagination
                                :links="institutions.links"
                                class="flex justify-between flex-1 w-full"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DevLayout>
</template>
<script setup>
import DevLayout from "@/Layouts/Dev.vue";
import { ref, watch } from "vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import debounce from "lodash/debounce";
import BreezeInput from "@/Components/Input.vue";
import { format } from "date-fns";

let props = defineProps({
    institutions: Object,
    filters: Object,
    can: Object,
});

let search = ref(props.filters.search);
watch(
    search,
    debounce(function (value) {
        Inertia.get(
            route("institution.index"),
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);
</script>
