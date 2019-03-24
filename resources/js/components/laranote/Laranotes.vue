<script>

    import Note from './Note'

    export default {

        /**
         * Manage dependency inject
         *
         * @type {Object}
         */
        components: {
        },

        /**
         * Regisrer properties
         *
         * @type {Array}
         */
        props: [
            'context',
            'title',
        ],

        /**
         * Component's data
         *
         * @return {Object}
         */
        data() {
            return {
                loadState:false,
                notes:[],
                record: new Note(),
                content:'',
            };
        },

        mounted() {
            this.prepareComponent();
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
                var context = {context:this.context};

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

                Note.where('context', this.context)
                    .get()
                    .then(response => {
                        this.notes = response.data
                        this.loadState = false
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },

            /**
             * Store a note
             *
             * @return {}
             */
            store() {
                // Force load state
                this.loadState = true
                // do the new note
                new Note({
                    context:this.context,
                    content:this.content,
                })
                .save()
                .then(response => {
                    this.notes.push(new Note(response.data));
                    this.content = '';
                    this.loadState = false;
                })
                .catch(errors => {
                    console.log(errors)
                })
            },

            /**
             * Run the steps to ready component
             */
            destroy(note) {
                this.loadState = true
                note.delete()
                    .then(response => {
                        _.remove(this.notes, {id:note.id})
                        this.loadState = false;
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
        },
    }
</script>

<template>
    <section v-if="context">
        <header class="my-2 border-bottom" v-if="title">
            <h5 class="title">
                {{ title }}
            </h5>
        </header>
        <ul class="list-unstyled">
            <li class="media" v-for="note in notes" v-bind:value="note.id">
                <img src="//placehold.it/32x32" class="mr-3">
                <div class="media-body">
                    <div>
                        {{ note.content }}
                    </div>
                    <p class="text-muted text-small">
                        <span>{{ note.author.name }}</span>
                        <span>{{ note.created_at | moment('calendar') }}</span>
                    </p>
                </div>
                <a href="#"
                    :disabled="loadState"
                    @click="destroy(note)"
                    class="icon"
                    data-toggle="modal">
                    <i class="mdi mdi-close"></i>
                </a>
            </li>
        </ul>
        <form>
            <div class="form-group">
                <textarea
                    v-model="content"
                    class="form-control"
                    rows="3"
                    placeholder="Add New Note"></textarea>
            </div>
            <button
                class="btn btn-space btn-primary"
                type="button"
                @click="store"
                :disabled="loadState || !content">
                Submit
            </button>
        </form>
    </section>
</template>
