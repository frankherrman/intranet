<template>
  <form @submit.prevent="submit">
    <select name="project_id" v-model="selectedProject">
      <option value="">-  {{ translate('timesheet.select_website') }} -</option>
      <option :value="project.id" v-for="project in projects"> {{ project.name }}</option>
    </select>

    <select name="activity_id">
      <option>-  {{ translate('timesheet.select_activity') }} -</option>
      <option :value="activity.id" v-for="activity in activities" v-if="activity.project_id == selectedProject"> {{ activity.name }}</option>
    </select>
    
    <select name="hour_type_id">
      <option>- {{ translate('timesheet.select_hour_type')}} -</option>
      <option :value="type.id" v-for="type in types" v-if="type.department_id == usePage().props.value.auth.user.department_id"> {{ activity.name }}</option>
      <option>- {{ translate('timesheet.other_departments')}} -</option>
      <option :value="type.id" v-for="type in types" v-if="type.department_id != usePage().props.value.auth.user.department_id"> {{ activity.name }}</option>
    </select>
  

	<input id="hours" v-model="form.hours" type="number" step="0.25" :placeholder="translate('timesheet.hours')"/>

 
  </form>
</template>

<script>
export default {
	props: ['projects','activities','types','overhead_types'],
  data() {
    return {
      selectedProject:  "", 
      form: {
        hour_type_id: null,
        activity_id: null,
        overhead_type_id: null,
		  date: null,
		  hours: null,
		  billable: 1,
		  unforeseen: 0,
		  description: null,
		  remarks: null,
		  gitlab_ids: null
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post('/users', this.form)
    },
  },
  computed: {

  }
}
</script>