<template>
<div class="q-pa-md q-gutter-sm">
  <div>{{ justInfo.time }} | {{ justInfo.location }} | {{ justInfo.temperature }}</div>
    <div class="row items-center no-wrap">
        <div class="col">
            <q-btn label="New ToDo" icon="add" color="primary" @click="prompt = true, headertodo = 'Add ToDo', isedit = 0, todo.uuid = null" />
        </div>
        <div class="col-auto">
            <q-input dense clearable v-model="searching" label="Search ToDo"></q-input>
        </div>
    </div>
    <h6 class="middle" v-if="listtodo.length > 0 ? false : true">Nothing can be displayed. Try adding some ToDo </h6>
    <q-dialog v-model="prompt" persistent>
        <q-card style="width: 700px; max-width: 80vw;">
            <q-form @submit="onSubmit">
                <q-card-section class="row items-center q-pb-none">
                    <div class="text-h6">{{ headertodo }}</div>
                    <q-space />
                    <q-btn icon="close" flat round dense v-close-popup />
                </q-card-section>

                <q-card-section class="q-pt-none">
                    <q-input autogrow clearable lazy-rules autofocus v-model="todo.subject" :readonly="isedit === 2 ? true : false" label="Subject" :rules="[ val => val && val.length > 0 || 'Field required']">
                        <template v-slot:prepend>
                            <q-icon name="event" />
                        </template>
                    </q-input>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    <q-input clearable lazy-rules type="textarea" v-model="todo.detail" :readonly="isedit === 2 ? true : false" label="Detail" :rules="[ val => val && val.length > 0 || 'Field required']">
                        <template v-slot:prepend>
                            <q-icon name="event" />
                        </template>
                    </q-input>
                </q-card-section>

                <q-card-actions align="right" class="text-primary">
                    <q-btn flat label="Edit" v-if="isedit === 2" @click="isedit = 1" />
                    <q-btn flat label="Submit" type="submit" v-if="isedit === 1 || isedit === 0" />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>

    <q-dialog v-model="alert">
        <q-card>
            <q-card-section>
                <div class="text-h6">Alert</div>
            </q-card-section>

            <q-card-section class="q-pt-none">
                Are you sure to delete todo?
            </q-card-section>

            <q-card-actions align="right">
                <q-btn flat label="OK" color="primary" @click="onDelete(todo.uuid)" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <div class="q-pa-md row items-start q-gutter-md">

        <span v-for="todos in listtodo" :key="todos.uuid">
            <q-card flat bordered class="my-card">
                <q-card-section>
                    <div class="row items-center no-wrap">
                        <div class="col" @click="onRead(todos.uuid), isedit = 2">
                            <div class="text-h6">{{ $helper.wordwraping(todos.todo.subject, 10) }}</div>
                            <div class="text-subtitle grey-7">{{ $helper.stamp2human(todos.created) }}
                                <q-badge align="middle" :color="todos.marked ? 'green' : 'red'" :label="todos.marked ? 'Done' : 'New'" />
                            </div>
                        </div>
                        <div class="col-auto">
                            <q-btn color="grey-7" round flat icon="more_vert"></q-btn>
                            <q-menu cover auto-close>
                                <q-list>
                                    <q-item clickable>
                                        <q-item-section @click="onUpdate(todos.uuid, 1)">Mark as Done</q-item-section>
                                    </q-item>
                                    <q-item clickable>
                                        <q-item-section @click="onRead(todos.uuid), isedit = 1">Edit</q-item-section>
                                    </q-item>
                                    <q-item clickable>
                                        <q-item-section @click="alert = true, todo.uuid = todos.uuid">Delete</q-item-section>
                                    </q-item>
                                </q-list>
                            </q-menu>
                        </div>
                    </div>
                </q-card-section>

                <q-separator inset />

                <q-card-section class="" @click="onRead(todos.uuid), isedit = 2">
                    {{ $helper.wordwraping(todos.todo.detail, 180) }}
                </q-card-section>
            </q-card>
        </span>
    </div>
</div>
</template>

<style lang="css" scoped>
.my-card {
    width: 300px;
    max-width: 350px;
    height: 250px;
    max-height: 300px;
    word-wrap: break-word;
}
</style>

<script>
import {
    v4 as uuid
} from 'uuid'

export default {
    data() {
        return {
            alert: false,
            prompt: false,
            todo: {
                uuid: null,
                subject: null,
                detail: null,
            },
            headertodo: 'Add ToDo',
            listtodo: [],
            namedLocStorage: 'todoapplist',
            nameidxdb: 'todoapp',
            idx: null,
            timestamp: Date.now(),
            loading: false,
            isedit: 0,
            searching: '',
            justInfo: {
              time: null,
              location: 'Getting location...',
              weather: 'Getting weather...',
              temperature: 'Getting temperature'
            },
            interval: null
        }
    },

    computed: {

    },

    methods: {
        onSubmit() {
            this.$q.loading.show()
            const previewItem = {
                uuid: uuid(),
                todo: {
                    subject: this.todo.subject,
                    detail: this.todo.detail,
                },
                marked: 0,
                markedtime: this.timestamp,
                created: this.timestamp,
                lastupdate: this.timestamp
            }

            if (this.isedit) {
                this.onUpdate(this.todo.uuid, 0)
                return
            }

            const transaction = this.idx.transaction([this.nameidxdb], "readwrite");
            transaction.onerror = (event) => {
                this.$q.notify({
                    color: 'negative',
                    position: 'top',
                    timeout: 3000,
                    closeBtn: true,
                    attrs: {
                        role: 'alertdialog'
                    },
                    message: 'Error adding todo, try again',
                    icon: 'report_problem'
                })
            }
            const objectStore = transaction.objectStore(this.nameidxdb);
            const objectStoreRequest = objectStore.add(previewItem);

            this.prompt = false
            this.$q.loading.hide()
            objectStoreRequest.onsuccess = (event) => {
                this.$q.notify({
                    color: 'positive',
                    position: 'top',
                    timeout: 3000,
                    closeBtn: true,
                    attrs: {
                        role: 'alertdialog'
                    },
                    message: 'Successfully added new todo, thankyou',
                    icon: 'report_problem'
                })
            }
            this.onRead()
            this.todo.subject = null
            this.todo.detail = null
        },

        onRead(id) {
            this.$q.loading.show()

            const transaction = this.idx.transaction([this.nameidxdb], "readonly");
            const objectStore = transaction.objectStore(this.nameidxdb);

            if (id) {
                objectStore.get(id).onsuccess = (event) => {
                    this.prompt = true
                    const result = event.target.result
                    this.todo.subject = result.todo.subject
                    this.todo.detail = result.todo.detail
                    this.todo.uuid = result.uuid
                    this.headertodo = 'Detail ToDo'
                }
            }

            objectStore.getAll().onsuccess = (event) => {
                this.listtodo = event.target.result
            }

            this.$q.loading.hide()
        },

        onUpdate(id, marked) {
            const objectStore = this.idx.transaction([this.nameidxdb], "readwrite").objectStore(this.nameidxdb);
            const request = objectStore.get(id)

            request.onsuccess = (event) => {
                const todo = request.result

                if (!marked) {
                    todo.todo.subject = this.todo.subject
                    todo.todo.detail = this.todo.detail
                } else {
                    if (!todo.marked) {
                        todo.marked = 1
                        todo.markedtime = this.timestamp
                    } else {
                        this.$q.notify({
                            color: 'positive',
                            position: 'top',
                            timeout: 3000,
                            closeBtn: true,
                            attrs: {
                                role: 'alertdialog'
                            },
                            message: 'Already marked done',
                            icon: 'report_problem'
                        })
                        return
                    }
                }

                const updateRequest = objectStore.put(todo)
                updateRequest.onsuccess = (event) => {
                    this.$q.notify({
                        color: 'positive',
                        position: 'top',
                        timeout: 3000,
                        closeBtn: true,
                        attrs: {
                            role: 'alertdialog'
                        },
                        message: !marked ? 'Successfully edit todo, thankyou' : 'Marked DONE',
                        icon: 'report_problem'
                    })
                    this.onRead()
                    this.prompt = false
                    this.todo.subject = ''
                    this.todo.detail = ''
                }
            }

            this.$q.loading.hide()
        },

        onDelete(id) {
            this.$q.loading.show()

            const transaction = this.idx.transaction([this.nameidxdb], "readwrite")
            const objectStore = transaction.objectStore(this.nameidxdb).delete(id)

            objectStore.onsuccess = () => {
                this.$q.notify({
                    color: 'positive',
                    position: 'top',
                    timeout: 3000,
                    closeBtn: true,
                    attrs: {
                        role: 'alertdialog'
                    },
                    message: 'Delete success!',
                    icon: 'report_problem'
                })
                this.onRead()
                this.$q.loading.hide()
            }

        },

        onSearch() {
            const transaction = this.idx.transaction([this.nameidxdb], "readonly")
            const objectStore = transaction.objectStore(this.nameidxdb)

            objectStore.getAll().onsuccess = (event) => {
                const filter = [this.searching]
                //const filtered = event.target.result.filter(i => filter.includes(i['todo']['subject']) )
                const filtered = event.target.result.filter(i => new RegExp(filter.join('|')).test(i['todo']['subject']) || new RegExp(filter.join('|')).test(i['todo']['detail']))
                if (filtered.length > 0) {
                    this.listtodo = filtered
                }
            }

        },

        setIndexedDB() {
            const request = indexedDB.open(this.nameidxdb, 1);

            request.onsuccess = (event) => {
                const db = request.result
                this.idx = db
                this.onRead()
            }

            request.onupgradeneeded = (event) => {
                const db = event.target.result

                const objectStore = db.createObjectStore(this.nameidxdb, {
                    keyPath: 'uuid'
                })

                objectStore.createIndex('uuid', 'uuid', {
                    unique: true
                })
            }

        },

        anotherTimeInfo () {
          this.$axios({
            method: 'get',
            timeout: 5000,
            url: 'http://worldtimeapi.org/api/ip',
          })
          .then((response) => {
            this.justInfo.time = this.$helper.stamp2human(response.data.datetime)
          })
        },

        anotherLocationInfo () {
          this.$axios({
            method: 'get',
            timeout: 5000,
            url: 'http://ip-api.com/json/',
          })
          .then((response) => {
            this.justInfo.location = response.data.country + ', ' + response.data.city
            this.anotherTemperatureInfo(response.data.lat, response.data.lon)
          })
        },

        anotherTemperatureInfo (lat,lon){
          this.$axios({
            method: 'get',
            timeout: 5000,
            url: 'https://api.open-meteo.com/v1/forecast?latitude=' + lat + '&longitude=' + lon + '&hourly=temperature_2m&timezone=Asia%2FSingapore&forecast_days=1',
          })
          .then((response) => {
            this.justInfo.temperature = response.data.hourly.temperature_2m[0] + '°C'
          })
        }
    },

    created(){
      this.interval = setInterval(() => {
        this.anotherTimeInfo()
      },60000)
    },

    mounted() {
        this.anotherTimeInfo()
        this.anotherLocationInfo()
        this.setIndexedDB()
    },

    watch: {
        searching: function (val) {
            if (val.length > 1) {
                this.onSearch()
            } else {
                this.onRead()
            }
        }
    }
}
</script>
