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
[ Vue 2 ]: https://v2.vuejs.org/v2/guide/
[ Laravel 8 ]: https://laravel.com/docs/8.x
[Docsy user guide]: https://docsy.dev/docs
[Docsy]: https://github.com/google/docsy
[example.docsy.dev]: https://example.docsy.dev
[Hugo theme]: https://www.mikedane.com/static-site-generators/hugo/installing-using-themes/
[Netlify]: https://netlify.com
