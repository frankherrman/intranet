<template>
	<transition leave-active-class="transition ease-in duration-1000" leave-class="opacity-100" leave-to-class="opacity-0">
		<jet-nav-link :href="route('timesheet.entry', [getNextDate])" class="text-sm text-gray-600 arrow-back content-center">
				<svg class="w-6 h-6 content-end" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
				</svg>
		</jet-nav-link>
	</transition>
</template>

<script>
	import JetNavLink from '@/Jetstream/NavLink'

    export default {
        props: ['date'],
		  computed: {
			  getNextDate: function() {
				  let _date = new Date(this.date);
				  _date.setDate(_date.getDate()+7)
				  return _date.getFullYear() + '-' + (_date.getMonth()+1) + '-' + _date.getDate();
			  }
		  },
		  components: {
			  JetNavLink
		  }
    }
</script>
