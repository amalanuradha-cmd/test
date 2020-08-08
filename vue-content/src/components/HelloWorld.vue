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
    sort-by="description"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>My CRUD</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog1" max-width="500px">
         
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="task.description"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-menu
          ref="menu2"
          v-model="menu2"
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
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="task.location" ></v-text-field>
                  </v-col>
                 <v-col cols="12" sm="6" md="4">
                    <v-btn @click="update()" label="Location">Save</v-btn>
                  </v-col>
                </v-row>
                
              </v-container>
            </v-card-text>

           
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
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
        menu2: false,
        menu1: false,
        dialog1: false,
        dialog: false,
        info: null,
        task: {},
        tasks: [],
        currentTask: {},
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
   ,
   {
    "text": "update",
    "value": "update"
   },
   { text: 'Actions', value: 'actions', sortable: false },
          
        ]
      }
    },
    methods: {
      update() {
         axios.put('http://localhost:8000/api/tasks/'+this.task.id, this.task).then(
        (response)=>{
          console.log(response);
          
          this.getTask()
        this.dialog1 = false
        }
     );
        
      },
      addTask() {
        console.log(this.task);
        
      axios.post('http://localhost:8000/api/tasks', this.task).then(
        this.getTask()
     );
        
        
        
    },
      editItem (item) {
        console.log(item);
        
        this.editedIndex = this.tasks.indexOf(item)
        this.task = Object.assign({}, item)
        this.dialog1 = true
      },

      deleteItem (item) {
        
        
        confirm('Are you sure you want to delete this item?') &&  axios
            .delete('http://localhost:8000/api/tasks/'+ item.id)
            .then(response => {
              this.getTask()
              console.log(response);
              
              
              
              
              
            
            
    })
      },
  getTask() {
    setTimeout(() => {
         axios
            .get('http://localhost:8000/api/tasks')
            .then(response => {this.tasks = response.data.data
            
    });
    
    }, 500);
   
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
