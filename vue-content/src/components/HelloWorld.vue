<template lang="html">

  <section class="tasks">
    <h1>tasks Component</h1>
    <v-data-table
      :headers="headers"
      :items="tasks"
      :items-per-page="5"
      class="elevation-1"
    ></v-data-table>
  </section>

</template>

<script lang="js">
  import axios from 'axios'
  export default  {
    name: 'tasks',
    props: [],
    mounted () {
      axios
            .get('http://localhost:8000/api/tasks')
            .then(response => {this.tasks = response.data.data
            
    })
            
            
    },
    data () {
      return {
        info: null,
        tasks: [],
        headers: [
          {
   "text": "created_at",
   "value": "created_at"
  },
  {
    "text": "date",
    "value": "date"
   },
   {
    "text": "deleted_at",
    "value": "deleted_at"
   },
   {
    "text": "description",
    "value": "description"
   },
   {
    "text": "id",
    "value": "id"
   },
   {
    "text": "location",
    "value": "location"
   },
   {
    "text": "updated_at",
    "value": "updated_at"
   }
          
        ]
      }
    },
    methods: {

    },
    computed: {

    }
}


</script>

<style scoped lang="scss">
  .tasks {

  }
</style>
