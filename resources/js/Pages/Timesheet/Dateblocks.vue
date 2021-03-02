<template>
    <div class="grid grid-cols-9 gap-4">
        <SliderPrevious :date="dates[0].date"/>
	 	<template v-for="date in dates">
         <Dateblock :date="date.date" :hours_registered="date.hours_registered" :hours_total="date.hours_total" />
		</template v-for>
        <SliderNext :date="dates[0].date"/>
    </div>
</template>

<script>
    import Dateblock from './Dateblock';
    import SliderPrevious from '../../General/SliderPrevious';
    import SliderNext from '../../General/SliderNext';

    export default {
        props: ['dates'],

        components: {
            Dateblock,
            SliderPrevious,
            SliderNext
        },
    }
</script>