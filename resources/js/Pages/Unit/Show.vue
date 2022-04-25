<template>
    <Head title="Unit" />

    <DevLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            class="bg-white shadow overflow-hidden sm:rounded-lg"
                        >
                            <div class="px-4 py-5 sm:px-6">
                                <p class="max-w-2xl text-sm text-gray-500">
                                    <Link
                                        :href="
                                            route('institution.show', {
                                                ministry: unit.institution.id,
                                            })
                                        "
                                        >{{ unit.institution.name }}
                                    </Link>
                                    <Link
                                        v-if="unit.parent.parent != null"
                                        :href="
                                            route('unit.show', {
                                                unit: unit.parent.parent.id,
                                            })
                                        "
                                    >
                                        / {{ unit.parent.parent.name }}
                                    </Link>
                                    <Link
                                        v-if="unit.parent != null"
                                        :href="
                                            route('unit.show', {
                                                unit: unit.parent.id,
                                            })
                                        "
                                    >
                                        / {{ unit.parent.name }}
                                    </Link>
                                </p>
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                >
                                    {{ unit.name }}
                                </h3>
                            </div>
                            <div class="border-t border-gray-200">
                                <dl>
                                    <div
                                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Name
                                        </dt>
                                        <dd
                                            class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                        >
                                            {{ unit.name }}
                                        </dd>
                                    </div>

                                    <div
                                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Staff
                                        </dt>
                                        <dd
                                            class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                        >
                                            {{ unit.staff.toLocaleString() }}
                                        </dd>
                                    </div>
                                    <div
                                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Departments
                                        </dt>
                                        <dd
                                            class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                        >
                                            <ul
                                                role="list"
                                                class="border border-gray-200 rounded-md divide-y divide-gray-200 max-h-80 overflow-y-auto"
                                            >
                                                <li
                                                    class="pl-3 pr-4 py-3 flex items-center justify-between text-base tracking-wider bg-white"
                                                >
                                                    <div class="flex-1 w-1/2">
                                                        Name
                                                    </div>
                                                    <div
                                                        class="flex-1 w-1/4 text-right"
                                                    >
                                                        Staff
                                                    </div>
                                                    <div
                                                        class="flex-1 w-1/4 text-right"
                                                    ></div>
                                                </li>
                                                <li
                                                    v-for="division in unit.divisions"
                                                    :key="division.id"
                                                    class="hover:bg-green-50 pl-3 pr-4 py-3 flex items-center justify-between text-sm"
                                                >
                                                    <div class="w-1/2">
                                                        {{ division.name }}
                                                    </div>
                                                    <div
                                                        class="w-1/4 text-right"
                                                    >
                                                        {{
                                                            division.staff.toLocaleString()
                                                        }}
                                                    </div>
                                                    <div
                                                        class="w-1/4 text-right"
                                                    >
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'unit.show',
                                                                    {
                                                                        unit: division.id,
                                                                    }
                                                                )
                                                            "
                                                            >View</Link
                                                        >
                                                    </div>
                                                </li>
                                            </ul>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DevLayout>
</template>

<script setup>
import DevLayout from "@/Layouts/Dev.vue";
import { PaperClipIcon } from "@heroicons/vue/solid";
import { format } from "date-fns";
defineProps({
    unit: Object,
});
</script>
