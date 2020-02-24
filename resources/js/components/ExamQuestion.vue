<template>

    <!-- Numbers -->
    <div class="d-flex align-items-start align-items-md-stretch flex-column-reverse flex-md-row" style="min-height:100vh;">
        <div class="col-12 col-md-2 col-xl-1">
            <div class="card mt-3" style="max-height: 90vh">
                <!-- Header -->
                <div class="card-header px-2 text-center">Number</div>

                <div class="card-body p-0 overflow-auto">
                    <!-- Number List Container -->
                    <nav class="nav nav-pills nav-fill p-1">
                        <!-- Number Items -->
                        <a href="#" class="nav-item btn mr-1 mb-1 btn-num"
                            v-for="(question, index) in questions" :key="index"
                            :class="[
                                index + 1 == current_number ? 'btn-primary active' :
                                    ( is_answered(index) ? 'list-group-item-success':
                                        (is_marked(index) ? 'list-group-item-warning':'btn-outline-secondary')),
                                is_marked(index) ? 'border-left-warning':'',
                            ]"
                            @click="show_question(index)"
                            >{{ question.number }}</a>
                    </nav>

                </div>
            </div>
        </div>

        <!-- Question -->
        <div class="col-md-10 col-xl-11">
            <div class="card mt-3" style="min-height: 90vh">

                <!-- Header -->
                <div class="card-header">
                    <div class="d-flex flex-sm-row flex-column align-items-center">
                        <div class="d-flex flex-column flex-fill mb-sm-0 mb-2">
                            <h4>{{ sublevelTitle }}</h4>
                            <small>{{ courseTitle }} - {{ levelTitle }}</small>
                        </div>
                        <hr class="d-block d-sm-none w-100 my-1">
                        <div class="spinner-border text-primary mx-4 my-sm-0 my-3" role="status" v-if="is_loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="d-flex flex-row flex-sm-column align-items-center mb-sm-0 mb-2">
                            <b :class="'text-'+time_status"><i class="fas fa-stopwatch mr-2"></i>{{ time_left }}</b>
                            <hr class="my-1 w-100 d-none d-sm-block">
                            <i class="fas fa-grip-lines-vertical d-sm-none d-block text-gray-300 mx-3"></i>
                            <small>{{ answered_count }}/{{ question_count }}</small>
                        </div>
                        <button name="submit" class="ml-sm-3 btn btn-primary mb-sm-0 mb-2" data-toggle="modal" data-target="#submitModal">Submit</button>
                    </div>
                </div>

                <!-- Question Body -->
                <div class="card-body">
                    <p>{{ question }}</p>
                    <div class="custom-control custom-radio" v-for="(choice, index) in choices" :key="index">
                        <input type="radio" class="custom-control-input" name="choice" :id="'choice'+index"
                               :value="choice.id" v-model="questions[current_number-1].answer.multiple_choice_id">
                        <label :for="'choice'+index" class="custom-control-label">{{ choice.answer }}</label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="card-footer d-flex flex-column-reverse flex-sm-row">
                    <button class="btn btn-primary ml-sm-3 my-2 px-4" @click="prev_question()" :disabled="!(current_number > 1)"
                            ><i class="mr-2 fas fa-chevron-left"></i>Previous</button>
                    <button class="btn btn-warning ml-sm-auto my-2 px-4" @click="mark_question()"
                            ><i class="mr-2 far fa-bookmark"></i>Mark</button>
                    <button class="btn btn-primary ml-sm-3 my-2 px-4" @click="next_question()" :disabled="!(current_number < question_count)"
                            ><i class="mr-2 fas fa-chevron-right"></i>Next</button>
                </div>
            </div>
        </div>

        <!-- Submit Modal -->
        <bs-modal modal-id="submitModal" title="Are You Sure Want to Submit the Exams">
            <p v-if="question_count == answered_count">There is still <b>{{ time_left }}</b> time left. You can use that time to check back your answer before submit the exams</p>
            <p v-else>There are still {{ question_count - answered_count }} question unanswered. Are you sure want to submit the exams ?</p>

            <p class="text-danger mb-0">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                After submitting an answer can not be changed
            </p>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form :action="examSubmitUrl" method="post" id="submitForm">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input type="hidden" name="report_id" :value="examId">
                    <button type="submit" class="btn btn-primary" name="action" value="Submit">Submit</button>
                </form>
            </template>
        </bs-modal>

        <!-- Times Up Modal -->
        <bs-modal modal-id="timesUpModal">
            <h1 class="d-block text-center text-danger">
                <b><i class="far fa-clock"></i> Times Up</b>
            </h1>
            <template v-slot:footer>
                <div class="d-flex flex-row justify-content-center w-100">
                    <div class="spinner-border text-primary mx-4" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <h4>Submitting...</h4>
                </div>
            </template>
        </bs-modal>

    </div>
</template>

<script>
    export default {
        props: [
            'sublevelTitle',
            'levelTitle',
            'courseTitle',
            'examId',
            'examSubmitUrl',
            'examPrepareUrl',
            'examMarkQuestionUrl',
            'examAnswerUrl',
        ],
        data(){
            return {
                csrf_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                time_status: '',
                current_number: 1,
                is_loading: false,
                questions: null,
                time_left: null,
                time_limit: null,
                timer: null,
            }
        },
        computed: {
            question(){
                if (this.questions == null || this.questions == undefined) return ''
                return this.questions[this.current_number-1].question
            },
            choices(){
                if (this.questions == null || this.questions == undefined) return null
                return this.questions[this.current_number-1].choices
            },
            question_count(){
                if (this.questions == null || this.questions == undefined) return 0
                return this.questions.length
            },
            answered_count(){
                let total = 0
                if (this.questions != null && this.questions != undefined)
                    this.questions.forEach(question => {
                        if (question.answer.multiple_choice_id > 0) total++
                    });
                return total
            },
        },
        watch:{
            questions: {
                handler: function(newValue, oldValue){
                    console.log('question has changed')
                    if (oldValue != null) this.send_answer()
                },
                deep : true
            }
        },
        methods:{
            prepare_questions(){
                this.is_loading = true
                $.ajax({
                    url: this.examPrepareUrl,
                    type: 'GET',
                }).then(response => {
                    this.is_loading = false
                    this.questions = response.questions
                    this.time_limit = new Date(response.time_limit)
                    this.start_timer()
                    this.adjust_questions()
                }).catch(error => {
                    this.is_loading = false
                    console.log(error)
                })
            },
            start_timer(){
                let vm = this
                this.timer = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = vm.time_limit - now;

                    if (distance < 0) {
                        clearInterval(vm.timer);
                        $('#timesUpModal').modal('show')
                        $('#submitForm').submit()
                    }

                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    vm.time_left = (hours > 0 ? (hours + "h ") : '') +
                                   vm.pad(minutes, 2) + "m " +
                                   vm.pad(seconds, 2) + "s ";

                    vm.time_status = (minutes < 1) ? 'danger' : ((minutes < 5) ? 'warning': '')
                }, 1000);
            },
            pad(number, pad){
                var s = '000000000' + number
                return s.substr(s.length - pad)
            },
            mark_question(){
                this.questions[this.current_number-1].marked.status = this.questions[this.current_number-1].marked.status == 1 ? 0 : 1
                let action = this.questions[this.current_number-1].marked.status == 1 ? 'mark':'remove'
                this.send_mark(action)
            },
            send_mark(action){
                this.is_loading = true
                $.ajax({
                    url: this.examMarkQuestionUrl,
                    type: 'GET',
                    data: {
                        action: action,
                        number: this.questions[this.current_number-1].number
                    }
                }).then(response => {
                    this.is_loading = false
                    console.log(response)
                }).catch(error => {
                    this.is_loading = false
                    console.log(error)
                })
            },
            adjust_questions(){
                this.questions.forEach(question => {
                    if (question.answer == null || question.answer == undefined)
                        question.answer = { multiple_choice_id: 0 }
                    if (question.marked == null || question.marked == undefined)
                        question.marked = { status: 0 }
                });
            },
            send_answer(){
                this.is_loading = true
                let multiple_choice_id = this.questions[this.current_number-1].answer.multiple_choice_id
                if (multiple_choice_id <= 0) return
                let question_id = this.questions[this.current_number-1].id
                console.log('sending answer')
                $.ajax({
                    url: this.examAnswerUrl,
                    type: 'GET',
                    data: {
                        question_id: question_id,
                        multiple_choice_id: multiple_choice_id
                    }
                }).then(response => {
                    this.is_loading = false
                    console.log(response)
                }).catch(error => {
                    this.is_loading = false
                    console.log(error)
                })
            },
            show_question(index){
                this.current_number = index + 1
            },
            next_question(){
                if (this.current_number < this.question_count)
                this.current_number++
            },
            prev_question(){
                if (this.current_number > 1)
                this.current_number--
            },
            is_marked(index){
                if (this.questions != null)
                return this.questions[index].marked.status == 1
            },
            is_answered(index){
                if (this.questions != null)
                return  this.questions[index].answer.multiple_choice_id > 0
            }
        },
        mounted() {
            this.prepare_questions()
        }
    }

</script>

<style>

.btn-num {
    min-width: 3rem
}

</style>
