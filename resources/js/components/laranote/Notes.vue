<script>

    import Note from '@/proxies/NoteProxy'

    export default {

        components: {},

        props: [
            'contextRef'
        ],

        /**
         * The component's data.
         */
        data() {
            return {
                form: {
                    content: '',
                    errors: []
                },
                modals:{
                    delete:false
                },
                notes:[],
                loadState: true,
                base: '/api/notes'
            };
        },

        mounted() {
            this.prepareComponent();
        },

        /**
         * Clean after the component is destroyed.
         */
        destroyed(){
            clearInterval(this.interval);
        },

        /**
         * Component Methods
         *
         * @type {Object}
         */
        methods: {

            /**
             * Run the steps to ready component
             */
            prepareComponent() {
                this.getNotes();
            },

            /**
             * Produce the context for requests
             *
             * @param  {Object} arguments optional object to merge with
             *
             * @return {Object}
             */
            withContext(data = []) {
                /* Define base context */
                var context = {context_ref:this.contextRef};
                /* Merge with additional data */
                return _.merge(context, data);
            },

            /**
             * Get the notes
             *
             * @param  {Boolean} preload
             * @return {Promise}
             */
            getNotes(preload = true) {
                /* Set the load state */
                this.loadState = preload
                /* Refresh notes */
                return new Note(this.withContext()).all().then(response=>{
                    this.notes = response;

                    this.loadState = false;
                })
            },


            /**
             * Save the Note
             *
             * @return {Promise}
             */
            store() {
                return new Note(this.withContext()).create(this.form).then(response=>{
                    /* Load the notes */
                    this.getNotes(false);
                    /* Reset the form */
                    this.form = {
                        content:'',
                        errors:[]
                    };
                })
            },

            /**
             * Delete the note
             *
             * @param  {object} note
             * @return {Promise}
             */
            destroy(note){
                return new Note(this.withContext()).destroy(note.id).then(response=>{
                    /* Load the notes */
                    this.getNotes(false);
                    /* Hide modal */
                    this.modals.delete = false
                })
            },

            /**
             * Refresh the jobs every period of time.
             *
             * @return {void}
             */
            refreshPeriodically() {
                this.interval = setInterval(() => {
                    this.getNotes(false);
                }, 50000 );
            }
        },
    };
</script>

<template>
    <v-progress-linear v-bind:indeterminate="true" v-if="loadState"></v-progress-linear>
    <article id="notes-list" v-else>
        <h2 class="title">
            Notes
        </h2>
        <v-divider class="mb-3"></v-divider>
        <template v-for="(note,index) in notes">
            <v-card>
                <v-card-actions>
                    <div>
                        <strong>{{ note.created_by.name }}</strong>
                        <small class="blue-grey--text">{{ note.created_at | moment("from") }}</small>
                        <br>
                        <span>{{ note.content}}</span>
                    </div>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="modals.delete" persistent>
                        <v-btn icon slot="activator">
                            <v-icon color="grey lighten-1">delete</v-icon>
                        </v-btn>
                        <v-card>
                            <v-card-title class="headline">Just making sure</v-card-title>
                            <v-card-text>Do you really want to this note by {{ note.created_by.name }}?</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat @click.native="modals.delete = false">Cancel</v-btn>
                                <v-btn color="pink" flat @click="destroy(note)">Delete</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-card-actions>
            </v-card>
            <v-divider/>
        </template>
        <v-divider></v-divider>
        <v-text-field
            label="Add another Comment"
            class="elevation-1"
            v-model="form.content"
            counter
            full-width
            rows=2
            required
        ></v-text-field>
        <v-btn color="secondary" outline @click="store" class="pl-0 ml-0">Submit</v-btn>
    </article>
</template>

<style lang="stylus">
.list-unstyled > li {
    list-style: none;
}
</style>
