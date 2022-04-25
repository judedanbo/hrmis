<template>
    <Head title="Person" />

    <DevLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Person
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
                                <tr
                                    class="text-left h-10 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    <th class="px-6 font-medium">
                                        <div
                                            class="flex gap-2 items-center group cursor-pointer"
                                        >
                                            <span
                                                class="group-hover:text-gray-900 group-hover:font-bold"
                                                >Name</span
                                            >
                                            <sort-ascending-icon
                                                @click="toggleSortIcon"
                                                class="flex-shrink-0 h-5 w-5 text-gray-400 invisible group-hover:visible group-hover:tracking-wide"
                                                aria-hidden="true"
                                            />
                                        </div>
                                    </th>
                                    <th class="px-6 font-medium">
                                        <div
                                            class="flex items-center gap-2 group cursor-pointer"
                                        >
                                            <span
                                                class="group-hover:text-gray-900 group-hover:font-bold group-hover:tracking-wide"
                                                >Date of Birth</span
                                            >
                                            <sort-ascending-icon
                                                @click="toggleSortIcon"
                                                class="flex-shrink-0 h-5 w-5 text-gray-400 invisible group-hover:visible"
                                                aria-hidden="true"
                                            />
                                        </div>
                                    </th>
                                    <th class="px-6 font-medium">
                                        <div
                                            class="flex gap-2 items-center group cursor-pointer"
                                        >
                                            <span
                                                class="group-hover:text-gray-900 group-hover:font-bold group-hover:tracking-wide"
                                                >Social Security Number</span
                                            >
                                            <sort-ascending-icon
                                                @click="toggleSortIcon"
                                                class="flex-shrink-0 h-5 w-5 text-gray-400 invisible group-hover:visible"
                                                aria-hidden="true"
                                            />
                                        </div>
                                    </th>
                                    <th class="font-medium">
                                        <span class="sr-only">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="person in people.data"
                                    :key="person.id"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                    v-html="
                                                        replaceSearch(
                                                            person.name
                                                        )
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                    v-html="
                                                        replaceSearch(
                                                            dateFormat(
                                                                person.dob
                                                            )
                                                        )
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                    v-html="
                                                        replaceSearch(
                                                            person.ssn
                                                        )
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                        <Link
                                            :href="
                                                route('person.show', {
                                                    person: person.id,
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
                                Showing {{ people.from }} to {{ people.to }} of
                                {{ people.total }} staff
                            </span>
                            <Pagination
                                :links="people.links"
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
import { SortAscendingIcon, SortDescendingIcon } from "@heroicons/vue/solid";

let props = defineProps({
    people: Object,
    filters: Object,
    can: Object,
});

let search = ref(props.filters.search);
let sortIcon = ref("sort-ascending-icon");

watch(
    search,
    debounce(function (value) {
        Inertia.get(
            route("person.index"),
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);

let dateFormat = (dob) => {
    return format(new Date(dob), "MMMM d, yyyy");
};

let replaceSearch = (value, search = props.filters.search) => {
    if (search && search.length > 0) {
        const newVal = `(${encodeURI(search)})`;
        const regex = new RegExp(newVal, "gi");
        return value.replace(
            regex,
            "<b class='underline underline-offset-1'>$1</b>"
        );
    }
    return value;
};

let toggleSortIcon = () => {};
</script>
