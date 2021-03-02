<template>
	<transition leave-active-class="transition ease-in duration-1000" leave-class="opacity-100" leave-to-class="opacity-0">
		<div class="text-sm text-gray-600 date-block content-center p-1 rounded shadow" v-bind:class="isDone">
				<div class="the-date">{{ new Date(date).getDate() }}-{{ new Date(date).getMonth()+1 }}</div>
				<div class="hours">{{ hours_registered }} / {{ hours_total }}</div>
		</div>
	</transition>
</template>

<script>
    export default {
        props: ['date', 'hours_registered', 'hours_total'],
		  computed: {
			  isDone: function() {
				  return (this.hours_total - this.hours_registered > 0) && new Date(this.date) < new Date().setHours(0, 0, 0) ? 'bg-red-200' : 'bg-blue-200';
			  }
		  }
    }
</script>
