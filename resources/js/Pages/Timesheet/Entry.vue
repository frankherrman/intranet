<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ translate('general.menu.timesheet') }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <Dateblocks :dates="dates" />
            </div>
        </div>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EntryForm :projects="projects" :activities="activities" :types="types" :overhead_types="overhead_types" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Dateblocks from './Dateblocks'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import EntryForm from './EntryForm'

    export default {
        props: ['dates', 'projects','activities','types','overhead_types'],

        components: {
            AppLayout,
            Dateblocks,
            JetSectionBorder,
            EntryForm
        },
    }
</script>
