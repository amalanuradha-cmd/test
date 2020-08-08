<template lang="html">

  <section class="tasks pa-5">
    <h1>tasks Component</h1>
    <v-dialog v-model="dialog" persistent max-width="290" >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
          class="mb-5"
        >
          Add Task
        </v-btn>
      </template>
      <v-card class="pa-5">
       <v-row>

        <v-col cols="12" sm="6" >
          <v-text-field
            v-model="task.description"
            label="Description"
          ></v-text-field>
        </v-col>
        </v-row>
        <v-row>

        <v-col cols="12" sm="6" >
          <v-text-field
          v-model="task.location"
            label="Location"
          ></v-text-field>
        </v-col>
        </v-row>
        <v-row>
      <v-col cols="12" lg="6">
        <v-menu
          ref="menu1"
          v-model="menu1"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="task.date"
              label="Date"
              hint="MM/DD/YYYY format"
              persistent-hint
              
              v-bind="attrs"
              @blur="date = parseDate(task.date)"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="task.date" no-title @input="menu1 = false"></v-date-picker>
        </v-menu>
        
      </v-col>
      </v-row>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="green darken-1" text @click="addTask()">Add</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
        menu1: false,
        dialog: false,
        info: null,
        task: {},
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
      addTask() {
        console.log(this.task);
        
      axios.post('http://localhost:8000/api/tasks/add', this.task).then(
        this.getTask()
     );
        
        
        
    },
  getTask() {
    setTimeout(() => {
         axios
            .get('http://localhost:8000/api/tasks')
            .then(response => {this.tasks = response.data.data
            
    })
    }, 1000);
   
    }  
    },
    computed: {

    }
}


</script>

<style scoped lang="scss">
  .tasks {

  }
</style>
