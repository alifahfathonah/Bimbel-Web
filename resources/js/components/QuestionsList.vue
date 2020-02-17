<template>
    <div class="card border-left-info shadow h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="text-xl font-weight-bold text-info text-uppercase mb-1 flex-fill">
                            {{ sublevelTitle }}
                            <small class="d-block text-capitalize text-secondary">{{ courseTitle }} - {{ levelTitle }}</small>
                            <small class="d-block text-capitalize text-secondary">{{ questions_count_label }} Questions</small>
                        </div>
                        <div class="topbar-divider"></div>
                        <button class="btn btn-outline-info mx-1" v-on:click="collapse_all">
                            <i class="fas fa-angle-double-up"></i> Collapse All
                        </button>
                        <button class="btn btn-outline-info mx-1" v-on:click="expand_all">
                            <i class="fas fa-angle-double-down"></i> Expand All
                        </button>
                        <button class="btn btn-info mx-1" v-on:click="add_question">
                            <i class="fas fa-plus"></i> New Question
                        </button>

                        <button class="btn btn-info ml-1" v-on:click="save_changes" :disabled="!save_available() || is_saving">
                            <i class="fas fa-save"></i> {{ is_saving ? 'Saving..' : 'Save Changes'}}
                        </button>
                    </div>
                    <hr>

                    <div v-for="(question, q_index) in questions" :key="q_index" class="col px-0">

                        <div :class="'card shadow-sm my-3'+[is_error(q_index) ? ' border-left-danger' : ' border-left-success']">
                            <div class="d-flex flex-row align-items-center card-header py-0 px-3">
                                <a :href="'#q'+q_index" class="flex-fill text-decoration-none py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" :aria-controls="'q'+q_index">

                                    <h5 :class="'m-0'+[is_error(q_index) ? ' text-danger' : ' text-success ']">{{ 'Question ' + (q_index + 1) }}</h5>
                                </a>
                                <button class="btn btn-outline-info float-right mr-2 my-3" title="Move Up" @click="move_up_question(q_index)">
                                    <i class="fas fa-chevron-up"></i> Move Up
                                </button>

                                <button class="btn btn-outline-info float-right mr-2 my-3" title="Move Down" @click="move_down_question(q_index)">
                                    <i class="fas fa-chevron-down"></i> Move Down
                                </button>

                                <button class="btn btn-danger float-right mr-2 my-3" title="Delete" @click="remove_question(q_index)">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </div>

                            <div class="collapse show" :id="'q'+q_index">
                                <div class="card-body">
                                    <textarea name="question" :id="'question'+q_index" rows="2" placeholder="Question" class="form-control w-100" v-model="question.question"></textarea>
                                    <div v-for="(choice, c_index) in question.choices" :key="c_index">
                                        <div class="d-flex flex-row align-items-center my-2">
                                            <input type="checkbox" name="is_correct" tabindex="-1" v-model="choice.is_correct">
                                            <h5 class="my-0 mx-3">{{ toAlpha(c_index) }}</h5>
                                            <textarea name="answer" :class="'ml-2 form-control flex-fill ' + (choice.is_correct ? 'is-valid' : 'is-invalid')" rows="1" v-model="choice.answer"></textarea>
                                            <button class="btn text-gray-500" title="Remove" @click="remove_choice(q_index, c_index)" tabindex="-1">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button class="ml-5 text-small btn btn-link" @click="add_choice(q_index)"> + Add Choice</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['sublevelTitle', 'courseTitle', 'levelTitle', 'urlQuestionStore', 'urlQuestionIndex', 'sublevelId'],
        data() {
            return {
                questions: [],
                is_loading: false,
                is_saving: false
            }
        },
        methods: {
            add_question: function () {
                let index = this.questions.length
                this.questions.push({ question: '', choices: []})
                for (let i = 0; i < 4; i++) this.add_choice(index)
            },
            remove_question(question_index){
                this.questions.splice(question_index, 1)
                if (this.questions.length == 0)
                    this.add_question()
            },
            move_up_question(question_index){
                if (question_index == 0) return
                let rows = [this.questions[question_index-1], this.questions[question_index]]
                this.questions.splice(question_index, 2, rows[1], rows[0] )
            },
            move_down_question(question_index){
                if (question_index == this.questions.length - 1) return
                let rows = [this.questions[question_index], this.questions[question_index+1]]
                this.questions.splice(question_index, 2, rows[1], rows[0] )
            },
            add_choice(question_index){
                if (this.questions[question_index].choices.length == 26) return
                this.questions[question_index].choices.push({ answer:'', is_correct: false})
            },
            remove_choice(question_index, choice_index){
                this.questions[question_index].choices.splice(choice_index, 1)
                if (this.questions[question_index].choices.length == 0)
                    this.add_choice(question_index)
            },
            load_questions(){
                $.ajax({
                    url: this.urlQuestionIndex,
                    type: 'GET',
                }).then(response => {
                    if (response.questions == null || response.questions == undefined) return
                    this.questions = response.questions
                    if (this.questions.length < 1) this.add_question()
                }).catch(error => {
                    if (this.questions.length < 1) this.add_question()
                        console.log(error)
                })
            },
            get_question_with_number(){
                let data = this.questions
                for (let q_index = 0; q_index < data.length; q_index++) {
                    data[q_index].number = q_index + 1
                    for (let c_index = 0; c_index < data[q_index].choices.length; c_index++) {
                        data[q_index].choices[c_index].order = c_index
                        if(data[q_index].choices[c_index].is_correct)
                            data[q_index].choices[c_index].is_correct = 1
                        else
                            data[q_index].choices[c_index].is_correct = 0

                    }
                }
                return data
            },
            save_changes(){
                this.is_saving = true
                let _token = $('meta[name="csrf-token"]').attr('content')
                let data = {
                    questions: this.get_question_with_number(),
                    _token: _token,
                    course_sublevel_id: this.sublevelId,
                }
                if (!this.save_available() || this.questions.length < 1)
                    return
                $.ajax({
                    url: this.urlQuestionStore,
                    type: 'POST',
                    data: data,
                    success: function(response){
                        console.log(response)
                        this.is_saving = false
                    },
                    error: function(response){
                        console.log(response)
                        this.is_saving = false
                    }
                }).done(data => {
                    this.is_saving = false
                })
            },
            expand_all(){
                $('.collapse').collapse('show')
            },
            collapse_all(){
                $('.collapse').collapse('hide')
            },
            save_available(){
                for (let index = 0; index < this.questions.length; index++) {
                    if (this.is_error(index)) return false
                }
                return true && this.questions.length > 0
            },
            is_error(question_index){
                if (this.questions[question_index].question == '') return true
                let correct_count = 0
                for (let choice of this.questions[question_index].choices){
                    if (choice.answer == '') return true
                    if (choice.is_correct) correct_count++
                }
                if (correct_count == 0) return true
                return false
            },
            swap_question(a, b){
                alert('swap q '+a+' with q' + b)
                let rows = [this.questions[a], this.questions[b]];
                this.questions.splice(index, 2, rows[1], rows[0] );
            },
            toAlpha(number){
                if      (number < 0)    return 'A'
                else if (number >= 26)  return 'Z'
                const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')
                return alphabet[number]
            },
        },
        computed: {
            questions_count_label() {
                return this.questions.length
            },
        },
        mounted() {
            this.load_questions()
        }
    }
</script>
