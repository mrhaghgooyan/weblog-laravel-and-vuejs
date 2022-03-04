<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Comments</h4>
                </div>
                <div v-if="comments.length > 0" content="comment-wrapper">
                    <!--Main Comment-->
                    <div v-for="(comment,key) in comments" :key="comment.id"  >
                        <div :id="'comment'+comment.id" :class="'media comment level1' ">
                            <img src="image/noimage.png" class="mr-3 rounded-circle" width="70" alt="Aloware Customers">
                            <div class="media-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-0">{{ comment.name }}</h5>
                                    <small class="text-muted">{{ comment.created_at }}</small>
                                </div>
                                <p>{{ comment.comment }}</p>
                                <a href="#replay_form" class="btn btn-link text-white" type="button"
                                   @click="replayTo($event,comment.id,`${comment.name}`)">
                                    Replay
                                </a>
                            </div>
                        </div>
                        <!--Level 2-->
                        <div v-if="comment.replies.length != 0">
                            <div v-for="replay in comment.replies" :key="replay.id">
                                <div :id="'comment'+replay.id" :class="'media comment level2' ">
                                    <img src="image/noimage.png" class="mr-3 rounded-circle" width="70" alt="Aloware Customers">
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mt-0">{{ replay.name }}</h5>
                                            <small class="text-muted">{{ replay.created_at }}</small>
                                        </div>
                                        <p>{{ replay.comment }}</p>

                                        <a  href="#replay_form" class="btn btn-link text-white" type="button"
                                            @click="replayTo($event,replay.id,`${replay.name}`)">
                                            Replay
                                        </a>
                                    </div>
                                </div>
                                <!--Level 3-->
                                <div v-if="replay.replies.length != 0">
                                    <div v-for="sub_replay in replay.replies" :key="sub_replay.id" class=" ml-5 ">
                                        <div :id="'comment'+sub_replay.id" :class="'media comment level3' ">
                                            <img src="image/noimage.png" class="mr-3 rounded-circle" width="70" alt="Aloware Customers">
                                            <div class="media-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="mt-0">{{ sub_replay.name }}</h5>
                                                    <small class="text-muted">{{ sub_replay.created_at }}</small>
                                                </div>
                                                <p>{{ sub_replay.comment }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--./Main Comment-->
                    </div>

                </div>
            </div>
        </div>

        <div class="w-100 p-5">
            <form id="replay_form" @submit.prevent="create" >
                <div class="form-row w-100">
                    <div class="col-md-6 mb-3">
                        <label for="">Your Name</label>
                        <input type="text" class="form-control is-valid" placeholder="Enter Your Name..." v-model="comment_form.name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationServer02">Replay To</label>
                        <input type="text" class="form-control is-valid" id="validationServer02" value=""  v-model="comment_form.parent_name" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Example textarea</label>
                    <textarea class="form-control"  rows="3" placeholder="How did you feel about this?" v-model="comment_form.comment"></textarea>
                </div>
                <button class="btn btn-success" type="submit">Submit form</button>
            </form>
        </div>

    </div>


</template>

<script>
export default {
    name:"comment",
    data(){
        return {
            comments : [],
            comment_form:{
                name:"",
                comment:"",
                parent_name:"",
                parent_id:null,
            },
        }
    },

    mounted(){
        this.getComments()
    },
    methods:{
        async getComments(){
            await this.axios.get('/api/comment').then(response=>{
                console.log(response.data)
                this.comments = response.data
                this.comment_form = {
                    name:"",
                    comment:"",
                    parent_name:"",
                    parent_id:null,
                }
            }).catch(error=>{
                console.log(error)
                this.comments = []
            })
        },
        async create(){
            console.log(this.comment_form)
            if (this.comment_form.name.length > 0 && this.comment_form.comment.length > 0){
                await this.axios.post('/api/comment',this.comment_form)
                    .then(response=>{
                        console.log(response.data)
                        this.comment_form = []
                        this.myAlert('success',response.data.message)
                        this.getComments();
                        // this.$router.push({name:"blog"})
                    })
                    .catch(
                        error=>{
                            this.myAlert("error","Something is Wrong , Please Check Your Name & Comment!")
                            console.log(error)
                        })
            } else {
                this.myAlert("warning","Your Name and Comment are Required!")
            }
        },
        replayTo(e,parent_id=null,name=null){
            this.comment_form.parent_id = parent_id;
            this.comment_form.parent_name = name;
        },
        myAlert(type,message){
            Swal.fire({
                title: `${type}!`,
                text: `${message}`,
                icon: `${type}`,
                confirmButtonText: 'OK'
            })
        }


    }
}
</script>

