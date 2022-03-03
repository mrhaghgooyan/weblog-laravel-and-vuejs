# Weblog Single Page

[ Vue 2 ] and [ Laravel 8 ] Used to have a blog and comment system.

Step 1: Install fresh Laravel

```bash
composer create-project laravel/laravel <your-project-name>
```

Step 2: Config .env file

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbname
DB_USERNAME=username
DB_PASSWORD=password
```
Step 3 : this is a shortcut for create Migration , Model and Controller

```bash
php artisan make:model Comment -mcr
```
Step 4: Now it's time for create a migration for Comment Table

```bash
public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('comment');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->dropForeign('comments_parent_id_foreign');
        });
        Schema::dropIfExists('comments');
    }
```
===> Based on DB normalize version , we must create 2 Table and crate relations , But this method is practical.

Step 5: Run The Migration
```bash
php artisan migrate
```
Step 6: Setup Comment Model | Just fillable
```bash
protected $fillable = ['parent_id','name','comment'];
```
## Step 7 : Just One Query for Multi-level Comments
Setup Comment Controller
```bash
public function index()
    {
        $all_comments = Comment::orderBy('id','desc')->get();
        foreach ($all_comments as $comment){
            if ($comment->parent_id == null){
                $root_comment[] = $comment;
            }
        }
        $comment = self::commentsTree($root_comment,$all_comments);
        return response()->json($comment);

    }
    private static function commentsTree($root_comments,$all_comments){
        foreach ($root_comments as $comment){
            $comment->replies = $all_comments->where('parent_id', $comment->id);
            foreach ($comment->replies as $reply){
                $reply->replies = $all_comments->where('parent_id',$reply->id);
            }
        }
        return $root_comments;
    }
```
***
### UNIT & HTTP Test [ Summarized ]
Given that there are not many actions, a simple test was created to record the information
- Create a UNIT Test
```bash
php artisan make:test CommentTest --unit
```
now we are ready to test store method
```bash
public function test_store_comment(){
        $response = $this->post('api/comment',[
            'id'=>150,
            'parent_id'=>50,
            'name'=>'Farid HaghGooyan',
            'comment'=>'This is a Test',
            'created_at'=>'2022-03-03 22:19:46',
            'updated_at'=>null
        ]);
        $response->assertStatus(200);
    }
```


***
Step 8: Custom Routes

web.php
```bash
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
```

api.php
```bash
Route::resource('comment',App\Http\Controllers\CommentController::class)->only(['index','store','show','update','destroy']);

```

***
## Say Hello To VUE and Dependencies
Step 9: Laravel Vue UI
```bash
composer require laravel/ui
```
```bash
php artisan ui vue
```
*** Note that !!!
Pay attention to commands and versions to avoid the problem of overlapping versions
```bash
npm install vue@2.6.12
```
```bash
npm install vue-axios@3.2.2
```
```bash
npm install vue-router@3.4.9
```
```bash
npm install
```
```bash
npm run watch
```
Step 10: Initial Vue 2 in Laravel Blade
```bash

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>MrHaghGooyan | Comment System</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body>
    <div id="app">
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>
```
Step 11: VUE Components
Create these folders structure in .resource/js
Components
Components/App.vue
Components/comment
Components/comment/Index.vue
```bash
// App.vue
<template>
    <main>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>
<script>
export default {}
</script>
```
*** in these Components , we need a loop on comments object
```bash
// Index.vue
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


<script>
export default {}
</script>
```
Step 12: VUE Routes
Create routes.js in .resource/js/
```bash
const commentIndex = () => import('./components/comment/Index.vue' /* webpackChunkName: "resource/js/components/comment/Index" */)

export const routes = [
    {
        name: 'blog',
        path: '/',
        component: commentIndex
    },

]

```
Step 13: Sweetalert
edit app.js in .resource/js/
```bash
require('./bootstrap');
import vue from 'vue'
window.Vue = vue;

import App from './components/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});

```
Step 13: SweetAlert
add to app.balde.php
```bash
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
```
Step 14: Start Your App
```bash
npm run watch
```
```bash
php artisan serve
```


I hope it was useful,
Farid HaghGooyan
2022-03-04


[ Vue 2 ]: https://v2.vuejs.org/v2/guide/
[ Laravel 8 ]: https://laravel.com/docs/8.x

